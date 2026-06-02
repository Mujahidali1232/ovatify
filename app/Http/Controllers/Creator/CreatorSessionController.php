<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\CreatorSession;
use App\Models\CreatorSessionIdea;
use App\Models\SongGeneration;
use App\Models\MarketplaceAsset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Creator "Create a Session" pipeline.
 *
 * Backs the Figma flow:
 *   Upload your own content → Create a Session → Describe your idea (ideas) →
 *   Customize your track → Track Result → Track Mixing → Track Arrangement →
 *   Completed Mixed Summary → Set for Sale / Investment / Licensing.
 *
 * Each session is a creator's draft that progresses through `status` values
 * and finally publishes into a SongGeneration + MarketplaceAsset.
 */
class CreatorSessionController extends Controller
{
    /**
     * Create a new draft session ("Create a Session" screen).
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'overview' => 'nullable|string',
            'cover_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'file_type' => 'nullable|string|in:audio,video,illustration',
        ]);
        if ($validator->fails()) {
            return $this->validationError($validator->errors()->all());
        }

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('session_covers', 'public');
        }

        $session = CreatorSession::create([
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'overview' => $request->input('overview'),
            'cover_image' => $coverPath,
            'file_type' => $request->input('file_type', 'audio'),
            'status' => 'draft',
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->format($session),
        ], 201);
    }

    /**
     * List the creator's sessions, defaults to drafts (non-published).
     * ?status=draft|customizing|...|published   ?per_page=20  ?page=1
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = max(1, min(100, (int) $request->query('per_page', 20)));
        $q = CreatorSession::where('user_id', $request->user()->id)
            ->with('ideas')
            ->orderByDesc('updated_at');

        if ($status = $request->query('status')) {
            $q->where('status', $status);
        } else {
            $q->where('status', '!=', 'published');
        }

        $paginator = $q->paginate($perPage);

        return response()->json([
            'success' => true,
            'count' => $paginator->count(),
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'last_page' => $paginator->lastPage(),
            'data' => collect($paginator->items())->map(fn ($s) => $this->format($s)),
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) {
            return $this->notFound();
        }
        return response()->json([
            'success' => true,
            'data' => $this->format($session->load('ideas', 'publishedSong')),
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) {
            return $this->notFound();
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'overview' => 'nullable|string',
            'cover_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
        if ($validator->fails()) {
            return $this->validationError($validator->errors()->all());
        }

        if ($request->filled('title')) $session->title = $request->input('title');
        if ($request->filled('overview')) $session->overview = $request->input('overview');
        if ($request->hasFile('cover_image')) {
            if ($session->cover_image) {
                Storage::disk('public')->delete($session->cover_image);
            }
            $session->cover_image = $request->file('cover_image')->store('session_covers', 'public');
        }
        $session->save();

        return response()->json([
            'success' => true,
            'data' => $this->format($session),
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) {
            return $this->notFound();
        }
        if ($session->isPublished()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete a published session.',
            ], 422);
        }
        if ($session->cover_image) Storage::disk('public')->delete($session->cover_image);
        foreach ($session->ideas as $idea) {
            if ($idea->file_path) Storage::disk('public')->delete($idea->file_path);
        }
        $session->delete();
        return response()->json(['success' => true, 'message' => 'Session deleted.']);
    }

    // ----------------------------------------------------------------------
    //  Ideas (text / audio / document) — "Describe your idea" + idea screens
    // ----------------------------------------------------------------------

    public function addIdea(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:text,audio,document',
            'content' => 'required_if:type,text|nullable|string',
            'file' => 'required_unless:type,text|nullable|file|max:51200',
        ]);
        if ($validator->fails()) {
            return $this->validationError($validator->errors()->all());
        }

        $type = $request->input('type');
        $data = [
            'creator_session_id' => $session->id,
            'type' => $type,
        ];

        if ($type === 'text') {
            $data['content'] = $request->input('content');
        } else {
            $file = $request->file('file');
            $folder = $type === 'audio' ? 'session_audio_ideas' : 'session_document_ideas';
            $data['file_path'] = $file->store($folder, 'public');
            $data['original_filename'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getClientMimeType();
        }

        $idea = CreatorSessionIdea::create($data);

        // bump session status to 'ideas' if it was draft
        if ($session->status === 'draft') {
            $session->status = 'ideas';
            $session->save();
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatIdea($idea),
        ], 201);
    }

    public function listIdeas(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();
        return response()->json([
            'success' => true,
            'data' => $session->ideas->map(fn ($i) => $this->formatIdea($i))->values(),
        ]);
    }

    public function removeIdea(Request $request, int $id, int $ideaId): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();
        $idea = $session->ideas()->find($ideaId);
        if (!$idea) {
            return response()->json(['success' => false, 'message' => 'Idea not found.'], 404);
        }
        if ($idea->file_path) Storage::disk('public')->delete($idea->file_path);
        $idea->delete();
        return response()->json(['success' => true, 'message' => 'Idea removed.']);
    }

    // ----------------------------------------------------------------------
    //  Customize / Mix / Arrange / Finalize / Publish
    // ----------------------------------------------------------------------

    public function customize(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();

        $validator = Validator::make($request->all(), [
            'instrumental_type' => 'nullable|string|max:64',
            'genre' => 'nullable|string|max:64',
            'tempo' => 'nullable|integer|min:20|max:300',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        $session->fill($request->only(['instrumental_type', 'genre', 'tempo']));
        $session->status = 'customizing';
        $session->save();

        return response()->json(['success' => true, 'data' => $this->format($session)]);
    }

    /**
     * Save the mixing settings (Track Mixing screen).
     * Body: { tempo: 50, equalizer: { "64Hz": 0.4, "800Hz": 0.6, ... } }
     */
    public function mix(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();

        $validator = Validator::make($request->all(), [
            'tempo' => 'nullable|integer|min:20|max:300',
            'equalizer' => 'nullable|array',
            'equalizer.*' => 'numeric|between:0,1',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        $session->mix_settings = $request->only(['tempo', 'equalizer']);
        $session->status = 'mixing';
        $session->save();

        return response()->json(['success' => true, 'data' => $this->format($session)]);
    }

    /**
     * Save the arrangement timeline (Track Arrangement screen).
     * Body: { tempo: [...], beat: [...], vocals: [...], bass: [...] }
     */
    public function arrange(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();

        $session->arrangement = $request->only(['tempo', 'beat', 'vocals', 'bass']);
        $session->status = 'arranging';
        $session->save();

        return response()->json(['success' => true, 'data' => $this->format($session)]);
    }

    /**
     * Finalize the mix — "Completed Mixed Summary" screen.
     * Optionally accepts a final_audio file (the rendered output)
     * and metadata_review (e.g., { genre: 'R&B', bpm: 90 }).
     */
    public function finalize(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();

        $validator = Validator::make($request->all(), [
            'final_audio' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:204800',
            'metadata_review' => 'nullable|array',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        if ($request->hasFile('final_audio')) {
            if ($session->final_audio) Storage::disk('public')->delete($session->final_audio);
            $session->final_audio = $request->file('final_audio')->store('session_finals', 'public');
        }
        if ($request->has('metadata_review')) {
            $session->metadata_review = $request->input('metadata_review');
        }
        $session->status = 'completed';
        $session->save();

        return response()->json(['success' => true, 'data' => $this->format($session)]);
    }

    /**
     * Publish the session → creates a SongGeneration + (optional) MarketplaceAsset.
     *
     * Body:
     *   - sale_type: sale | investment | license | none (default none — just publish to library)
     *   - price, price_per_license, license_type, price_per_block, max_available_blocks, ...
     *     (only fields applicable to the chosen sale_type)
     *   - agreement: full text of the smart contract
     */
    public function publish(Request $request, int $id): JsonResponse
    {
        $session = $this->findOwned($request, $id);
        if (!$session) return $this->notFound();

        if ($session->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Session must be finalized before publishing.',
            ], 422);
        }
        if ($session->isPublished()) {
            return response()->json([
                'success' => false,
                'message' => 'Session is already published.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'agreement' => 'nullable|string',
            'sale_type' => 'nullable|in:sale,investment,license,none',
            // sale
            'price' => 'nullable|numeric|min:0',
            'preview_duration' => 'nullable|integer',
            // license
            'price_per_license' => 'nullable|numeric|min:0',
            'license_type' => 'nullable|string',
            'license_duration' => 'nullable|integer',
            // investment
            'price_per_block' => 'nullable|numeric|min:0',
            'max_available_blocks' => 'nullable|integer|min:1',
            'total_valuation' => 'nullable|numeric|min:0',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        DB::beginTransaction();
        try {
            // 1. Create the SongGeneration record (the actual published track).
            $song = SongGeneration::create([
                'user_id' => $session->user_id,
                'title' => $session->title ?? 'Untitled',
                'overview' => $session->overview,
                'description' => $session->overview,
                'genre' => $session->genre,
                'tempo' => (string) ($session->tempo ?? ''),
                'instrumental_type' => $session->instrumental_type,
                'cover_image' => $session->cover_image,
                'file' => $session->final_audio ?? $session->generated_audio,
                'agreements' => $request->input('agreement'),
                'file_type' => $session->file_type,
                'status' => 'uploaded',
            ]);

            // 2. Optionally create a MarketplaceAsset for sale/investment/license.
            $saleType = $request->input('sale_type', 'none');
            if ($saleType !== 'none') {
                $asset = MarketplaceAsset::create([
                    'user_id' => $session->user_id,
                    'song_generation_id' => $song->id,
                    'asset_type' => $session->file_type,
                    'title' => $song->title,
                    'thumbnail' => $session->cover_image,
                    'sale_type' => $saleType,
                    'price' => $request->input('price', 0),
                    'preview_duration' => $request->input('preview_duration'),
                    'price_per_license' => $request->input('price_per_license'),
                    'license_type' => $request->input('license_type'),
                    'license_duration' => $request->input('license_duration'),
                    'price_per_block' => $request->input('price_per_block'),
                    'max_available_blocks' => $request->input('max_available_blocks'),
                    'remaining_blocks' => $request->input('max_available_blocks'),
                    'total_valuation' => $request->input('total_valuation'),
                    'is_active' => true,
                ]);
            }

            $session->published_song_generation_id = $song->id;
            $session->published_at = now();
            $session->status = 'published';
            $session->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to publish session.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Session published.',
            'data' => $this->format($session->fresh(['ideas', 'publishedSong'])),
        ], 201);
    }

    // ----------------------------------------------------------------------
    //  Helpers
    // ----------------------------------------------------------------------

    protected function findOwned(Request $request, int $id): ?CreatorSession
    {
        return CreatorSession::where('user_id', $request->user()->id)->find($id);
    }

    protected function format(CreatorSession $session): array
    {
        $session->loadMissing('ideas');
        return [
            'id' => $session->id,
            'title' => $session->title,
            'overview' => $session->overview,
            'cover_image' => $session->cover_image ? url(Storage::url($session->cover_image)) : null,
            'file_type' => $session->file_type,
            'instrumental_type' => $session->instrumental_type,
            'genre' => $session->genre,
            'tempo' => $session->tempo,
            'mix_settings' => $session->mix_settings,
            'arrangement' => $session->arrangement,
            'metadata_review' => $session->metadata_review,
            'generated_audio' => $session->generated_audio ? url(Storage::url($session->generated_audio)) : null,
            'final_audio' => $session->final_audio ? url(Storage::url($session->final_audio)) : null,
            'status' => $session->status,
            'ideas' => $session->ideas->map(fn ($i) => $this->formatIdea($i))->values(),
            'published_song_generation_id' => $session->published_song_generation_id,
            'published_at' => $session->published_at?->toDateTimeString(),
            'created_at' => $session->created_at?->toDateTimeString(),
            'updated_at' => $session->updated_at?->toDateTimeString(),
        ];
    }

    protected function formatIdea(CreatorSessionIdea $idea): array
    {
        return [
            'id' => $idea->id,
            'type' => $idea->type,
            'content' => $idea->content,
            'file' => $idea->file_path ? url(Storage::url($idea->file_path)) : null,
            'original_filename' => $idea->original_filename,
            'file_size' => $idea->file_size,
            'mime_type' => $idea->mime_type,
            'created_at' => $idea->created_at?->toDateTimeString(),
        ];
    }

    protected function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Session not found or access denied.',
        ], 404);
    }

    protected function validationError(array $errors): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $errors,
        ], 422);
    }
}

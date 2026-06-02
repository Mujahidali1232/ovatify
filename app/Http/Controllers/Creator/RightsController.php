<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\SongGeneration;
use App\Models\TrackCollaborator;
use App\Models\AgreementTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Rights Management (Figma: Rights tab — creator).
 *
 * Endpoints support the "Rights Management Dashboard" + "View/Edit Agreement"
 * screens: list creator's tracks + their collaborators with role/% splits,
 * CRUD collaborators, view a track's agreement, edit it, upload a custom template.
 */
class RightsController extends Controller
{
    /**
     * List creator's published tracks for the project picker ("Choose the project").
     */
    public function projects(Request $request): JsonResponse
    {
        $tracks = SongGeneration::where('user_id', $request->user()->id)
            ->where('status', 'uploaded')
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'cover_image', 'genre', 'created_at']);

        return response()->json([
            'success' => true,
            'data' => $tracks->map(fn ($t) => [
                'id' => $t->id,
                'title' => $t->title,
                'cover_image' => $t->cover_image ? url(Storage::url($t->cover_image)) : null,
                'genre' => $t->genre,
                'created_at' => $t->created_at?->toDateTimeString(),
            ]),
        ]);
    }

    /**
     * Get a track's rights/agreement detail (collaborators list + agreement templates).
     */
    public function project(Request $request, int $songId): JsonResponse
    {
        $song = SongGeneration::where('user_id', $request->user()->id)
            ->where('id', $songId)
            ->first();
        if (!$song) {
            return response()->json(['success' => false, 'message' => 'Track not found.'], 404);
        }

        $collaborators = TrackCollaborator::where('song_generation_id', $song->id)
            ->with('user:id,username,profile_image')
            ->get();

        // System + user-uploaded agreement templates (Figma: Agreement Templates section).
        $templates = AgreementTemplate::active()
            ->where(function ($q) use ($request) {
                $q->where('is_system', true)
                    ->orWhere('user_id', $request->user()->id);
            })
            ->orderBy('is_system', 'desc')
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'category', 'type', 'is_system']);

        return response()->json([
            'success' => true,
            'data' => [
                'track' => [
                    'id' => $song->id,
                    'title' => $song->title,
                    'cover_image' => $song->cover_image ? url(Storage::url($song->cover_image)) : null,
                    'agreement' => $song->agreements,
                ],
                'collaborators' => $collaborators->map(fn ($c) => $this->formatCollaborator($c)),
                'splits' => $this->splitsBreakdown($collaborators),
                'agreement_templates' => $templates,
            ],
        ]);
    }

    /**
     * Add a collaborator to a track. Either link an existing user (by user_id) or
     * record an external collaborator (just name + role + %).
     */
    public function addCollaborator(Request $request, int $songId): JsonResponse
    {
        $song = $this->findOwnedTrack($request, $songId);
        if (!$song) return $this->notFound();

        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string|max:500',
            'role' => 'required|in:artist,producer,writer,mixer,other',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        // Enforce sum <= 100 across all collaborators on this track.
        $currentSum = TrackCollaborator::where('song_generation_id', $song->id)->sum('percentage');
        if ($currentSum + (float) $request->input('percentage') > 100.0001) {
            return response()->json([
                'success' => false,
                'message' => 'Total percentages would exceed 100%.',
            ], 422);
        }

        $collab = TrackCollaborator::create([
            'song_generation_id' => $song->id,
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'avatar' => $request->input('avatar'),
            'role' => $request->input('role'),
            'percentage' => $request->input('percentage'),
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->formatCollaborator($collab->load('user:id,username,profile_image')),
        ], 201);
    }

    public function updateCollaborator(Request $request, int $songId, int $id): JsonResponse
    {
        $song = $this->findOwnedTrack($request, $songId);
        if (!$song) return $this->notFound();

        $collab = TrackCollaborator::where('song_generation_id', $song->id)->find($id);
        if (!$collab) {
            return response()->json(['success' => false, 'message' => 'Collaborator not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'role' => 'nullable|in:artist,producer,writer,mixer,other',
            'percentage' => 'nullable|numeric|min:0|max:100',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        if ($request->has('percentage')) {
            $newSum = TrackCollaborator::where('song_generation_id', $song->id)
                    ->where('id', '!=', $collab->id)
                    ->sum('percentage')
                + (float) $request->input('percentage');
            if ($newSum > 100.0001) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total percentages would exceed 100%.',
                ], 422);
            }
        }

        $collab->fill($request->only(['name', 'role', 'percentage']));
        $collab->save();

        return response()->json([
            'success' => true,
            'data' => $this->formatCollaborator($collab->fresh('user:id,username,profile_image')),
        ]);
    }

    public function removeCollaborator(Request $request, int $songId, int $id): JsonResponse
    {
        $song = $this->findOwnedTrack($request, $songId);
        if (!$song) return $this->notFound();

        $collab = TrackCollaborator::where('song_generation_id', $song->id)->find($id);
        if (!$collab) {
            return response()->json(['success' => false, 'message' => 'Collaborator not found.'], 404);
        }
        $collab->delete();

        return response()->json(['success' => true, 'message' => 'Collaborator removed.']);
    }

    /**
     * Update a track's attached agreement body (Edit Agreement screen).
     */
    public function updateAgreement(Request $request, int $songId): JsonResponse
    {
        $song = $this->findOwnedTrack($request, $songId);
        if (!$song) return $this->notFound();

        $validator = Validator::make($request->all(), [
            'agreement' => 'required|string',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        $song->agreements = $request->input('agreement');
        $song->save();

        return response()->json([
            'success' => true,
            'data' => ['track_id' => $song->id, 'agreement' => $song->agreements],
        ]);
    }

    /**
     * Upload a creator-custom agreement template ("Upload Creator Template").
     */
    public function uploadAgreementTemplate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:64',
            'type' => 'nullable|string|max:64',
            'body' => 'required|string',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        $template = AgreementTemplate::create([
            'name' => $request->input('name'),
            'slug' => \Illuminate\Support\Str::slug($request->input('name')) . '-' . substr(uniqid(), -6),
            'category' => $request->input('category', 'Custom'),
            'type' => $request->input('type', 'Legal Agreement'),
            'body' => $request->input('body'),
            'is_system' => false,
            'user_id' => $request->user()->id,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'data' => $template,
        ], 201);
    }

    // ---- helpers ----

    protected function findOwnedTrack(Request $request, int $songId): ?SongGeneration
    {
        return SongGeneration::where('user_id', $request->user()->id)->find($songId);
    }

    protected function formatCollaborator(TrackCollaborator $c): array
    {
        return [
            'id' => $c->id,
            'name' => $c->name,
            'role' => $c->role,
            'percentage' => (float) $c->percentage,
            'avatar' => $c->avatar
                ?: ($c->user && $c->user->profile_image
                    ? (str_starts_with($c->user->profile_image, 'http')
                        ? $c->user->profile_image
                        : url(Storage::url($c->user->profile_image)))
                    : null),
            'user' => $c->user ? [
                'id' => $c->user->id,
                'username' => $c->user->username,
            ] : null,
        ];
    }

    protected function splitsBreakdown($collaborators): array
    {
        $sum = $collaborators->sum('percentage');
        return [
            'total_percentage_assigned' => (float) $sum,
            'remaining' => max(0.0, 100.0 - (float) $sum),
            'distribution' => $collaborators->map(fn ($c) => [
                'name' => $c->name,
                'percentage' => (float) $c->percentage,
            ])->values(),
        ];
    }

    protected function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Track not found or access denied.',
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

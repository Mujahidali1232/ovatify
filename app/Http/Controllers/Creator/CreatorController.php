<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\MarketplaceAsset;
use App\Models\MarketplaceTransaction;
use App\Models\SongGeneration;
use App\Models\CreatorSession;
use App\Models\CollabRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\SunoApiService;
use Illuminate\Support\Facades\Http;

class CreatorController extends Controller
{
    protected $sunoService;

    public function __construct(SunoApiService $sunoService)
    {
        $this->sunoService = $sunoService;
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();

        try {
            // Per-medium counts
            $totalTracks = SongGeneration::where('user_id', $user->id)->where('file_type', 'audio')->count();
            $totalVideos = SongGeneration::where('user_id', $user->id)->where('file_type', 'video')->count();
            $totalIllustrations = SongGeneration::where('user_id', $user->id)->where('file_type', 'illustration')->count();

            // Figma stats row: Publishes / Drafts / Earnings
            $publishesCount = $totalTracks + $totalVideos + $totalIllustrations;
            $draftsCount = CreatorSession::where('user_id', $user->id)
                ->where('status', '!=', 'published')
                ->count();
            $earnings = (float) MarketplaceTransaction::where('seller_id', $user->id)
                ->where('status', 'completed')
                ->sum('seller_amount');

            // New Releases — creator's most recent published tracks (Figma cards).
            $newReleases = SongGeneration::where('user_id', $user->id)
                ->where('status', 'uploaded')
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            // Pending incoming collab requests count (drives the "Collab Requests" section badge).
            $pendingCollabsCount = CollabRequest::where('to_user_id', $user->id)
                ->where('status', 'pending')
                ->count();

            // Creative Workspace — the AI-tool quick-link cards on home.
            $creativeWorkspace = [
                ['slug' => 'beat-expansion',  'name' => 'Beat Expansion',  'tool' => 'melody-generator'],
                ['slug' => 'lyric-assistance', 'name' => 'Lyric Assistance', 'tool' => 'lyric-generator'],
                ['slug' => 'vocal-enhancer',  'name' => 'Vocal Enhancer',  'tool' => 'vocal-enhancer'],
                ['slug' => 'hook-generator',  'name' => 'Hook Generator',  'tool' => 'hook-generator'],
                ['slug' => 'genre-matcher',   'name' => 'Genre Matcher',   'tool' => 'genre-matcher'],
                ['slug' => 'mood-analyzer',   'name' => 'Mood Analyzer',   'tool' => 'mood-analyzer'],
                ['slug' => 'mixing-assistant','name' => 'AI Mixing Assistant', 'tool' => 'mixing-assistant'],
                ['slug' => 'mastering-tool',  'name' => 'Mastering Tool',  'tool' => 'mastering-tool'],
            ];

            // Recent pending collab requests (so home can render the preview cards directly).
            $collabRequests = CollabRequest::where('to_user_id', $user->id)
                ->where('status', 'pending')
                ->with('fromUser:id,username,profile_image,is_verified', 'song:id,title,cover_image')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'title' => $r->title,
                        'role' => $r->role,
                        'created_at' => $r->created_at?->toDateTimeString(),
                        'from' => $r->fromUser ? [
                            'id' => $r->fromUser->id,
                            'username' => $r->fromUser->username,
                            'profile_image' => $r->fromUser->profile_image
                                ? (str_starts_with($r->fromUser->profile_image, 'http')
                                    ? $r->fromUser->profile_image
                                    : url(Storage::url($r->fromUser->profile_image)))
                                : null,
                            'is_verified' => (bool) $r->fromUser->is_verified,
                        ] : null,
                        'song' => $r->song ? [
                            'id' => $r->song->id,
                            'title' => $r->song->title,
                            'cover_image' => $r->song->cover_image ? url(Storage::url($r->song->cover_image)) : null,
                        ] : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'publishes_count' => $publishesCount,
                    'drafts_count' => $draftsCount,
                    'earnings' => $earnings,
                    'pending_collab_requests_count' => $pendingCollabsCount,
                    'total_tracks' => $totalTracks,
                    'total_videos' => $totalVideos,
                    'total_illustrations' => $totalIllustrations,
                    'new_releases' => MediaResource::collection($newReleases),
                    'creative_workspace' => $creativeWorkspace,
                    'collab_requests' => $collabRequests,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch dashboard data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function generateSongUsingAI(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'prompt' => 'required|string',
            'genre' => 'required|string|max:100',
            'instrumentation' => 'required|string|max:100',
            'tempo' => 'required|numeric|min:20|max:200',
            'gender' => 'nullable|string|in:m,f',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        try {
            $prompt = $request->input('prompt') . ' Instrumentation: ' . $request->input('instrumentation') . ' Tempo: ' . $request->input('tempo') . ' BPM';
            // Simulate song generation process
            $generationResult = $this->sunoService->generateMusic(
                $prompt,
                $request->input('genre'),
                $request->input('title'),
                null,
                $request->input('gender') ?? 'm'
            );

            return response()->json([
                'success' => true,
                'message' => 'Song generation initiated successfully.',
                'data' => $generationResult
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Song generation failed.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function getGenerationStatus($generationId)
    {

        try {
            $status = $this->sunoService->getGenerationStatus($generationId);

            // Safely get sunoData array
            $sunoData = data_get($status, 'data.response.sunoData', []);

            // Extract only required fields
            $audioData = collect($sunoData)->map(function ($item) {
                return [
                    'audioUrl' => $item['audioUrl'] ?? null,
                    'sourceAudioUrl' => $item['sourceAudioUrl'] ?? null,
                    'streamAudioUrl' => $item['streamAudioUrl'] ?? null,
                    'sourceStreamAudioUrl' => $item['sourceStreamAudioUrl'] ?? null,
                ];
            })->values();

            return response()->json([
                'success' => true,
                'data' => $audioData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadSong(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'audio' => 'required',
            'cover_image' => 'required|file|mimes:jpg,jpeg,png,webp',
            'title' => 'required|string|max:255',
            'overview' => 'required|string',
            'prompt' => 'required|string',
            'genre' => 'required|string|max:100',
            'instrumentation' => 'required|string|max:100',
            'tempo' => 'required|numeric|min:20|max:200',
            'agreement_type' => 'required|string|max:255',
            'agreement' => 'required|string',
            'taskId' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validated->errors()->all()
            ], 422);
        }

        $tempAudioPath = null;

        try {
            DB::beginTransaction();

            /** ---------------- AUDIO HANDLING ---------------- */
            if ($request->hasFile('audio')) {
                // Normal file upload
                $audioFile = $request->file('audio');
            } else {
                // Audio is URL
                if (!filter_var($request->audio, FILTER_VALIDATE_URL)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid audio URL'
                    ], 422);
                }

                $audioResponse = Http::get($request->audio);

                if (!$audioResponse->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to download audio file'
                    ], 422);
                }

                // Create temp file
                $tempAudioPath = tempnam(sys_get_temp_dir(), 'audio_');
                file_put_contents($tempAudioPath, $audioResponse->body());

                $audioFile = new \Illuminate\Http\UploadedFile(
                    $tempAudioPath,
                    basename(parse_url($request->audio, PHP_URL_PATH)),
                    $audioResponse->header('Content-Type'),
                    null,
                    true
                );
            }

            $coverFile = $request->file('cover_image');

            /** ---------------- FILE PATHS ---------------- */
            $userFolder = 'creator/' . $request->user()->id;
            $audioFilename = time() . '_' . $audioFile->getClientOriginalName();
            $coverFilename = time() . '_' . $coverFile->getClientOriginalName();

            $audioPath = $userFolder . '/audio/' . $audioFilename;
            $coverPath = $userFolder . '/covers/' . $coverFilename;

            /** ---------------- DB INSERT ---------------- */
            $song = SongGeneration::create([
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'overview' => $request->overview,
                'description' => $request->prompt,
                'genre' => $request->genre,
                'instrumental_type' => $request->instrumentation,
                'tempo' => $request->tempo,
                'agreement_type' => $request->agreement_type,
                'agreements' => $request->agreement,
                'file' => $audioPath,
                'cover_image' => $coverPath,
                'file_type' => 'audio',
                'status' => 'uploaded',
                'taskId' => $request->taskId,
            ]);

            /** ---------------- STORAGE ---------------- */
            Storage::disk('public')->putFileAs(
                $userFolder . '/audio',
                $audioFile,
                $audioFilename
            );

            Storage::disk('public')->putFileAs(
                $userFolder . '/covers',
                $coverFile,
                $coverFilename
            );

            DB::commit();

            /** ---------------- CLEAN TEMP FILE ---------------- */
            if ($tempAudioPath && file_exists($tempAudioPath)) {
                unlink($tempAudioPath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Song uploaded successfully.',
                'media_id' => $song->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Clean temp file on failure
            if ($tempAudioPath && file_exists($tempAudioPath)) {
                unlink($tempAudioPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Song upload failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadVideo(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'video' => 'required|file|mimes:mp4,mov,avi',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validated->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            if (!$request->hasFile('video')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No video file provided.'
                ], 400);
            }

            $file = $request->file('video');
            $filename = time() . '_' . $file->getClientOriginalName();

            // User specific folder: creator/{user_id}
            $userFolder = 'creator/' . $request->user()->id;
            $videoPath = $userFolder . '/video/' . $filename;

            // First insert DB record
            $song = SongGeneration::create([
                'user_id' => $request->user()->id,
                'title' => 'Uploaded Video ' . time(),
                'file' => $videoPath,
                'file_type' => 'video',
                'status' => 'uploaded',
            ]);

            // If DB insert successful, then store file
            if (!$song) {
                return response()->json([
                    'success' => false,
                    'message' => 'Database insertion failed'
                ], 500);
            }

            $stored = $file->storeAs($userFolder, $filename, 'public');

            if (!$stored) {
                return response()->json([
                    'success' => false,
                    'message' => 'File upload failed'
                ], 500);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully.',
                'media_id' => $song->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Video upload failed.',
                'error' => $e->getMessage()
            ], 500);
        }


    }

    public function uploadIllustration(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'illustration' => 'required|file|mimes:jpg,jpeg,png,webp,ai,psd',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validated->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            if (!$request->hasFile('illustration')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No illustration file provided.'
                ], 400);
            }

            $file = $request->file('illustration');
            $filename = time() . '_' . $file->getClientOriginalName();

            // User specific folder: creator/{user_id}
            $userFolder = 'creator/' . $request->user()->id;
            $videoPath = $userFolder . '/illustration/' . $filename;

            // First insert DB record
            $song = SongGeneration::create([
                'user_id' => $request->user()->id,
                'title' => 'Uploaded Illustration ' . time(),
                'file' => $videoPath,
                'file_type' => 'illustration',
                'status' => 'uploaded',
            ]);

            // If DB insert successful, then store file
            if (!$song) {
                return response()->json([
                    'success' => false,
                    'message' => 'Database insertion failed'
                ], 500);
            }

            $stored = $file->storeAs($userFolder, $filename, 'public');

            if (!$stored) {
                return response()->json([
                    'success' => false,
                    'message' => 'File upload failed'
                ], 500);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Illustration uploaded successfully.',
                'media_id' => $song->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Illustration upload failed.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function uploadMediaForSale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media_id' => 'required|exists:song_generations,id',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,webp',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'string|max:255',
            'asset_type' => 'required|in:video,audio,illustration',
            'preview_duration' => 'nullable|string|in:30,60,90,120,full',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $user = $request->user();

            // Ensure media belongs to user
            $media = SongGeneration::where('id', $request->media_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Base marketplace asset data
            $assetData = [
                'user_id' => $user->id,
                'song_generation_id' => $media->id,
                'asset_type' => $request->asset_type,
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'sale_type' => 'sale',
                'tags' => $request->filled('tags') ? $request->tags : null,
                'preview_duration' => $request->preview_duration,
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbFile = $request->file('thumbnail');
                $thumbName = 'thumb_' . now()->timestamp . '.' . $thumbFile->extension();

                $thumbFolder = "creator/sale/{$user->id}/thumbnails";
                $thumbPath = $thumbFile->storeAs($thumbFolder, $thumbName, 'public');

                if (!$thumbPath) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Thumbnail upload failed'
                    ], 500);
                }

                $assetData['thumbnail'] = $thumbPath;
            }

            // Create marketplace asset
            $marketplaceAsset = MarketplaceAsset::create($assetData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Asset listed for sale successfully.',
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Media not found.'
            ], 404);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to list asset for sale.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadMediaForInvestment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media_id' => 'required|exists:song_generations,id',
            'total_valuation' => 'required|numeric|min:0',
            'ownership_block' => 'required|integer|min:1',
            'price_per_block' => 'required|numeric|min:0',
            'available_blocks' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'asset_type' => 'required|in:video,audio,illustration',
            'total_investment' => 'required|numeric|min:0',
            'max_earning' => 'required|numeric|min:0',
            'investment_roi' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $user = $request->user();

            // Ensure media belongs to user
            $media = SongGeneration::where('id', $request->media_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Base marketplace asset data
            $assetData = [
                'user_id' => $user->id,
                'song_generation_id' => $media->id,
                'asset_type' => $request->asset_type,
                'title' => $request->title,
                'description' => $request->description,
                'total_investment' => $request->total_investment,
                'max_earning' => $request->max_earning,
                'investment_roi' => $request->investment_roi,
                'sale_type' => 'investment',
                'total_valuation' => $request->total_valuation,
                'ownership_block' => $request->ownership_block,
                'price_per_block' => $request->price_per_block,
                'max_available_blocks' => $request->available_blocks,
                'remaining_blocks' => $request->available_blocks,
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbFile = $request->file('thumbnail');
                $thumbName = 'thumb_' . now()->timestamp . '.' . $thumbFile->extension();

                $thumbFolder = "creator/investment/{$user->id}/thumbnails";
                $thumbPath = $thumbFile->storeAs($thumbFolder, $thumbName, 'public');

                if (!$thumbPath) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Thumbnail upload failed'
                    ], 500);
                }

                $assetData['thumbnail'] = $thumbPath;
            }

            // Create marketplace asset
            MarketplaceAsset::create($assetData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Asset listed for investment successfully.'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Media not found.'
            ], 404);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to list asset for investment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadMediaForLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media_id' => 'required|exists:song_generations,id',
            'license_type' => 'required|string|max:255',
            'price_per_license' => 'required|numeric|min:0',
            'license_duration' => 'required|integer|min:1',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'asset_type' => 'required|in:video,audio,illustration',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $user = $request->user();

            // Ensure media belongs to user
            $media = SongGeneration::where('id', $request->media_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Base marketplace asset data
            $assetData = [
                'user_id' => $user->id,
                'song_generation_id' => $media->id,
                'asset_type' => $request->asset_type,
                'title' => $request->title,
                'description' => $request->description,
                'sale_type' => 'license',
                'license_type' => $request->license_type,
                'price_per_license' => $request->price_per_license,
                'license_duration' => $request->license_duration,
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbFile = $request->file('thumbnail');
                $thumbName = 'thumb_' . now()->timestamp . '.' . $thumbFile->extension();

                $thumbFolder = "creator/license/{$user->id}/thumbnails";
                $thumbPath = $thumbFile->storeAs($thumbFolder, $thumbName, 'public');

                if (!$thumbPath) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Thumbnail upload failed'
                    ], 500);
                }

                $assetData['thumbnail'] = $thumbPath;
            }

            // Create marketplace asset
            MarketplaceAsset::create($assetData);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Asset listed for licensing successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Media not found.'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to list asset for license.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function myTracks(Request $request){
        $user = $request->user();

        try{
            $tracks = SongGeneration::with('marketplaceAssets')->where('user_id', $user->id)
            ->whereNull('taskId')
            ->get();

            return response()->json([
                'success' => true,
                'data' => MediaResource::collection($tracks),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tracks.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function songsCreatedWithAI(Request $request){
        $user = $request->user();

        try{
            $tracks = SongGeneration::with('marketplaceAssets')->where('user_id', $user->id)
            ->whereNotNull('taskId')
            ->get();

            return response()->json([
                'success' => true,
                'data' => MediaResource::collection($tracks),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tracks.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function myTrackDetails(Request $request, $id){
        $user = $request->user();

        try{
            $track = SongGeneration::with('marketplaceAssets', 'user:id,username,email,profile_image,is_verified,bio')
                ->where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();

            // Tools used — distinct AI tools applied via any session that published this track.
            $toolsUsed = \App\Models\CreatorSession::where('user_id', $user->id)
                ->where('published_song_generation_id', $track->id)
                ->with('user') // ensure relation loaded for any downstream needs
                ->get()
                ->flatMap(fn ($s) => \App\Models\AiTask::where('creator_session_id', $s->id)
                    ->where('user_id', $user->id)
                    ->pluck('tool'))
                ->unique()
                ->values();

            $resp = (new MediaResource($track))->toArray($request);
            $resp['tools_used'] = $toolsUsed;

            return response()->json([
                'success' => true,
                'data' => $resp,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Track not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch track details.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * List an EXISTING (already uploaded) track to the marketplace.
     *
     * Backs the "List your track on QmeMarketplace" CTA from the Creator → My Tracks
     * screen, and the Track Details "List Track" button. Creates a MarketplaceAsset
     * row pointing at the existing SongGeneration, configured for the chosen sale type.
     *
     * Body:
     *   - sale_type: sale | investment | license  (required)
     *   - price                                  (sale)
     *   - preview_duration                       (sale, optional)
     *   - price_per_license, license_type, license_duration  (license)
     *   - total_valuation, price_per_block, max_available_blocks  (investment)
     *   - tags                                   (optional, array)
     */
    public function listExistingTrack(Request $request, int $songId)
    {
        $user = $request->user();
        $song = SongGeneration::where('user_id', $user->id)->find($songId);
        if (!$song) {
            return response()->json([
                'success' => false,
                'message' => 'Track not found or access denied.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'sale_type' => 'required|in:sale,investment,license',
            'price' => 'nullable|numeric|min:0',
            'preview_duration' => 'nullable|integer',
            'price_per_license' => 'nullable|numeric|min:0',
            'license_type' => 'nullable|string',
            'license_duration' => 'nullable|integer',
            'total_valuation' => 'nullable|numeric|min:0',
            'price_per_block' => 'nullable|numeric|min:0',
            'max_available_blocks' => 'nullable|integer|min:1',
            'tags' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        // Prevent listing the same track twice for the same sale_type.
        $exists = MarketplaceAsset::where('song_generation_id', $song->id)
            ->where('sale_type', $request->input('sale_type'))
            ->where('is_active', true)
            ->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This track is already listed for ' . $request->input('sale_type') . '.',
            ], 422);
        }

        try {
            $asset = MarketplaceAsset::create([
                'user_id' => $user->id,
                'song_generation_id' => $song->id,
                'asset_type' => $song->file_type ?? 'audio',
                'title' => $song->title,
                'thumbnail' => $song->cover_image,
                'tags' => $request->input('tags'),
                'description' => $song->description,
                'sale_type' => $request->input('sale_type'),
                'price' => $request->input('price'),
                'preview_duration' => $request->input('preview_duration'),
                'price_per_license' => $request->input('price_per_license'),
                'license_type' => $request->input('license_type'),
                'license_duration' => $request->input('license_duration'),
                'total_valuation' => $request->input('total_valuation'),
                'price_per_block' => $request->input('price_per_block'),
                'max_available_blocks' => $request->input('max_available_blocks'),
                'remaining_blocks' => $request->input('max_available_blocks'),
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Track listed on the marketplace.',
                'data' => [
                    'asset_id' => $asset->id,
                    'song_generation_id' => $song->id,
                    'sale_type' => $asset->sale_type,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to list track.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Download a creator's own track (audio / video / illustration source file).
     * Validates ownership before returning the storage URL.
     */
    public function downloadTrack(Request $request, $id)
    {
        $user = $request->user();

        try {
            $song = SongGeneration::where('user_id', $user->id)->findOrFail($id);

            if (!$song->file) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file associated with this track.',
                ], 404);
            }

            if (!Storage::disk('public')->exists($song->file)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not available on storage.',
                    'path' => $song->file,
                ], 404);
            }

            return response()->json([
                'success' => true,
                'download_url' => url(Storage::url($song->file)),
                'track' => [
                    'id' => $song->id,
                    'title' => $song->title,
                    'file_type' => $song->file_type,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Track not found or access denied.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Download failed.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}

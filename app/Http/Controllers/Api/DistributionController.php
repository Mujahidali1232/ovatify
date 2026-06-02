<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use App\Models\DspPlatform;
use App\Models\SongGeneration;
use App\Models\MarketplaceInvestment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Track Distribution (Spotify / YT Music / Tidal / ...).
 *
 * Used by:
 *   - Creators distributing their own tracks (Creator → My Tracks → Track Details → Distribute to DSPs)
 *   - Consumers distributing tracks they've invested in (Consumer → Investments → View Track → Distribute to DSPs)
 *
 * TODO: real DSP API integration (Spotify-for-Artists / DistroKid / SoundCloud API).
 * For now requests land as "pending" and are processed out-of-band by an admin/cron worker.
 */
class DistributionController extends Controller
{
    /**
     * Submit a new distribution request.
     */
    public function submit(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'song_generation_id' => 'required|exists:song_generations,id',
            'release_title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'isrc_code' => 'nullable|string|max:32',
            'cover_art' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'string|exists:dsp_platforms,slug',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $user = $request->user();
        $songId = (int) $request->input('song_generation_id');

        if (!$this->userMayDistribute($user->id, $songId)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have distribution rights for this track. You must own or have an active investment in it.',
            ], 403);
        }

        $coverPath = null;
        if ($request->hasFile('cover_art')) {
            $coverPath = $request->file('cover_art')->store('distribution_covers', 'public');
        }

        $req = DistributionRequest::create([
            'user_id' => $user->id,
            'song_generation_id' => $songId,
            'release_title' => $request->input('release_title'),
            'artist_name' => $request->input('artist_name'),
            'release_date' => $request->input('release_date'),
            'isrc_code' => $request->input('isrc_code'),
            'cover_art' => $coverPath,
            'platforms' => $request->input('platforms'),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Distribution submitted. Your track is queued for delivery to the selected platforms.',
            'data' => $this->formatRequest($req->load('songGeneration:id,title')),
        ], 201);
    }

    /**
     * List the current user's distribution requests.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = max(1, min(100, (int) $request->query('per_page', 20)));

        $paginator = DistributionRequest::where('user_id', $request->user()->id)
            ->with('songGeneration:id,title,cover_image')
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'count' => $paginator->count(),
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'last_page' => $paginator->lastPage(),
            'data' => collect($paginator->items())->map(fn ($r) => $this->formatRequest($r)),
        ]);
    }

    /**
     * Show status of a single distribution request.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $req = DistributionRequest::where('user_id', $request->user()->id)
            ->with('songGeneration:id,title,cover_image')
            ->find($id);

        if (!$req) {
            return response()->json([
                'success' => false,
                'message' => 'Distribution request not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatRequest($req),
        ]);
    }

    /**
     * Does this user have distribution rights on this song?
     * Allowed when:
     *   - User is the creator (song.user_id matches), OR
     *   - User has an active investment in any marketplace_asset attached to this song.
     */
    protected function userMayDistribute(int $userId, int $songId): bool
    {
        $song = SongGeneration::find($songId);
        if (!$song) {
            return false;
        }
        if ((int) $song->user_id === $userId) {
            return true;
        }

        return MarketplaceInvestment::where('user_id', $userId)
            ->where('payment_status', 'completed')
            ->where('is_active', true)
            ->whereHas('asset', fn ($q) => $q->where('song_generation_id', $songId))
            ->exists();
    }

    protected function formatRequest(DistributionRequest $req): array
    {
        return [
            'id' => $req->id,
            'song_generation_id' => $req->song_generation_id,
            'track' => $req->songGeneration ? [
                'id' => $req->songGeneration->id,
                'title' => $req->songGeneration->title,
                'cover_image' => $req->songGeneration->cover_image
                    ? url(Storage::url($req->songGeneration->cover_image))
                    : null,
            ] : null,
            'release_title' => $req->release_title,
            'artist_name' => $req->artist_name,
            'release_date' => $req->release_date?->toDateString(),
            'isrc_code' => $req->isrc_code,
            'cover_art' => $req->cover_art ? url(Storage::url($req->cover_art)) : null,
            'platforms' => $req->platforms ?? [],
            'status' => $req->status,
            'distributed_at' => $req->distributed_at?->toDateTimeString(),
            'error_message' => $req->error_message,
            'created_at' => $req->created_at?->toDateTimeString(),
        ];
    }
}

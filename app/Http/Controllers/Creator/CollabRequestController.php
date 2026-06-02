<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\CollabRequest;
use App\Models\SongGeneration;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Collab Requests (Figma: Home → Collab Requests section).
 *
 * Users send a collab request to another creator; the recipient can
 * Accept or Decline. The accept path optionally creates a TrackCollaborator row.
 */
class CollabRequestController extends Controller
{
    /**
     * Send a new collab request.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'to_user_id' => 'required|exists:users,id',
            'song_generation_id' => 'nullable|exists:song_generations,id',
            'title' => 'required|string|max:255',
            'role' => 'required|in:artist,producer,writer,vocals,mixer,other',
            'message' => 'nullable|string|max:2000',
        ]);
        if ($validator->fails()) return $this->validationError($validator->errors()->all());

        $fromUserId = $request->user()->id;
        if ((int) $request->input('to_user_id') === $fromUserId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot send a collab request to yourself.',
            ], 422);
        }

        $req = CollabRequest::create([
            'from_user_id' => $fromUserId,
            'to_user_id' => $request->input('to_user_id'),
            'song_generation_id' => $request->input('song_generation_id'),
            'title' => $request->input('title'),
            'role' => $request->input('role'),
            'message' => $request->input('message'),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->format($req->load('fromUser:id,username,profile_image,is_verified', 'toUser:id,username,profile_image', 'song:id,title,cover_image')),
        ], 201);
    }

    /**
     * Incoming collab requests (recipient view) — drives the Figma Home "Collab Requests" cards.
     *  ?status=pending|accepted|declined  ?per_page=20  ?page=1
     */
    public function incoming(Request $request): JsonResponse
    {
        $perPage = max(1, min(100, (int) $request->query('per_page', 20)));
        $status = $request->query('status', 'pending');

        $paginator = CollabRequest::where('to_user_id', $request->user()->id)
            ->where('status', $status)
            ->with('fromUser:id,username,profile_image,is_verified', 'song:id,title,cover_image')
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return $this->paginatedResponse($paginator);
    }

    /**
     * Outgoing collab requests (sender view).
     */
    public function outgoing(Request $request): JsonResponse
    {
        $perPage = max(1, min(100, (int) $request->query('per_page', 20)));
        $status = $request->query('status');

        $q = CollabRequest::where('from_user_id', $request->user()->id)
            ->with('toUser:id,username,profile_image,is_verified', 'song:id,title,cover_image')
            ->orderByDesc('created_at');
        if ($status) $q->where('status', $status);

        return $this->paginatedResponse($q->paginate($perPage));
    }

    public function accept(Request $request, int $id): JsonResponse
    {
        $req = CollabRequest::where('to_user_id', $request->user()->id)->find($id);
        if (!$req) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }
        if ($req->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Request is no longer pending.',
            ], 422);
        }

        $req->status = 'accepted';
        $req->responded_at = now();
        $req->save();

        return response()->json([
            'success' => true,
            'message' => 'Collab request accepted.',
            'data' => $this->format($req->load('fromUser:id,username,profile_image,is_verified', 'song:id,title,cover_image')),
        ]);
    }

    public function decline(Request $request, int $id): JsonResponse
    {
        $req = CollabRequest::where('to_user_id', $request->user()->id)->find($id);
        if (!$req) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }
        if ($req->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Request is no longer pending.',
            ], 422);
        }

        $req->status = 'declined';
        $req->responded_at = now();
        $req->save();

        return response()->json([
            'success' => true,
            'message' => 'Collab request declined.',
            'data' => $this->format($req->fresh('fromUser:id,username,profile_image,is_verified', 'song:id,title,cover_image')),
        ]);
    }

    /**
     * Withdraw a sent request (only allowed while still pending).
     */
    public function withdraw(Request $request, int $id): JsonResponse
    {
        $req = CollabRequest::where('from_user_id', $request->user()->id)->find($id);
        if (!$req) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }
        if ($req->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot withdraw a request that is no longer pending.',
            ], 422);
        }
        $req->status = 'withdrawn';
        $req->responded_at = now();
        $req->save();

        return response()->json(['success' => true, 'message' => 'Collab request withdrawn.']);
    }

    // ---- helpers ----

    protected function format(CollabRequest $r): array
    {
        return [
            'id' => $r->id,
            'title' => $r->title,
            'role' => $r->role,
            'message' => $r->message,
            'status' => $r->status,
            'responded_at' => $r->responded_at?->toDateTimeString(),
            'created_at' => $r->created_at?->toDateTimeString(),
            'from' => $r->fromUser ? [
                'id' => $r->fromUser->id,
                'username' => $r->fromUser->username,
                'is_verified' => (bool) $r->fromUser->is_verified,
                'profile_image' => $r->fromUser->profile_image
                    ? (str_starts_with($r->fromUser->profile_image, 'http')
                        ? $r->fromUser->profile_image
                        : url(Storage::url($r->fromUser->profile_image)))
                    : null,
            ] : null,
            'to' => $r->toUser ? [
                'id' => $r->toUser->id,
                'username' => $r->toUser->username,
                'is_verified' => (bool) ($r->toUser->is_verified ?? false),
            ] : null,
            'song' => $r->song ? [
                'id' => $r->song->id,
                'title' => $r->song->title,
                'cover_image' => $r->song->cover_image ? url(Storage::url($r->song->cover_image)) : null,
            ] : null,
        ];
    }

    protected function paginatedResponse($paginator): JsonResponse
    {
        return response()->json([
            'success' => true,
            'count' => $paginator->count(),
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'last_page' => $paginator->lastPage(),
            'data' => collect($paginator->items())->map(fn ($r) => $this->format($r)),
        ]);
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

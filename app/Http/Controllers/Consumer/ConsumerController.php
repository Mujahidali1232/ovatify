<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Http\Resources\MarketplaceTransactionResource;
use App\Http\Resources\MediaResource;
use App\Models\SongGeneration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\MarketplacePurchase;
use App\Models\MarketplaceTransaction;
use Illuminate\Support\Facades\Storage;
use App\Models\MarketplaceLicense;
use App\Models\MarketplaceInvestment;
use Illuminate\Support\Facades\DB;


class ConsumerController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
            // Featured drops
            $featuredDrops = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', 'audio')
                ->withCount([
                    'marketplaceAssets as assets_count' => function ($query) {
                        $query->where('is_active', true);
                    }
                ])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->filter(function ($song) {
                    return $song->assets_count > 0;
                })
                ->values();

            $fourteenDaysAgo = now()->subDays(14);

            // Trending songs (last 14 days)
            $assetForInvestment = SongGeneration::query()
                ->with([
                    'user:id,username,email,profile_image,is_verified,bio',
                    'marketplaceAssets' => function ($q) {
                        $q->where('is_active', true)
                            ->where('sale_type', 'investment')
                            ->limit(1); // only one asset per song
                    }
                ])
                ->where('status', 'uploaded')
                ->where('file_type', 'audio')
                ->whereHas('marketplaceAssets', function ($q) {
                    $q->where('is_active', true)
                        ->where('sale_type', 'investment');
                })
                ->latest('created_at')
                ->limit(10)
                ->get();

            // All tracks (paginated)
            $perPage = max(1, min(100, (int) $request->query('per_page', 20)));
            $allTracksPaginator = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', 'audio')
                ->orderByDesc('created_at')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'featured_drops' => MediaResource::collection($featuredDrops),
                'investment_assets' => MediaResource::collection($assetForInvestment),
                'all_tracks' => MediaResource::collection($allTracksPaginator->items()),
                'pagination' => [
                    'total' => $allTracksPaginator->total(),
                    'page' => $allTracksPaginator->currentPage(),
                    'per_page' => $allTracksPaginator->perPage(),
                    'last_page' => $allTracksPaginator->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching dashboard data.',
                'error' => config('app.debug') ? $e->getMessage() : null,

            ]);
        }
    }

    public function trackDetails(int $id): JsonResponse
    {
        try {
            $asset = SongGeneration::query()
                ->with('user', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->findOrFail($id);


            return response()->json([
                'success' => true,
                'track' => MediaResource::collection([$asset]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Track not found. Invalid ID provided.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 404);
        }
    }

    public function trackAgreement(int $id): JsonResponse
    {
        try {
            $asset = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio')
                ->where('status', 'uploaded')
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'track_id' => $asset->id,
                    'title' => 'Standard Artist Agreement',
                    'category' => 'Artist',
                    'type' => 'Legal Agreement',
                    'body' => $asset->agreements,
                    'pdf_url' => null, // TODO: generate PDF via dompdf once installed
                    'creator' => $asset->user ? [
                        'id' => $asset->user->id,
                        'username' => $asset->user->username,
                        'is_verified' => (bool) $asset->user->is_verified,
                    ] : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Track not found. Invalid ID provided.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 404);
        }
    }

    /**
     * Global content search.
     *
     * Query params:
     *   - query    (required) — search string
     *   - type     (optional) — audio (default for backwards compat) | illustration | video | media | all
     *   - per_page, page — pagination
     */
    public function searchTracks(Request $request): JsonResponse
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'query field is required.',
            ], 400);
        }

        $perPage = max(1, min(100, (int) $request->query('per_page', 20)));
        $type = $request->query('type', 'audio'); // default audio — preserves existing Flutter behavior

        $q = SongGeneration::query()
            ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
            ->where('status', 'uploaded');

        if (in_array($type, ['audio', 'illustration', 'video'], true)) {
            $q->where('file_type', $type);
        } elseif ($type === 'media') {
            $q->where('file_type', '!=', 'audio');
        } // 'all' = no file_type filter

        $q->where(function ($qq) use ($query) {
            $qq->where('title', 'like', "%{$query}%")
                ->orWhere('overview', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('agreements', 'like', "%{$query}%")
                ->orWhere('genre', 'like', "%{$query}%")
                ->orWhereHas('user', function ($q2) use ($query) {
                    $q2->where('username', 'like', "%{$query}%")
                       ->orWhere('bio', 'like', "%{$query}%");
                });
        });

        $paginator = $q->orderByDesc('created_at')->paginate($perPage);

        return response()->json([
            'success' => true,
            'query' => $query,
            'type' => $type,
            'results' => MediaResource::collection($paginator->items()),
            'pagination' => [
                'total' => $paginator->total(),
                'page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }

    public function myPurchases(Request $request): JsonResponse
    {
        $user = $request->user();

        $purchases = $user->buyerTransactions()
            ->where('status', 'completed')
            ->where('transaction_type', '!=', 'investment')
            ->with([
                'asset' => function ($query) {
                    $query->with([
                        'user:id,username,email,profile_image,is_verified,bio',
                        'songGeneration' => function ($q) {
                            $q->with('user:id,username,email,profile_image,is_verified,bio');
                        }
                    ]);
                },
                'seller:id,username,email,profile_image'
            ])
            ->orderByDesc('created_at')
            ->get();

        if ($purchases->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No purchases found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => MarketplaceTransactionResource::collection($purchases),
        ]);
    }

    public function myPurchaseDetails(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        try {
            $purchase = $user->buyerTransactions()
                ->where('status', 'completed')
                ->where('id', $id)
                ->with([
                    'asset' => function ($query) {
                        $query->with([
                            'user:id,username,email,profile_image,is_verified,bio',
                            'songGeneration' => function ($q) {
                                $q->with('user:id,username,email,profile_image,is_verified,bio');
                            }
                        ]);
                    },
                    'seller:id,username,email,profile_image'
                ])
                ->firstOrFail();

            // Get related purchase/license/investment based on transaction type
            $relatedRecord = null;

            if ($purchase->transaction_type === 'purchase') {
                $relatedRecord = MarketplacePurchase::where('transaction_id', $purchase->id)
                    ->select('id', 'user_id', 'marketplace_asset_id', 'purchase_price', 'payment_status', 'access_token', 'created_at')
                    ->first();
            } elseif ($purchase->transaction_type === 'license') {
                $relatedRecord = MarketplaceLicense::where('transaction_id', $purchase->id)
                    ->select('id', 'user_id', 'marketplace_asset_id', 'license_key', 'license_type', 'licensed_until', 'license_price', 'created_at')
                    ->first();
            } elseif ($purchase->transaction_type === 'investment') {
                $relatedRecord = MarketplaceInvestment::where('transaction_id', $purchase->id)
                    ->select('id', 'user_id', 'marketplace_asset_id', 'blocks_purchased', 'investment_amount', 'total_earned', 'created_at')
                    ->first();
            }

            // Add related record to transaction object
            $purchase->related_record = $relatedRecord;

            return response()->json([
                'success' => true,
                'data' => MarketplaceTransactionResource::collection([$purchase]),
                'related_record' => $relatedRecord,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found. Invalid ID provided.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 404);
        }

    }

    public function downloadPurchasedAsset(Request $request, int $purchaseId)
    {
        try {

            DB::beginTransaction();

            $user = $request->user();

            // Get purchase and validate ownership
            $purchase = MarketplacePurchase::where('user_id', $user->id)
                ->with('asset', 'asset.songGeneration')
                ->findOrFail($purchaseId);

            // Check if purchase is valid and can be downloaded
            if (!$purchase->canDownload()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This purchase has expired or is not available for download',
                ], 403);
            }

            // Get asset file from song generation
            $songGeneration = $purchase->asset->songGeneration;

            if (!$songGeneration || !$songGeneration->file) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asset file not found',
                ], 404);
            }

            $filePath = $songGeneration->file;

            // Check if file exists in public storage
            if (!Storage::disk('public')->exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not available',
                    'path' => $filePath,
                    'debug_path' => storage_path('app/public/' . $filePath),
                ], 404);
            }

            // Record download
            $purchase->recordDownload();

            DB::commit();

            // Return file download from public disk
            return response()->json(
                [
                    'success' => true,
                    'download_url' => Storage::url($filePath),
                ]
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found or access denied',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Download failed',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Unified "My Tracks / My Library" listing.
     *
     * Returns every track the consumer holds — purchases, licenses, and investments —
     * in one flat array, each item tagged with `type` and the fields the My Tracks
     * screen needs (expiry, invested amount, ownership %, etc.).
     *
     * Query params:
     *   - type: filter to 'purchased' | 'licensed' | 'invested' (default: all three)
     *   - limit: cap per type (default 50)
     */
    public function myLibrary(Request $request): JsonResponse
    {
        $user = $request->user();
        $filterType = $request->query('type');
        $limit = (int) ($request->query('limit', 50));
        $limit = max(1, min(200, $limit));

        $items = collect();

        if (!$filterType || $filterType === 'purchased') {
            $purchases = MarketplacePurchase::with([
                    'asset.user:id,username,email,profile_image,is_verified,bio',
                    'asset.songGeneration',
                ])
                ->where('user_id', $user->id)
                ->where('payment_status', 'completed')
                ->orderByDesc('created_at')
                ->limit($limit)
                ->get();

            foreach ($purchases as $p) {
                $items->push($this->formatLibraryItem('purchased', $p));
            }
        }

        if (!$filterType || $filterType === 'licensed') {
            $licenses = MarketplaceLicense::with([
                    'asset.user:id,username,email,profile_image,is_verified,bio',
                    'asset.songGeneration',
                ])
                ->where('user_id', $user->id)
                ->where('payment_status', 'completed')
                ->orderByDesc('created_at')
                ->limit($limit)
                ->get();

            foreach ($licenses as $l) {
                $items->push($this->formatLibraryItem('licensed', $l));
            }
        }

        if (!$filterType || $filterType === 'invested') {
            $investments = MarketplaceInvestment::with([
                    'asset.user:id,username,email,profile_image,is_verified,bio',
                    'asset.songGeneration',
                ])
                ->where('user_id', $user->id)
                ->where('payment_status', 'completed')
                ->orderByDesc('created_at')
                ->limit($limit)
                ->get();

            foreach ($investments as $i) {
                $items->push($this->formatLibraryItem('invested', $i));
            }
        }

        $sorted = $items->sortByDesc('acquired_at')->values();

        return response()->json([
            'success' => true,
            'count' => $sorted->count(),
            'totals' => [
                'purchased' => $items->where('type', 'purchased')->count(),
                'licensed' => $items->where('type', 'licensed')->count(),
                'invested' => $items->where('type', 'invested')->count(),
            ],
            'data' => $sorted,
        ]);
    }

    /**
     * Shape a purchase/license/investment row into the uniform library-item array.
     */
    protected function formatLibraryItem(string $type, $record): array
    {
        $asset = $record->asset;
        $song = $asset?->songGeneration;
        $creator = $asset?->user;

        $base = [
            'type' => $type,
            'id' => $record->id,
            'asset_id' => $record->marketplace_asset_id,
            'song_generation_id' => $song?->id,
            'acquired_at' => $record->created_at?->toDateTimeString(),
            'status' => 'active',
            'price_paid' => 0.0,

            // Flat fields the My Tracks card UI reads directly.
            // null when the field doesn't apply to this item's type — Flutter renders the row only when non-null.
            'expiry_date' => null,
            'invested_amount' => null,

            'track' => $song ? [
                'id' => $song->id,
                'title' => $song->title,
                'overview' => $song->overview,
                'description' => $song->description,
                'genre' => $song->genre,
                'tempo' => $song->tempo,
                'instrumental_type' => $song->instrumental_type,
                'agreement' => $song->agreements,
                'cover_image' => $song->cover_image
                    ? url(Storage::url($song->cover_image))
                    : null,
                'file' => $song->file
                    ? url(Storage::url($song->file))
                    : null,
            ] : null,

            'creator' => $creator ? [
                'id' => $creator->id,
                'username' => $creator->username,
                'email' => $creator->email,
                'is_verified' => (bool) $creator->is_verified,
                'profile_image' => $creator->profile_image
                    ? (str_starts_with($creator->profile_image, 'http')
                        ? $creator->profile_image
                        : url(Storage::url($creator->profile_image)))
                    : null,
            ] : null,
        ];

        if ($type === 'purchased') {
            $base['price_paid'] = (float) $record->purchase_price;
            $base['download_count'] = (int) $record->download_count;
            $base['last_downloaded_at'] = $record->last_downloaded_at?->toDateTimeString();
            $base['expires_at'] = $record->expires_at?->toDateTimeString();
            $base['expiry_date'] = $record->expires_at?->toDateTimeString();
            $base['status'] = $record->isExpired() ? 'expired' : 'active';
        }

        if ($type === 'licensed') {
            $base['price_paid'] = (float) $record->license_price;
            $base['license_type'] = $record->license_type;
            $base['license_key'] = $record->license_key;
            $base['licensed_from'] = $record->licensed_from?->toDateTimeString();
            $base['licensed_until'] = $record->licensed_until?->toDateTimeString();
            $base['expiry_date'] = $record->licensed_until?->toDateTimeString();
            $base['days_remaining'] = $record->licensed_until && $record->licensed_until->isFuture()
                ? (int) now()->diffInDays($record->licensed_until, false)
                : 0;
            $base['status'] = $record->isActive() ? 'active' : 'expired';
        }

        if ($type === 'invested') {
            $base['price_paid'] = (float) $record->investment_amount;
            $base['invested_amount'] = (float) $record->investment_amount;
            $base['blocks_purchased'] = (int) $record->blocks_purchased;
            $base['price_per_block'] = (float) $record->price_per_block;
            $base['ownership_percentage'] = (float) $record->ownership_percentage;
            $base['expected_roi'] = (float) $record->expected_roi;
            $base['total_earned'] = (float) $record->total_earned;
            $base['certificate_of_ownership'] = $record->certificate_of_ownership;
            $base['status'] = $record->getInvestmentStatus();
        }

        return $base;
    }

    /**
     * Download a track via an active license.
     * Mirrors downloadPurchasedAsset but validates against MarketplaceLicense.
     */
    public function downloadLicensedAsset(Request $request, int $licenseId)
    {
        try {
            DB::beginTransaction();

            $user = $request->user();

            $license = MarketplaceLicense::with('asset.songGeneration')
                ->where('user_id', $user->id)
                ->findOrFail($licenseId);

            if (!$license->isActive()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This license is expired or inactive.',
                ], 403);
            }

            $song = $license->asset?->songGeneration;
            if (!$song || !$song->file) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asset file not found',
                ], 404);
            }

            if (!Storage::disk('public')->exists($song->file)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not available',
                    'path' => $song->file,
                ], 404);
            }

            $license->recordUsage();

            DB::commit();

            return response()->json([
                'success' => true,
                'download_url' => url(Storage::url($song->file)),
                'license_id' => $license->id,
                'license_key' => $license->license_key,
                'expires_at' => $license->licensed_until?->toDateTimeString(),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'License not found or access denied',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Download failed',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function becomeCreator(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role === 'creator') {
            return response()->json([
                'success' => false,
                'message' => 'You are already a creator.',
            ], 400);
        }

        $user->role = 'creator';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Your account has been updated to creator.',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'profile_image' => $user->profile_image ? url(Storage::url($user->profile_image)) : null,
            ],
        ]);
    }


}

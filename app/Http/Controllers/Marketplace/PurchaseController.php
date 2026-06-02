<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceAsset;
use App\Models\MarketplacePurchase;
use App\Models\MarketplaceLicense;
use App\Models\MarketplaceInvestment;
use App\Services\PurchaseService;
use App\Exceptions\PurchaseException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Resources\MarketplaceAssetsResource;
use App\Http\Resources\MediaResource;
use App\Models\SongGeneration;
use App\Models\InvestmentDistribution;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    /**
     * Purchase asset (direct sale)
     */
    public function purchaseAsset(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'asset_id' => 'required|exists:marketplace_assets,id',
                'payment_method' => 'required|in:card,paypal,wallet',
                'payment_token' => 'required_if:payment_method,card',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->all(),
                ], 422);
            }
            $purchase = $this->purchaseService->processPurchase(
                userId: Auth::id(),
                assetId: $request->asset_id,
                paymentData: $request->only(['payment_method', 'payment_token'])
            );

            return response()->json([
                'success' => true,
                'message' => 'Asset purchased successfully',
                'purchase' => [
                    'id' => $purchase->id,
                    'asset_id' => $purchase->marketplace_asset_id,
                    'purchase_price' => $purchase->purchase_price,
                    'payment_status' => $purchase->payment_status,
                    'access_token' => $purchase->access_token,
                ],
            ], 201);
        } catch (PurchaseException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * License asset
     */
    public function licenseAsset(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'asset_id' => 'required|exists:marketplace_assets,id',
                'months' => 'required|integer|min:1|max:600',
                'payment_method' => 'required|in:card,paypal,wallet',
                'payment_token' => 'required_if:payment_method,card',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->all(),
                ], 422);
            }

            $license = $this->purchaseService->processLicense(
                userId: Auth::id(),
                assetId: $request->asset_id,
                months: $request->months,
                paymentData: $request->only(['payment_method', 'payment_token'])
            );

            return response()->json([
                'success' => true,
                'message' => 'License acquired successfully',
                'license' => [
                    'id' => $license->id,
                    'asset_id' => $license->marketplace_asset_id,
                    'license_key' => $license->license_key,
                    'licensed_from' => $license->licensed_from,
                    'licensed_until' => $license->licensed_until,
                    'license_price' => $license->license_price,
                ],
            ], 201);
        } catch (PurchaseException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Invest in asset
     */
    public function investAsset(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'asset_id' => 'required|exists:marketplace_assets,id',
                'blocks' => 'required|integer|min:1',
                'payment_method' => 'required|in:card,paypal,wallet',
                'payment_token' => 'required_if:payment_method,card',
                // Wallet-based investments — required when payment_method=wallet
                'wallet_address' => ['nullable', 'string', 'regex:/^0x[a-fA-F0-9]{40}$/', 'required_if:payment_method,wallet'],
                'tx_hash' => ['nullable', 'string', 'max:80', 'required_if:payment_method,wallet'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->all(),
                ], 422);
            }

            $investment = $this->purchaseService->processInvestment(
                userId: Auth::id(),
                assetId: $request->asset_id,
                blocksToInvest: $request->blocks,
                paymentData: $request->only(['payment_method', 'payment_token'])
            );

            // Persist wallet metadata if this was a crypto investment.
            if ($request->payment_method === 'wallet') {
                $investment->wallet_address = strtolower($request->input('wallet_address'));
                $investment->tx_hash = $request->input('tx_hash');
                $investment->save();
            }

            // Record investment as initial distribution
            InvestmentDistribution::create([
                'marketplace_investment_id' => $investment->id,
                'distribution_amount' => $investment->investment_amount,
                'distribution_type' => 'investment',
                'status' => 'completed',
                'notes' => 'Initial investment of ' . $request->blocks . ' blocks',
                'distribution_date' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Investment successful',
                'investment' => [
                    'id' => $investment->id,
                    'asset_id' => $investment->marketplace_asset_id,
                    'blocks_purchased' => $investment->blocks_purchased,
                    'investment_amount' => (float) $investment->investment_amount,
                    'ownership_percentage' => (float) $investment->ownership_percentage,
                    'expected_roi' => $investment->expected_roi,
                    'invested_at' => $investment->created_at,
                ],
            ], 201);
        } catch (PurchaseException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Renew license
     */
    public function renewLicense(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'license_id' => 'required|exists:marketplace_licenses,id',
                'months' => 'required|integer|min:1|max:60',
                'payment_method' => 'required|in:card,paypal,wallet',
                'payment_token' => 'required_if:payment_method,card',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->all(),
                ], 422);
            }

            $license = $this->purchaseService->renewLicense(
                licenseId: $request->license_id,
                months: $request->months,
                paymentData: $request->only(['payment_method', 'payment_token'])
            );

            return response()->json([
                'success' => true,
                'message' => 'License renewed successfully',
                'license' => [
                    'id' => $license->id,
                    'licensed_until' => $license->licensed_until,
                    'days_remaining' => $license->getDaysRemaining(),
                ],
            ], 200);
        } catch (PurchaseException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
            ], 500);
        }
    }

    /**
     * Get user's purchases
     */
    public function getPurchases(): JsonResponse
    {
        $purchases = MarketplacePurchase::where('user_id', Auth::id())
            ->with('asset:id,title,asset_type')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'purchases' => $purchases,
        ]);
    }

    /**
     * Get user's licenses
     */
    public function getLicenses(): JsonResponse
    {
        $licenses = MarketplaceLicense::where('user_id', Auth::id())
            ->with('asset:id,title,asset_type')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'licenses' => $licenses,
        ]);
    }

    /**
     * Get user's investments
     */
    public function getInvestments(): JsonResponse
    {
        $investments = MarketplaceInvestment::where('user_id', Auth::id())
            ->with('asset:id,title,total_valuation')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'investments' => $investments->map(function ($investment) {
                return [
                    'id' => $investment->id,
                    'asset' => $investment->asset,
                    'blocks_purchased' => $investment->blocks_purchased,
                    'investment_amount' => $investment->investment_amount,
                    'ownership_percentage' => $investment->ownership_percentage,
                    'current_roi' => $investment->getCurrentROI(),
                    'total_earned' => $investment->total_earned,
                    'pending_earnings' => $investment->getPendingEarnings(),
                    'status' => $investment->getInvestmentStatus(),
                ];
            }),
        ]);
    }

    /**
     * Get purchase details
     */
    public function getPurchaseDetails(int $purchaseId): JsonResponse
    {
        try {
            $purchase = MarketplacePurchase::where('user_id', Auth::id())
                ->with(['asset', 'transaction'])
                ->findOrFail($purchaseId);

            return response()->json([
                'success' => true,
                'purchase' => [
                    'id' => $purchase->id,
                    'asset' => $purchase->asset,
                    'purchase_price' => $purchase->purchase_price,
                    'can_download' => $purchase->canDownload(),
                    'download_count' => $purchase->download_count,
                    'expires_at' => $purchase->expires_at,
                    'purchased_at' => $purchase->created_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found',
            ], 404);
        }
    }

    /**
     * Verify access token
     */
    public function verifyAccessToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|integer',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $purchase = MarketplacePurchase::find($request->purchase_id);

        if (!$purchase || $purchase->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid purchase',
            ], 404);
        }

        if (!$purchase->canDownload()) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase has expired or is not accessible',
            ], 403);
        }

        if (!$purchase->verifyAccessToken($request->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid access token',
            ], 401);
        }

        $purchase->recordDownload();

        return response()->json([
            'success' => true,
            'message' => 'Access verified',
        ]);
    }

    public function listTracks(Request $request): JsonResponse
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
            $trendingSongs = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', 'audio')
                ->get()
                ->filter(function ($song) {
                    return $song->marketplaceAssets->count() > 0;
                })
                ->map(function ($song) use ($fourteenDaysAgo) {
                    $assetsIds = $song->marketplaceAssets->where('is_active', true)->pluck('id')->toArray();

                    $transactionsCount = 0;
                    $totalRevenue = 0;

                    if (!empty($assetsIds)) {
                        $transactionsCount = MarketplacePurchase::whereIn('marketplace_asset_id', $assetsIds)
                            ->where('created_at', '>=', $fourteenDaysAgo)
                            ->count();

                        $totalRevenue = MarketplacePurchase::whereIn('marketplace_asset_id', $assetsIds)
                            ->where('created_at', '>=', $fourteenDaysAgo)
                            ->sum('purchase_price');
                    }

                    $song->transactions_count = $transactionsCount;
                    $song->total_revenue = (float) ($totalRevenue ?? 0);

                    return $song;
                })
                ->sortByDesc('transactions_count')
                ->sortByDesc('total_revenue')
                ->take(5)
                ->values();

            // All tracks
            $allTracks = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', 'audio')
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'success' => true,
                'featured_drops' => MediaResource::collection($featuredDrops),
                'trending_assets' => MediaResource::collection($trendingSongs),
                'all_tracks' => MediaResource::collection($allTracks),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching dashboard data.',
                'error' => config('app.debug') ? $e->getMessage() : null,

            ]);
        }
    }
    public function listMedia(Request $request): JsonResponse
    {
        try {


            $fourteenDaysAgo = now()->subDays(14);

            // Trending songs (last 14 days)
            $trendingSongs = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', '!=', 'audio')
                ->get()
                ->filter(function ($song) {
                    return $song->marketplaceAssets->count() > 0;
                })
                ->map(function ($song) use ($fourteenDaysAgo) {
                    $assetsIds = $song->marketplaceAssets->where('is_active', true)->pluck('id')->toArray();

                    $transactionsCount = 0;
                    $totalRevenue = 0;

                    if (!empty($assetsIds)) {
                        $transactionsCount = MarketplacePurchase::whereIn('marketplace_asset_id', $assetsIds)
                            ->where('created_at', '>=', $fourteenDaysAgo)
                            ->count();

                        $totalRevenue = MarketplacePurchase::whereIn('marketplace_asset_id', $assetsIds)
                            ->where('created_at', '>=', $fourteenDaysAgo)
                            ->sum('purchase_price');
                    }

                    $song->transactions_count = $transactionsCount;
                    $song->total_revenue = (float) ($totalRevenue ?? 0);

                    return $song;
                })
                ->sortByDesc('transactions_count')
                ->sortByDesc('total_revenue')
                ->take(5)
                ->values();

            $recommendedForYou = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', '!=', 'audio')
                ->whereHas('marketplaceAssets') // filter in DB
                ->latest('created_at')
                ->limit(5)
                ->get();


            $recentlyAdded = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', '!=', 'audio')
                ->latest('created_at')
                ->limit(10) // optional (recommended)
                ->get();

            return response()->json([
                'success' => true,
                'trending_assets' => MediaResource::collection($trendingSongs),
                'recommended_for_you' => MediaResource::collection($recommendedForYou),
                'recently_added' => MediaResource::collection($recentlyAdded),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching dashboard data.',
                'error' => config('app.debug') ? $e->getMessage() : null,

            ]);
        }
    }

    public function listMediaAll(Request $request): JsonResponse
    {
        try {
            $allMedia = SongGeneration::query()
                ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
                ->where('status', 'uploaded')
                ->where('file_type', '!=', 'audio')
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'success' => true,
                'all_media' => MediaResource::collection($allMedia),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching media data.',
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
    // =========================================================================
    //  Marketplace feed sections (Figma: Featured / Trending / Recommended / Recently added)
    //  All accept ?type=audio|video|illustration|media + ?limit / ?page
    // =========================================================================

    public function featured(Request $request): JsonResponse
    {
        $limit = $this->paginationLimit($request, 10, 50);

        $rows = $this->baseFeedQuery($request)
            ->whereHas('marketplaceAssets', fn ($q) => $q->where('is_active', true))
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $rows->count(),
            'data' => MediaResource::collection($rows),
        ]);
    }

    public function trending(Request $request): JsonResponse
    {
        $limit = $this->paginationLimit($request, 10, 50);
        $fourteenDaysAgo = now()->subDays(14);

        $rows = $this->baseFeedQuery($request)
            ->whereHas('marketplaceAssets', fn ($q) => $q->where('is_active', true))
            ->get()
            ->map(function ($song) use ($fourteenDaysAgo) {
                $assetIds = $song->marketplaceAssets->where('is_active', true)->pluck('id')->toArray();
                $song->purchases_count = $assetIds
                    ? MarketplacePurchase::whereIn('marketplace_asset_id', $assetIds)
                        ->where('created_at', '>=', $fourteenDaysAgo)
                        ->count()
                    : 0;
                return $song;
            })
            ->sortByDesc('purchases_count')
            ->take($limit)
            ->values();

        return response()->json([
            'success' => true,
            'count' => $rows->count(),
            'data' => MediaResource::collection($rows),
        ]);
    }

    public function recommended(Request $request): JsonResponse
    {
        // TODO: personalize based on user history. For now: random sample of active items.
        $limit = $this->paginationLimit($request, 10, 50);

        $rows = $this->baseFeedQuery($request)
            ->whereHas('marketplaceAssets', fn ($q) => $q->where('is_active', true))
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $rows->count(),
            'data' => MediaResource::collection($rows),
        ]);
    }

    public function recentlyAdded(Request $request): JsonResponse
    {
        $perPage = $this->paginationLimit($request, 20, 100);

        $paginator = $this->baseFeedQuery($request)
            ->whereHas('marketplaceAssets', fn ($q) => $q->where('is_active', true))
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'count' => $paginator->count(),
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'last_page' => $paginator->lastPage(),
            'data' => MediaResource::collection($paginator->items()),
        ]);
    }

    /**
     * Common base query filtered by ?type=audio|video|illustration|media
     *   - audio / video / illustration → file_type = ...
     *   - media → file_type != 'audio' (the "Media" tab from Figma)
     *   - omitted → all
     */
    protected function baseFeedQuery(Request $request)
    {
        $type = $request->query('type');
        $q = SongGeneration::query()
            ->with('user:id,username,email,profile_image,is_verified,bio', 'marketplaceAssets')
            ->where('status', 'uploaded');

        if (in_array($type, ['audio', 'video', 'illustration'], true)) {
            $q->where('file_type', $type);
        } elseif ($type === 'media') {
            $q->where('file_type', '!=', 'audio');
        }
        return $q;
    }

    protected function paginationLimit(Request $request, int $default, int $max): int
    {
        $limit = (int) $request->query('limit', $default);
        return max(1, min($max, $limit));
    }

    public function assetDetails(int $id): JsonResponse
    {
        try {
            $asset = MarketplaceAsset::query()
                ->with('user', 'songGeneration')
                ->where('is_active', true)
                ->findOrFail($id);


            return response()->json([
                'success' => true,
                'track' => MarketplaceAssetsResource::collection([$asset]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asset not found. Invalid ID provided.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 404);
        }
    }





}
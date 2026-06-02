<?php

namespace App\Services;

use App\Models\MarketplaceTransaction;
use App\Models\MarketplacePurchase;
use App\Models\MarketplaceLicense;
use App\Models\MarketplaceInvestment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MarketplaceAnalyticsService
{
    /**
     * Get seller revenue summary
     */
    public function getSellerRevenue(int $sellerId, ?int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $transactions = MarketplaceTransaction::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->get();

        return [
            'total_revenue' => $transactions->sum('seller_amount'),
            'total_fees' => $transactions->sum('platform_fee'),
            'transaction_count' => $transactions->count(),
            'average_transaction' => $transactions->count() > 0 
                ? $transactions->sum('amount') / $transactions->count() 
                : 0,
            'by_type' => $this->groupTransactionsByType($transactions),
        ];
    }

    /**
     * Get buyer spending summary
     */
    public function getBuyerSpending(int $buyerId, ?int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $transactions = MarketplaceTransaction::where('user_id', $buyerId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->get();

        return [
            'total_spent' => $transactions->sum('amount'),
            'transaction_count' => $transactions->count(),
            'average_transaction' => $transactions->count() > 0 
                ? $transactions->sum('amount') / $transactions->count() 
                : 0,
            'by_type' => $this->groupTransactionsByType($transactions),
            'active_licenses' => MarketplaceLicense::where('user_id', $buyerId)
                ->active()
                ->count(),
            'active_investments' => MarketplaceInvestment::where('user_id', $buyerId)
                ->active()
                ->count(),
        ];
    }

    /**
     * Get asset performance metrics
     */
    public function getAssetPerformance(int $assetId): array
    {
        $purchases = MarketplacePurchase::where('marketplace_asset_id', $assetId)->get();
        $licenses = MarketplaceLicense::where('marketplace_asset_id', $assetId)->get();
        $investments = MarketplaceInvestment::where('marketplace_asset_id', $assetId)->get();

        return [
            'sales' => [
                'count' => $purchases->count(),
                'revenue' => $purchases->sum('purchase_price'),
                'average_price' => $purchases->count() > 0 
                    ? $purchases->sum('purchase_price') / $purchases->count() 
                    : 0,
            ],
            'licenses' => [
                'count' => $licenses->count(),
                'active' => $licenses->filter(fn($l) => $l->isActive())->count(),
                'revenue' => $licenses->sum('license_price'),
                'average_price' => $licenses->count() > 0 
                    ? $licenses->sum('license_price') / $licenses->count() 
                    : 0,
            ],
            'investments' => [
                'count' => $investments->count(),
                'active' => $investments->filter(fn($i) => $i->isActive())->count(),
                'total_raised' => $investments->sum('investment_amount'),
                'total_distributed' => $investments->sum('total_earned'),
            ],
            'total_revenue' => $purchases->sum('purchase_price') 
                + $licenses->sum('license_price') 
                + $investments->sum('investment_amount'),
        ];
    }

    /**
     * Get platform statistics
     */
    public function getPlatformStats(?int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $transactions = MarketplaceTransaction::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->get();

        $purchases = $transactions->where('transaction_type', 'purchase');
        $licenses = $transactions->where('transaction_type', 'license');
        $investments = $transactions->where('transaction_type', 'investment');

        return [
            'total_revenue' => $transactions->sum('amount'),
            'total_fees' => $transactions->sum('platform_fee'),
            'total_seller_payouts' => $transactions->sum('seller_amount'),
            'transaction_count' => $transactions->count(),
            'unique_buyers' => $transactions->pluck('user_id')->unique()->count(),
            'unique_sellers' => $transactions->pluck('seller_id')->unique()->count(),
            'sales' => [
                'count' => $purchases->count(),
                'revenue' => $purchases->sum('amount'),
            ],
            'licenses' => [
                'count' => $licenses->count(),
                'revenue' => $licenses->sum('amount'),
            ],
            'investments' => [
                'count' => $investments->count(),
                'revenue' => $investments->sum('amount'),
            ],
            'failed_transactions' => MarketplaceTransaction::where('status', 'failed')
                ->where('created_at', '>=', $startDate)
                ->count(),
            'refunded_amount' => MarketplaceTransaction::where('status', 'refunded')
                ->where('created_at', '>=', $startDate)
                ->sum('amount'),
        ];
    }

    /**
     * Get top performing assets
     */
    public function getTopAssets(int $limit = 10, ?string $type = null): Collection
    {
        $query = \App\Models\MarketplaceAsset::withCount([
            'purchases',
            'licenses',
            'investments',
        ])->with('user');

        if ($type) {
            $query->where('sale_type', $type);
        }

        return $query->orderByDesc(
            MarketplaceTransaction::select('COUNT(*)')
                ->whereColumn('marketplace_asset_id', 'marketplace_assets.id')
                ->where('status', 'completed')
        )->limit($limit)->get();
    }

    /**
     * Get top sellers
     */
    public function getTopSellers(int $limit = 10): Collection
    {
        return User::whereHas('soldTransactions', function ($query) {
            $query->where('status', 'completed');
        })
            ->withSum(['soldTransactions' => function ($query) {
                $query->where('status', 'completed');
            }], 'seller_amount')
            ->orderByDesc('sold_transactions_sum_seller_amount')
            ->limit($limit)
            ->get();
    }

    /**
     * Get investment summary
     */
    public function getInvestmentSummary(int $assetId): array
    {
        $investments = MarketplaceInvestment::where('marketplace_asset_id', $assetId)
            ->active()
            ->get();

        $totalEarned = $investments->sum('total_earned');
        $totalInvested = $investments->sum('investment_amount');

        return [
            'investor_count' => $investments->count(),
            'total_invested' => $totalInvested,
            'total_distributed' => $totalEarned,
            'average_roi' => $investments->count() > 0 
                ? $investments->avg(function ($inv) { return $inv->getCurrentROI(); })
                : 0,
            'distribution_rate' => $totalInvested > 0 ? ($totalEarned / $totalInvested) * 100 : 0,
        ];
    }

    /**
     * Get refund statistics
     */
    public function getRefundStats(?int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $refunded = MarketplaceTransaction::where('status', 'refunded')
            ->where('created_at', '>=', $startDate)
            ->get();

        $chargebacks = MarketplaceTransaction::where('status', 'chargeback')
            ->where('created_at', '>=', $startDate)
            ->get();

        return [
            'refund_count' => $refunded->count(),
            'refund_amount' => $refunded->sum('amount'),
            'chargeback_count' => $chargebacks->count(),
            'chargeback_amount' => $chargebacks->sum('amount'),
            'refund_rate' => $this->calculateRefundRate($days),
        ];
    }

    /**
     * Helper: Group transactions by type
     */
    private function groupTransactionsByType(Collection $transactions): array
    {
        return [
            'purchase' => $transactions->where('transaction_type', 'purchase')->sum('amount'),
            'license' => $transactions->where('transaction_type', 'license')->sum('amount'),
            'investment' => $transactions->where('transaction_type', 'investment')->sum('amount'),
        ];
    }

    /**
     * Helper: Calculate refund rate
     */
    private function calculateRefundRate(int $days): float
    {
        $startDate = now()->subDays($days);

        $totalTransactions = MarketplaceTransaction::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->count();

        $refundedTransactions = MarketplaceTransaction::where('status', 'refunded')
            ->where('created_at', '>=', $startDate)
            ->count();

        return $totalTransactions > 0 ? ($refundedTransactions / $totalTransactions) * 100 : 0;
    }
}
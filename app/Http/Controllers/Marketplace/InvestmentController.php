<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceInvestment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\InvestmentDistribution;
use Illuminate\Support\Facades\Storage;

class InvestmentController extends Controller
{
    /**
     * Get all investments
     */
    public function getAllInvestments(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $investments = MarketplaceInvestment::where('user_id', $user->id)
                ->with([
                    'asset:id,title,asset_type,song_generation_id', // include FK
                ])
                ->latest('created_at')
                ->get()
                ->map(function ($investment) {
                    return $this->formatInvestmentData($investment);
                });

            $totalInvestments = $investments->sum('investment_amount');
            $totalEarned = $investments->sum(fn($inv) => $inv['earnings']['total_earned']);

            return response()->json([
                'success' => true,
                'data' => $investments,
                'total_investments' => $totalInvestments,
                'total_earned' => $totalEarned,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch investments',
            ], 500);
        }
    }

    /**
     * Get investment details
     */
    public function getInvestmentDetails(Request $request, int $investmentId): JsonResponse
    {
        try {
            $user = $request->user();

            $investment = MarketplaceInvestment::where('user_id', $user->id)
                ->with([
                    'transaction',
                    'asset:id,title,asset_type,song_generation_id', // include FK
                    'asset.songGeneration:id,user_id,title,file,cover_image,description,overview,agreements,metadata',
                    'asset.songGeneration.user:id,username,email,profile_image'
                ])
                ->findOrFail($investmentId);

            // Get distribution history
            $distributions = InvestmentDistribution::where('marketplace_investment_id', $investmentId)
                ->orderByDesc('distribution_date')
                ->paginate(20);

            $earnings = $this->calculateEarnings($investment);

            $song = $investment->asset?->songGeneration;
            $creator = $song?->user;

            // Format agreements URL
            $agreementUrl = null;
            if ($song && $song->agreements) {
                if (filter_var($song->agreements, FILTER_VALIDATE_URL)) {
                    $agreementUrl = $song->agreements;
                } elseif ($song->agreements !== '1') {
                    $agreementUrl = url(Storage::url($song->agreements));
                }
            }

            return response()->json([
                'success' => true,
                'investment' => array_merge($this->formatInvestmentData($investment), [
                    'smart_contract_id' => $investment->transaction ? $investment->transaction->transaction_reference : ('#INV-' . str_pad($investment->id, 8, '0', STR_PAD_LEFT)),
                    'status' => $investment->getInvestmentStatus(),
                    'license_type' => 'Personal'
                ]),
                'media' => $song ? [
                    'id' => $song->id,
                    'title' => $song->title,
                    'file' => $song->file ? url(Storage::url($song->file)) : null,
                    'cover_image' => $song->cover_image ? url(Storage::url($song->cover_image)) : null,
                    'duration' => $song->metadata['duration'] ?? '00:00',
                    'description' => $song->description,
                    'overview' => $song->overview,
                    'agreement' => $agreementUrl,
                    'creator' => $creator ? [
                        'name' => $creator->username,
                        'role' => 'Creator',
                        'profile_image' => $creator->profile_image ? url(Storage::url($creator->profile_image)) : null,
                    ] : null,
                ] : null,
                'earnings' => $earnings,
                'distribution_history' => [
                    'data' => $distributions->items(),
                    'pagination' => [
                        'total' => $distributions->total(),
                        'per_page' => $distributions->perPage(),
                        'current_page' => $distributions->currentPage(),
                        'last_page' => $distributions->lastPage(),
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Investment not found',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 404);
        }
    }

    /**
     * Get investment summary dashboard
     */
    public function getInvestmentSummary(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $investments = MarketplaceInvestment::where('user_id', $user->id)
                ->with('asset:id,title')
                ->get();

            $summary = [
                'total_invested' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
                'total_pending' => 0,
                'average_roi' => 0,
                'total_investments' => $investments->count(),
            ];

            $investmentsData = $investments->map(function ($investment) use (&$summary) {
                $earnings = $this->calculateEarnings($investment);
                $summary['total_invested'] += $earnings['investment_amount'];
                $summary['total_earned'] += $earnings['total_earned'];
                $summary['total_withdrawn'] += $earnings['total_withdrawn'];
                $summary['total_pending'] += $earnings['pending_earnings'];

                return [
                    'id' => $investment->id,
                    'asset_title' => $investment->asset->title,
                    'blocks_purchased' => (int) $investment->blocks_purchased,
                    'investment_amount' => (float) $investment->investment_amount,
                    'ownership_percentage' => (float) $investment->ownership_percentage,
                    'earnings' => $earnings,
                    'invested_at' => $investment->created_at,
                ];
            })->toArray();

            // Calculate average ROI
            if ($summary['total_invested'] > 0) {
                $summary['average_roi'] = round(($summary['total_earned'] / $summary['total_invested']) * 100, 2);
            }

            // Round all summary values
            $summary['total_invested'] = round($summary['total_invested'], 2);
            $summary['total_earned'] = round($summary['total_earned'], 2);
            $summary['total_withdrawn'] = round($summary['total_withdrawn'], 2);
            $summary['total_pending'] = round($summary['total_pending'], 2);
            $summary['total_profit'] = round($summary['total_earned'] - $summary['total_invested'], 2);

            return response()->json([
                'success' => true,
                'summary' => $summary,
                'investments' => $investmentsData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch investment summary',
            ], 500);
        }
    }

    /**
     * Get earning history for specific investment
     */
    public function getEarningHistory(Request $request, int $investmentId): JsonResponse
    {
        try {
            $user = $request->user();

            $investment = MarketplaceInvestment::where('user_id', $user->id)
                ->with('asset:id,title')
                ->findOrFail($investmentId);

            // Get earnings only
            $earnings = InvestmentDistribution::where('marketplace_investment_id', $investmentId)
                ->where('distribution_type', 'dividend')
                ->orderByDesc('distribution_date')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'asset' => $investment->asset,
                'investment_amount' => (float) $investment->investment_amount,
                'data' => $earnings->items(),
                'pagination' => [
                    'total' => $earnings->total(),
                    'per_page' => $earnings->perPage(),
                    'current_page' => $earnings->currentPage(),
                    'last_page' => $earnings->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch earning history',
            ], 404);
        }
    }

    /**
     * Request earnings withdrawal
     */
    public function requestWithdrawal(Request $request, int $investmentId): JsonResponse
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
            ]);

            $user = $request->user();

            $investment = MarketplaceInvestment::where('user_id', $user->id)
                ->findOrFail($investmentId);

            $earnings = $this->calculateEarnings($investment);

            if ($request->amount > $earnings['pending_earnings']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested amount exceeds pending earnings',
                    'pending_earnings' => round($earnings['pending_earnings'], 2),
                ], 422);
            }

            // Create withdrawal request
            $withdrawal = InvestmentDistribution::create([
                'marketplace_investment_id' => $investment->id,
                'distribution_amount' => $request->amount,
                'distribution_type' => 'withdrawal',
                'status' => 'pending',
                'notes' => 'Withdrawal request',
                'distribution_date' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal request submitted',
                'withdrawal' => [
                    'id' => $withdrawal->id,
                    'amount' => round((float) $request->amount, 2),
                    'status' => 'pending',
                    'requested_at' => $withdrawal->created_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawal request failed',
            ], 500);
        }
    }

    /**
     * Get withdrawal history
     */
    public function getWithdrawalHistory(Request $request, int $investmentId): JsonResponse
    {
        try {
            $user = $request->user();

            $investment = MarketplaceInvestment::where('user_id', $user->id)
                ->findOrFail($investmentId);

            $withdrawals = InvestmentDistribution::where('marketplace_investment_id', $investmentId)
                ->where('distribution_type', 'withdrawal')
                ->orderByDesc('distribution_date')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $withdrawals->items(),
                'pagination' => [
                    'total' => $withdrawals->total(),
                    'per_page' => $withdrawals->perPage(),
                    'current_page' => $withdrawals->currentPage(),
                    'last_page' => $withdrawals->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch withdrawal history',
            ], 404);
        }
    }

    /**
     * Helper: Format investment data
     */
    private function formatInvestmentData(MarketplaceInvestment $investment): array
    {
        $earnings = $this->calculateEarnings($investment);

        return [
            'id' => $investment->id,
            'asset' => [
                'id' => $investment->asset?->id,
                'title' => $investment->asset?->title,
                'type' => $investment->asset?->asset_type,
            ],
            'blocks_purchased' => (int) $investment->blocks_purchased,
            'investment_amount' => (float) $investment->investment_amount,
            'ownership_percentage' => (float) $investment->ownership_percentage,
            'expected_roi' => (float) ($investment->expected_roi ?? 0),
            'earnings' => $earnings,
            'invested_at' => $investment->created_at,
        ];
    }

    /**
     * Helper: Calculate earnings from distributions
     */
    private function calculateEarnings(MarketplaceInvestment $investment): array
    {
        $investmentAmount = (float) $investment->investment_amount;

        // Total earned (from dividends/earnings)
        $totalEarned = (float) InvestmentDistribution::where('marketplace_investment_id', $investment->id)
            ->where('distribution_type', 'dividend')
            ->where('status', 'completed')
            ->sum('distribution_amount');

        // Total withdrawn
        $totalWithdrawn = (float) InvestmentDistribution::where('marketplace_investment_id', $investment->id)
            ->where('distribution_type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('distribution_amount');

        // Pending withdrawal requests
        $pendingWithdrawals = (float) InvestmentDistribution::where('marketplace_investment_id', $investment->id)
            ->where('distribution_type', 'withdrawal')
            ->where('status', 'pending')
            ->sum('distribution_amount');

        // Pending earnings = total earned - withdrawn - pending withdrawals
        $pendingEarnings = $totalEarned - $totalWithdrawn - $pendingWithdrawals;
        $pendingEarnings = max(0, $pendingEarnings);

        // ROI
        $roi = $investmentAmount > 0 ? (($totalEarned / $investmentAmount) * 100) : 0;

        return [
            'investment_amount' => round($investmentAmount, 2),
            'total_earned' => round($totalEarned, 2),
            'total_withdrawn' => round($totalWithdrawn, 2),
            'pending_withdrawals' => round($pendingWithdrawals, 2),
            'pending_earnings' => round($pendingEarnings, 2),
            'roi_percentage' => round($roi, 2),
            'profit' => round($totalEarned - $investmentAmount, 2),
        ];
    }
}
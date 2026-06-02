<?php

namespace App\Services;

use App\Models\MarketplaceTransaction;
use App\Models\MarketplacePurchase;
use App\Models\MarketplaceLicense;
use App\Models\MarketplaceInvestment;
use App\Exceptions\PurchaseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundService
{
    /**
     * Process a refund for a purchase
     */
    public function refundPurchase(int $purchaseId, ?string $reason = null): void
    {
        DB::transaction(function () use ($purchaseId, $reason) {
            $purchase = MarketplacePurchase::findOrFail($purchaseId);

            if (!$purchase->isPaid()) {
                throw new PurchaseException('Cannot refund a non-completed purchase.');
            }

            $transaction = $purchase->transaction;

            // Process refund with payment gateway
            $this->refundTransaction($transaction);

            // Update statuses
            $purchase->update(['payment_status' => 'refunded']);
            $transaction->update([
                'status' => 'refunded',
                'metadata' => array_merge(
                    $transaction->metadata ?? [],
                    ['refund_reason' => $reason, 'refunded_at' => now()]
                ),
            ]);

            Log::info('Purchase refunded', [
                'purchase_id' => $purchase->id,
                'reason' => $reason,
            ]);
        });
    }

    /**
     * Process a refund for a license
     */
    public function refundLicense(int $licenseId, ?string $reason = null): void
    {
        DB::transaction(function () use ($licenseId, $reason) {
            $license = MarketplaceLicense::findOrFail($licenseId);

            if (!$license->isPaid()) {
                throw new PurchaseException('Cannot refund a non-completed license.');
            }

            $transaction = $license->transaction;

            // Deactivate license
            $license->update(['is_active' => false]);

            // Process refund
            $this->refundTransaction($transaction);

            $transaction->update([
                'status' => 'refunded',
                'metadata' => array_merge(
                    $transaction->metadata ?? [],
                    ['refund_reason' => $reason, 'refunded_at' => now()]
                ),
            ]);

            Log::info('License refunded', [
                'license_id' => $license->id,
                'reason' => $reason,
            ]);
        });
    }

    /**
     * Process a partial refund for an investment
     */
    public function partialRefundInvestment(
        int $investmentId,
        string $amount,
        ?string $reason = null
    ): void {
        DB::transaction(function () use ($investmentId, $amount, $reason) {
            $investment = MarketplaceInvestment::findOrFail($investmentId);

            if (!$investment->isPaid()) {
                throw new PurchaseException('Cannot refund a non-completed investment.');
            }

            $originalTransaction = $investment->transaction;

            // Create refund transaction
            $refundTransaction = MarketplaceTransaction::create([
                'user_id' => $investment->user_id,
                'seller_id' => $investment->asset->user_id,
                'marketplace_asset_id' => $investment->marketplace_asset_id,
                'transaction_type' => 'investment_refund',
                'transaction_reference' => MarketplaceTransaction::generateReference(),
                'amount' => $amount,
                'seller_amount' => 0, // Seller doesn't receive refund
                'platform_fee' => 0,
                'status' => 'completed',
                'payment_method' => $originalTransaction->payment_method,
                'metadata' => [
                    'original_investment_id' => $investmentId,
                    'refund_reason' => $reason,
                    'refunded_at' => now(),
                ],
                'completed_at' => now(),
            ]);

            Log::info('Investment partially refunded', [
                'investment_id' => $investment->id,
                'refund_amount' => $amount,
                'reason' => $reason,
            ]);
        });
    }

    /**
     * Refund a transaction
     */
    private function refundTransaction(MarketplaceTransaction $transaction): void
    {
        try {
            $paymentService = app('payment.service');
            $gatewayId = $transaction->payment_gateway_response['id'] ?? null;

            if (!$gatewayId) {
                throw new PurchaseException('No gateway transaction ID found for refund.');
            }

            $refundResult = $paymentService->refund($gatewayId, (float)$transaction->amount);

            if (!($refundResult['success'] ?? false)) {
                throw new PurchaseException('Payment gateway refund failed.');
            }

            Log::info('Transaction refunded with gateway', [
                'transaction_id' => $transaction->id,
                'refund_id' => $refundResult['id'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Refund processing failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
            ]);
            throw new PurchaseException('Failed to process refund: ' . $e->getMessage());
        }
    }

    /**
     * Handle chargeback
     */
    public function handleChargeback(string $chargeId, array $chargebackData): void
    {
        DB::transaction(function () use ($chargeId, $chargebackData) {
            $transaction = MarketplaceTransaction::where(
                'payment_gateway_response->id',
                $chargeId
            )->firstOrFail();

            $transaction->update([
                'status' => 'chargeback',
                'metadata' => array_merge(
                    $transaction->metadata ?? [],
                    [
                        'chargeback_reason' => $chargebackData['reason'] ?? null,
                        'chargeback_amount' => $chargebackData['amount'] ?? null,
                        'chargeback_date' => now(),
                    ]
                ),
            ]);

            // Deactivate associated purchase/license
            if ($transaction->transaction_type === 'purchase') {
                MarketplacePurchase::where('transaction_id', $transaction->id)
                    ->update(['payment_status' => 'chargeback']);
            } elseif ($transaction->transaction_type === 'license') {
                MarketplaceLicense::where('transaction_id', $transaction->id)
                    ->update(['is_active' => false, 'payment_status' => 'chargeback']);
            }

            Log::warning('Chargeback received', [
                'transaction_id' => $transaction->id,
                'charge_id' => $chargeId,
            ]);
        });
    }
}
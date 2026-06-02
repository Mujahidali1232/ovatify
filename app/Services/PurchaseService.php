<?php

namespace App\Services;

use App\Models\MarketplaceAsset;
use App\Models\MarketplacePurchase;
use App\Models\MarketplaceLicense;
use App\Models\MarketplaceInvestment;
use App\Models\MarketplaceTransaction;
use App\Exceptions\PurchaseException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PurchaseService
{
    private const PLATFORM_FEE_PERCENTAGE = 10; // 10% platform fee
    private const TRANSACTION_TIMEOUT = 600; // 10 minutes

    /**
     * Process a direct purchase (sale)
     */
    public function processPurchase(
        int $userId,
        int $assetId,
        array $paymentData = []
    ): MarketplacePurchase {
        return DB::transaction(function () use ($userId, $assetId, $paymentData) {
            // Validate
            $asset = $this->getAndValidateAsset($assetId, 'sale');

            if (!$asset->canBePurchased()) {
                throw new PurchaseException('Asset cannot be purchased at this moment.');
            }

            // Prevent self-purchase
            if ($asset->user_id === $userId) {
                throw new PurchaseException('You cannot purchase your own asset.');
            }

            // ⭐ NEW: Check seller has bank account BEFORE payment (skip for internal wallet)
            if (($paymentData['payment_method'] ?? $paymentData['method'] ?? 'card') !== 'wallet') {
                $sellerBankAccount = \App\Models\SellerBankAccount::where('user_id', $asset->user_id)
                    ->where('is_default', true)
                    ->where('status', 'active')
                    ->first();

                if (!$sellerBankAccount) {
                    throw new PurchaseException('Seller has not configured their bank account. This purchase cannot be completed.');
                }
            }

            // Create transaction
            $transaction = $this->createTransaction(
                userId: $userId,
                sellerId: $asset->user_id,
                assetId: $assetId,
                amount: $asset->price,
                type: 'purchase',
                paymentData: $paymentData
            );

            // Process payment
            try {
                $paymentResponse = $this->processPayment($transaction, $paymentData);

                if (!$paymentResponse['success']) {
                    $transaction->markAsFailed(['reason' => $paymentResponse['error'] ?? 'Payment failed']);
                    throw new PurchaseException($paymentResponse['error'] ?? 'Payment processing failed');
                }

                $confrimPayment = app('payment.service')->confirmPaymentIntent(
                    $paymentResponse['payment_intent_id'] ?? '',
                    $paymentData['payment_method_id'] ?? null
                );

                if (!$confrimPayment || ($confrimPayment['status'] ?? '') !== 'succeeded') {
                    $transaction->markAsFailed(['reason' => 'Payment confirmation failed']);
                    throw new PurchaseException('Payment confirmation failed');
                }

                $transaction->markAsCompleted();

            } catch (Exception $e) {
                Log::error('Payment processing failed', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
                $transaction->markAsFailed(['exception' => $e->getMessage()]);
                throw new PurchaseException('Payment processing failed: ' . $e->getMessage());
            }

            // Create purchase record
            $purchase = MarketplacePurchase::create([
                'user_id' => $userId,
                'marketplace_asset_id' => $assetId,
                'transaction_id' => $transaction->id,
                'purchase_price' => $asset->price,
                'payment_method' => $paymentData['method'] ?? 'card',
                'payment_status' => 'completed',
                'access_token' => bin2hex(random_bytes(32)),
            ]);

            // Log activity
            Log::info('Purchase completed', [
                'purchase_id' => $purchase->id,
                'user_id' => $userId,
                'asset_id' => $assetId,
            ]);

            return $purchase;
        });
    }

    /**
     * Process a license purchase
     */
    public function processLicense(
        int $userId,
        int $assetId,
        int $months = 1,
        array $paymentData = []
    ): MarketplaceLicense {
        return DB::transaction(function () use ($userId, $assetId, $months, $paymentData) {
            // Validate
            $asset = $this->getAndValidateAsset($assetId, 'license');

            if (!$asset->canBeLicensed()) {
                throw new PurchaseException('Asset cannot be licensed at this moment.');
            }

            if ($asset->user_id === $userId) {
                throw new PurchaseException('You cannot license your own asset.');
            }

            // ⭐ NEW: Check seller has bank account BEFORE payment (skip for internal wallet)
            if (($paymentData['payment_method'] ?? $paymentData['method'] ?? 'card') !== 'wallet') {
                $sellerBankAccount = \App\Models\SellerBankAccount::where('user_id', $asset->user_id)
                    ->where('is_default', true)
                    ->where('status', 'active')
                    ->first();

                if (!$sellerBankAccount) {
                    throw new PurchaseException('Seller has not configured their bank account. This purchase cannot be completed.');
                }
            }


            $years = bcdiv((string) $months, '12', 2);

            // Calculate amount (price per year * years)
            $amount = bcmul((string) $asset->price_per_license, $years, 2);

            // Create transaction
            $transaction = $this->createTransaction(
                userId: $userId,
                sellerId: $asset->user_id,
                assetId: $assetId,
                amount: $amount,
                type: 'license',
                paymentData: $paymentData,
                metadata: ['months' => $months, 'license_type' => $asset->license_type]
            );

            // Process payment
            try {
                $paymentResponse = $this->processPayment($transaction, $paymentData);

                if (!$paymentResponse['success']) {
                    $transaction->markAsFailed(['reason' => $paymentResponse['error'] ?? 'Payment failed']);
                    throw new PurchaseException($paymentResponse['error'] ?? 'Payment processing failed');
                }

                $confrimPayment = app('payment.service')->confirmPaymentIntent(
                    $paymentResponse['payment_intent_id'] ?? '',
                    $paymentData['payment_method_id'] ?? null
                );

                if (!$confrimPayment || ($confrimPayment['status'] ?? '') !== 'succeeded') {
                    $transaction->markAsFailed(['reason' => 'Payment confirmation failed']);
                    throw new PurchaseException('Payment confirmation failed');
                }

                $transaction->markAsCompleted();

            } catch (Exception $e) {
                Log::error('License payment failed', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
                $transaction->markAsFailed(['exception' => $e->getMessage()]);
                throw new PurchaseException('Payment processing failed: ' . $e->getMessage());
            }

            // Create license record
            $license = MarketplaceLicense::create([
                'user_id' => $userId,
                'marketplace_asset_id' => $assetId,
                'transaction_id' => $transaction->id,
                'license_key' => 'LIC-' . strtoupper(bin2hex(random_bytes(12))),
                'license_type' => $asset->license_type,
                'licensed_from' => now(),
                'licensed_until' => now()->addMonths($months),
                'payment_status' => 'completed',
                'license_price' => $amount,
                'payment_method' => $paymentData['method'] ?? 'card',
                'is_active' => true,
            ]);

            Log::info('License created', [
                'license_id' => $license->id,
                'user_id' => $userId,
                'asset_id' => $assetId,
            ]);

            return $license;
        });
    }

    /**
     * Process an investment purchase
     */
    public function processInvestment(
        int $userId,
        int $assetId,
        int $blocksToInvest,
        array $paymentData = []
    ): MarketplaceInvestment {
        return DB::transaction(function () use ($userId, $assetId, $blocksToInvest, $paymentData) {
            // Validate
            $asset = $this->getAndValidateAsset($assetId, 'investment');

            if (!$asset->canBeInvested()) {
                throw new PurchaseException('Asset is not available for investment.');
            }

            if ($asset->user_id === $userId) {
                throw new PurchaseException('You cannot invest in your own asset.');
            }

            if ($blocksToInvest <= 0) {
                throw new PurchaseException('Invalid number of blocks.');
            }

            if ($blocksToInvest > $asset->remaining_blocks) {
                throw new PurchaseException(
                    "Only {$asset->remaining_blocks} blocks available. You requested {$blocksToInvest}."
                );
            }

            // ⭐ NEW: Check seller has bank account BEFORE payment (skip for internal wallet)
            if (($paymentData['payment_method'] ?? $paymentData['method'] ?? 'card') !== 'wallet') {
                $sellerBankAccount = \App\Models\SellerBankAccount::where('user_id', $asset->user_id)
                    ->where('is_default', true)
                    ->where('status', 'active')
                    ->first();

                if (!$sellerBankAccount) {
                    throw new PurchaseException('Seller has not configured their bank account. This purchase cannot be completed.');
                }
            }

            // Calculate amount
            $amount = bcmul((string) $asset->price_per_block, (string) $blocksToInvest, 2);
            $ownershipPercentage = ($blocksToInvest / $asset->max_available_blocks) * 100;

            // Create transaction
            $transaction = $this->createTransaction(
                userId: $userId,
                sellerId: $asset->user_id,
                assetId: $assetId,
                amount: $amount,
                type: 'investment',
                paymentData: $paymentData,
                metadata: [
                    'blocks' => $blocksToInvest,
                    'price_per_block' => $asset->price_per_block,
                ]
            );

            // Process payment
            try {
                $paymentResponse = $this->processPayment($transaction, $paymentData);

                if (!$paymentResponse['success']) {
                    $transaction->markAsFailed(['reason' => $paymentResponse['error'] ?? 'Payment failed']);
                    throw new PurchaseException($paymentResponse['error'] ?? 'Payment processing failed');
                }

                $confrimPayment = app('payment.service')->confirmPaymentIntent(
                    $paymentResponse['payment_intent_id'] ?? '',
                    $paymentData['payment_method_id'] ?? null
                );

                if (!$confrimPayment || ($confrimPayment['status'] ?? '') !== 'succeeded') {
                    $transaction->markAsFailed(['reason' => 'Payment confirmation failed']);
                    throw new PurchaseException('Payment confirmation failed');
                }

                $transaction->markAsCompleted();

            } catch (Exception $e) {
                Log::error('Investment payment failed', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
                $transaction->markAsFailed(['exception' => $e->getMessage()]);
                throw new PurchaseException('Payment processing failed: ' . $e->getMessage());
            }

            // Create investment record
            $investment = MarketplaceInvestment::create([
                'user_id' => $userId,
                'marketplace_asset_id' => $assetId,
                'transaction_id' => $transaction->id,
                'blocks_purchased' => $blocksToInvest,
                'investment_amount' => $amount,
                'price_per_block' => $asset->price_per_block,
                'ownership_percentage' => $ownershipPercentage,
                'payment_status' => 'completed',
                'payment_method' => $paymentData['method'] ?? 'card',
                'expected_roi' => $this->calculateExpectedROI((float) $amount, $asset->investment_roi ?? 0),
                // 'expected_roi' =>  $amount,
                'is_active' => true,
            ]);

            // Update asset remaining blocks
            $asset->decrement('remaining_blocks', $blocksToInvest);

            Log::info('Investment completed', [
                'investment_id' => $investment->id,
                'user_id' => $userId,
                'asset_id' => $assetId,
                'blocks' => $blocksToInvest,
            ]);

            return $investment;
        });
    }

    /**
     * Renew a license
     */
    public function renewLicense(int $licenseId, int $months = 1, array $paymentData = []): MarketplaceLicense
    {
        return DB::transaction(function () use ($licenseId, $months, $paymentData) {
            $license = MarketplaceLicense::findOrFail($licenseId);
            $asset = $this->getAndValidateAsset($license->marketplace_asset_id, 'license');

            if (!$license->isActive()) {
                throw new PurchaseException('Only active licenses can be renewed.');
            }

            // ⭐ NEW: Check seller has bank account BEFORE payment (skip for internal wallet)
            if (($paymentData['payment_method'] ?? $paymentData['method'] ?? 'card') !== 'wallet') {
                $sellerBankAccount = \App\Models\SellerBankAccount::where('user_id', $asset->user_id)
                    ->where('is_default', true)
                    ->where('status', 'active')
                    ->first();

                if (!$sellerBankAccount) {
                    throw new PurchaseException('Seller has not configured their bank account. This purchase cannot be completed.');
                }
            }

            // Calculate amount
            $amount = bcmul((string) $license->license_price, (string) $months, 2);

            // Create transaction
            $transaction = MarketplaceTransaction::create([
                'user_id' => $license->user_id,
                'seller_id' => $license->asset->user_id,
                'marketplace_asset_id' => $license->marketplace_asset_id,
                'transaction_type' => 'license_renewal',
                'transaction_reference' => MarketplaceTransaction::generateReference(),
                'amount' => $amount,
                'seller_amount' => $this->calculateSellerAmount($amount),
                'platform_fee' => $this->calculateFee($amount),
                'status' => 'pending',
                'payment_method' => $paymentData['method'] ?? 'card',
                'metadata' => ['license_id' => $licenseId, 'months' => $months],
            ]);

            // Process payment
            try {
                $paymentResponse = $this->processPayment($transaction, $paymentData);

                if (!$paymentResponse['success']) {
                    $transaction->markAsFailed(['reason' => $paymentResponse['error'] ?? 'Payment failed']);
                    throw new PurchaseException('License renewal failed');
                }

                $confrimPayment = app('payment.service')->confirmPaymentIntent(
                    $paymentResponse['payment_intent_id'] ?? '',
                    $paymentData['payment_method_id'] ?? null
                );

                if (!$confrimPayment || ($confrimPayment['status'] ?? '') !== 'succeeded') {
                    $transaction->markAsFailed(['reason' => 'Payment confirmation failed']);
                    throw new PurchaseException('Payment confirmation failed');
                }

                $transaction->markAsCompleted();

            } catch (Exception $e) {
                $transaction->markAsFailed(['exception' => $e->getMessage()]);
                throw new PurchaseException('License renewal payment failed: ' . $e->getMessage());
            }

            // Update license
            $license->recordRenewal($months);

            Log::info('License renewed', [
                'license_id' => $license->id,
                'months' => $months,
            ]);

            return $license;
        });
    }

    /**
     * Create a transaction record
     */
    private function createTransaction(
        int $userId,
        int $sellerId,
        int $assetId,
        $amount,
        string $type,
        array $paymentData = [],
        array $metadata = []
    ): MarketplaceTransaction {

        $fee = $this->calculateFee($amount);
        $sellerAmount = $this->calculateSellerAmount($amount);

        return MarketplaceTransaction::create([
            'user_id' => $userId,
            'seller_id' => $sellerId,
            'marketplace_asset_id' => $assetId,
            'transaction_type' => $type,
            'transaction_reference' => MarketplaceTransaction::generateReference(),
            'amount' => $amount,
            'seller_amount' => $sellerAmount,
            'platform_fee' => $fee,
            'status' => 'pending',
            'payment_method' => $paymentData['method'] ?? 'card',
            'metadata' => array_merge($paymentData, $metadata),
        ]);
    }

    /**
     * Get and validate asset
     */
    private function getAndValidateAsset(int $assetId, string $type): MarketplaceAsset
    {
        $asset = MarketplaceAsset::find($assetId);

        if (!$asset) {
            throw new PurchaseException('Asset not found.');
        }

        if (!$asset->is_active) {
            throw new PurchaseException('Asset is not active.');
        }

        if ($asset->sale_type !== $type) {
            throw new PurchaseException("Asset is not available for {$type}.");
        }

        return $asset;
    }

    /**
     * Process payment (integrate with payment gateway)
     */
    private function processPayment(MarketplaceTransaction $transaction, array $paymentData): array
    {
        try {
            $paymentMethod = $paymentData['payment_method'] ?? $paymentData['method'] ?? 'card';

            // Bypass external payment gateway for internal wallet payments
            if ($paymentMethod === 'wallet') {
                $transaction->update([
                    'payment_gateway_response' => ['status' => 'succeeded', 'method' => 'wallet'],
                ]);
                return [
                    'success' => true,
                    'gateway_id' => 'wallet_' . uniqid(),
                    'payment_intent_id' => 'wallet_intent', // special flag for confirmPaymentIntent
                ];
            }

            // This is a placeholder for payment gateway integration
            // Integrate with Stripe, PayPal, etc.
            $paymentService = app('payment.service'); // or use a specific gateway

            $buyer = User::with('sellerBankAccounts')->find($transaction->user_id);
            $seller = User::with('sellerBankAccounts')->find($transaction->seller_id);

            $result = $paymentService->createPaymentIntentWithTransfer(
                (float) $transaction->amount,
                $seller->sellerBankAccounts[0]->stripe_account_id,
                (float) $transaction->platform_fee,
                'usd',
                [
                    'transaction_id' => $transaction->id,
                    'user_id' => $transaction->user_id,
                    'username' => $buyer->username,
                    'seller_id' => $transaction->seller_id,
                    'sellername' => $seller->username,
                    'asset_id' => $transaction->marketplace_asset_id,
                    'transaction_type' => $transaction->transaction_type,
                ]
            );

            $transaction->update([
                'payment_gateway_response' => $result,
            ]);

            // Properly handle failure from createPaymentIntentWithTransfer
            if (!isset($result['success']) || !$result['success']) {
                return [
                    'success' => false,
                    'error' => $result['message'] ?? 'Payment gateway rejected the request.',
                ];
            }

            return [
                'success' => true,
                'gateway_id' => $result['id'] ?? null,
                'payment_intent_id' => $result['payment_intent_id'] ?? null,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Calculate platform fee
     */
    private function calculateFee(string $amount): float
    {
        return (float) bcmul((string) $amount, (string) (self::PLATFORM_FEE_PERCENTAGE / 100), 2);
    }

    /**
     * Calculate seller amount
     */
    private function calculateSellerAmount(string $amount): float
    {
        return (float) bcsub((string) $amount, (string) $this->calculateFee($amount), 2);
    }

    /**
     * Calculate expected ROI
     */
    private function calculateExpectedROI(float $investmentAmount, float $roiPercentage): float
    {
        return (float) bcmul((string) $investmentAmount, (string) ($roiPercentage / 100), 2);
    }
}
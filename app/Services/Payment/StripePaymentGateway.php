<?php

namespace App\Services\Payment;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Webhook;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Transfer;
use App\Models\User;
use App\Models\SellerBankAccount;
use App\Models\MarketplaceTransaction;
use Illuminate\Support\Facades\Log;
use Exception;

class StripePaymentGateway implements PaymentGatewayInterface
{
    private string $apiKey;
    private string $webhookSecret;

    public function __construct()
    {
        $this->apiKey = config('services.stripe.secret');
        $this->webhookSecret = config('services.stripe.webhook_secret');

        Stripe::setApiKey($this->apiKey);
    }


    /**
     * Refund payment
     */
    public function refund(string $paymentIntentId, ?float $amount = null): array
    {
        $data = ['payment_intent' => $paymentIntentId];

        if ($amount !== null) {
            $data['amount'] = (int) ($amount * 100);
        }

        $refund = Refund::create($data);

        return [
            'id' => $refund->id,
            'status' => $refund->status,
        ];
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhook(string $signature, string $payload): bool
    {
        try {
            Webhook::constructEvent($payload, $signature, $this->webhookSecret);
            return true;
        } catch (Exception $e) {
            Log::error('Stripe webhook verification failed', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Process webhook events
     */
    public function processWebhookEvent(array $event): void
    {
        match ($event['type']) {
            'payment_intent.succeeded' => $this->handlePaymentSucceeded($event['data']['object']),
            'payment_intent.payment_failed' => $this->handlePaymentFailed($event['data']['object']),
            'account.updated' => $this->handleAccountUpdated($event['data']['object']),
            default => Log::info('Unhandled Stripe event', ['type' => $event['type']]),
        };
    }

    /**
     * Transfer funds to seller
     */
    public function transferToSeller(
        float $amount,
        string $destinationAccountId,
        string $description
    ): array {
        $transfer = Transfer::create([
            'amount' => (int) ($amount * 100),
            'currency' => 'usd',
            'destination' => $destinationAccountId,
            'description' => $description,
        ]);

        return [
            'id' => $transfer->id,
            'status' => $transfer->status,
            'amount' => $transfer->amount / 100,
        ];
    }

    /**
     * Create or get Stripe Express account
     */
    public function createOrGetConnectedAccount(
        User $user,
        string $country = "US"
    ): array {
        $existing = SellerBankAccount::where('user_id', $user->id)->first();

        if ($existing) {
            return [
                'stripe_account_id' => $existing->stripe_account_id,
                'status' => $existing->status,
            ];
        }

        $account = Account::create([
            'type' => 'express',
            'country' => strtoupper($country),
            'email' => $user->email,
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            'business_type' => 'individual',
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        SellerBankAccount::create([
            'user_id' => $user->id,
            'stripe_account_id' => $account->id,
            'status' => 'pending',
            'is_default' => true,
        ]);

        return [
            'stripe_account_id' => $account->id,
            'status' => 'pending',
        ];
    }

    /**
     * Create onboarding link
     */
    public function createOnboardingLink(User $user, string $stripeAccountId): string
    {
        if (!$user->sellerBankAccounts()->where('stripe_account_id', $stripeAccountId)->exists()) {
            $this->createOrGetConnectedAccount($user);
        }

        $link = AccountLink::create([
            'account' => $stripeAccountId,
            'refresh_url' => config('app.url') . '/api/stripe/onboarding/refresh',
            'return_url' => config('app.url') . '/api/stripe/onboarding/complete',
            'type' => 'account_onboarding',
        ]);

        return $link->url;
    }

    public function getConnectedAccount(string $stripeAccountId): array
    {
        try {
            return [
                'account' => Account::retrieve($stripeAccountId)
            ];
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Create Payment Intent with destination (for split payment)
     */
    public function createPaymentIntentWithTransfer(float $amount, string $recipientAccountId, float $platformFee, string $currency = 'usd', array $metadata = []): mixed
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100, // Convert to cents
                'currency' => $currency,
                'application_fee_amount' => $platformFee * 100, // Platform fee in cents
                'transfer_data' => [
                    'destination' => $recipientAccountId,
                ],
                'metadata' => $metadata,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create separate transfer (alternative method)
     */
    public function createTransfer(float $amount, string $recipientAccountId, string $paymentIntentId, array $metadata = []): array
    {
        try {
            $transfer = Transfer::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'destination' => $recipientAccountId,
                'source_transaction' => $paymentIntentId,
                'metadata' => $metadata,
            ]);

            return [
                'success' => true,
                'transfer' => $transfer,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create Payment Intent (regular payment to platform)
     */
    public function createPaymentIntent(float $amount, string $currency = 'usd', array $metadata = []): array   
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'metadata' => $metadata,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',

                ],
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Retrieve Payment Intent
     */
    public function retrievePaymentIntent(string $paymentIntentId): mixed
    {
        try {
            return PaymentIntent::retrieve($paymentIntentId);
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve payment: ' . $e->getMessage());
        }
    }

    public function confirmPaymentIntent(string $paymentIntentId, ?string $paymentMethodId = null): mixed
    {
        try {
            // Bypass Stripe for wallet intent
            if ($paymentIntentId === 'wallet_intent') {
                return ['status' => 'succeeded'];
            }

            $intent = PaymentIntent::retrieve($paymentIntentId);

            if ($intent->status !== 'requires_payment_method') {
                return $intent; // already processed
            }

            $intent->confirm([
                'payment_method' => $paymentMethodId ?? 'pm_card_visa',
            ]);

            return $intent;

        } catch (Exception $e) {
            throw new Exception('Failed to confirm payment intent: ' . $e->getMessage());
        }
    }

    

    /* -------------------- PRIVATE HANDLERS -------------------- */

    private function handlePaymentSucceeded(array $intent): void
    {
        $transaction = MarketplaceTransaction::where(
            'payment_gateway_response->id',
            $intent['id']
        )->first();

        if ($transaction) {
            $transaction->markAsCompleted();
        }
    }

    private function handlePaymentFailed(array $intent): void
    {
        $transaction = MarketplaceTransaction::where(
            'payment_gateway_response->id',
            $intent['id']
        )->first();

        if ($transaction) {
            $transaction->markAsFailed([
                'stripe_error' => $intent['last_payment_error']['message'] ?? 'Payment failed',
            ]);
        }
    }

    private function handleAccountUpdated(array $account): void
    {
        SellerBankAccount::where('stripe_account_id', $account['id'])
            ->update([
                'status' => $account['payouts_enabled'] ? 'active' : 'restricted',
            ]);
    }
}

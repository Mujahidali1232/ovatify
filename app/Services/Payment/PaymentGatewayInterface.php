<?php

namespace App\Services\Payment;

use App\Models\User;
use Stripe\Account;

interface PaymentGatewayInterface
{
    /**
     * Create payment intent
     */
    public function createPaymentIntent(
        float $amount,
        string $currency,
        array $metadata = []
    ): array;

    /**
     * Refund a payment
     */
    public function refund(string $paymentIntentId, ?float $amount = null): array;

    /**
     * Verify webhook signature
     */
    public function verifyWebhook(string $signature, string $payload): bool;

    /**
     * Process webhook event
     */
    public function processWebhookEvent(array $event): void;

    /**
     * Transfer funds to seller
     */
    public function transferToSeller(
        float $amount,
        string $destinationAccountId,
        string $description
    ): array;

    /**
     * Create or get Stripe connected account
     */
    public function createOrGetConnectedAccount(
        User $user,
        string $country
    ): array;

    /**
     * Create Stripe onboarding link
     */
    public function createOnboardingLink(User $user, string $stripeAccountId): string;

    public function getConnectedAccount(string $stripeAccountId): array;

    public function createPaymentIntentWithTransfer( float $amount, string $recipientAccountId, float $platformFee, string $currency = 'usd', array $metadata = []): mixed;

    public function createTransfer(float $amount, string $recipientAccountId, string $paymentIntentId, array $metadata = []): array;

    public function retrievePaymentIntent(string $paymentIntentId): mixed;

    public function confirmPaymentIntent(string $paymentIntentId, ?string $paymentMethodId = null): mixed;

}

<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payment\StripePaymentGateway;

class WebhookController extends Controller
{
    public function handleStripeWebhook(Request $request, StripePaymentGateway $gateway)
    {
        $payload = $request->getContent();
        $signature = $request->header('stripe-signature');

        // Verify webhook signature
        if (!$gateway->verifyWebhook($signature, $payload)) {
            return response('Invalid signature', 403);
        }

        // Process event
        $event = json_decode($payload, true);
        $gateway->processWebhookEvent($event);

        return response('Webhook received', 200);
    }
}

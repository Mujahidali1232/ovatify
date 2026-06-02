<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Subscription;
use Illuminate\Http\JsonResponse;
use Exception;

class SubscriptionController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $subscription = Subscription::create($request->all());
            return $this->successResponse($subscription);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $subscription = Subscription::retrieve($id);
            return $this->successResponse($subscription);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $subscriptions = Subscription::all($request->all());
            return $this->successResponse($subscriptions);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $subscription = Subscription::update($id, $request->all());
            return $this->successResponse($subscription);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function cancel(string $id): JsonResponse
    {
        try {
            $subscription = Subscription::retrieve($id);
            $subscription->cancel();
            return $this->successResponse(['cancelled' => true]);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Illuminate\Http\JsonResponse;
use Exception;

class PaymentIntentController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $intent = PaymentIntent::create($request->all());
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $intent = PaymentIntent::retrieve($id);
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function confirm(Request $request, string $id): JsonResponse
    {
        try {
            $intent = PaymentIntent::retrieve($id);
            $intent->confirm($request->all());
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function capture(Request $request, string $id): JsonResponse
    {
        try {
            $intent = PaymentIntent::retrieve($id);
            $intent->capture($request->all());
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function cancel(Request $request, string $id): JsonResponse
    {
        try {
            $intent = PaymentIntent::retrieve($id);
            $intent->cancel($request->all());
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

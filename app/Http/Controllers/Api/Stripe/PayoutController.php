<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Payout;
use Illuminate\Http\JsonResponse;
use Exception;

class PayoutController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $payout = Payout::create($request->all());
            return $this->successResponse($payout);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $payout = Payout::retrieve($id);
            return $this->successResponse($payout);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $payouts = Payout::all($request->all());
            return $this->successResponse($payouts);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

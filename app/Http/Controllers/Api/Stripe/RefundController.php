<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Refund;
use Illuminate\Http\JsonResponse;
use Exception;

class RefundController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $refund = Refund::create($request->all());
            return $this->successResponse($refund);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $refund = Refund::retrieve($id);
            return $this->successResponse($refund);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $refunds = Refund::all($request->all());
            return $this->successResponse($refunds);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

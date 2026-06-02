<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Transfer;
use Illuminate\Http\JsonResponse;
use Exception;

class TransferController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $transfer = Transfer::create($request->all());
            return $this->successResponse($transfer);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $transfer = Transfer::retrieve($id);
            return $this->successResponse($transfer);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $transfers = Transfer::all($request->all());
            return $this->successResponse($transfers);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

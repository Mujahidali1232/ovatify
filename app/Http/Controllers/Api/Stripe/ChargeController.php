<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Charge;
use Illuminate\Http\JsonResponse;
use Exception;

class ChargeController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $charge = Charge::create($request->all());
            return $this->successResponse($charge);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $charge = Charge::retrieve($id);
            return $this->successResponse($charge);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $charges = Charge::all($request->all());
            return $this->successResponse($charges);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

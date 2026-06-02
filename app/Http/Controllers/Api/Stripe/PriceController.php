<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Price;
use Illuminate\Http\JsonResponse;
use Exception;

class PriceController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $price = Price::create($request->all());
            return $this->successResponse($price);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $price = Price::retrieve($id);
            return $this->successResponse($price);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $prices = Price::all($request->all());
            return $this->successResponse($prices);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

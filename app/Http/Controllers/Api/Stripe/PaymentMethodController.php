<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Exception;

class PaymentMethodController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $pm = PaymentMethod::create($request->all());
            return $this->successResponse($pm);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $pm = PaymentMethod::retrieve($id);
            return $this->successResponse($pm);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $pms = PaymentMethod::all($request->all());
            return $this->successResponse($pms);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function attach(Request $request, string $id): JsonResponse
    {
        try {
            $pm = PaymentMethod::retrieve($id);
            $pm->attach($request->all());
            return $this->successResponse($pm);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function detach(string $id): JsonResponse
    {
        try {
            $pm = PaymentMethod::retrieve($id);
            $pm->detach();
            return $this->successResponse($pm);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

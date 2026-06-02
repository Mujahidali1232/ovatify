<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\SetupIntent;
use Illuminate\Http\JsonResponse;
use Exception;

class SetupIntentController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $intent = SetupIntent::create($request->all());
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $intent = SetupIntent::retrieve($id);
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function confirm(Request $request, string $id): JsonResponse
    {
        try {
            $intent = SetupIntent::retrieve($id);
            $intent->confirm($request->all());
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function cancel(Request $request, string $id): JsonResponse
    {
        try {
            $intent = SetupIntent::retrieve($id);
            $intent->cancel($request->all());
            return $this->successResponse($intent);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

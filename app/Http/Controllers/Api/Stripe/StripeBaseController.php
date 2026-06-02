<?php

namespace App\Http\Controllers\Api\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Illuminate\Http\JsonResponse;
use Exception;

class StripeBaseController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    protected function successResponse($data, $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    protected function errorResponse(Exception $e, $status = 400): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $e->getMessage(),
                'type' => get_class($e),
            ]
        ], $status);
    }
}

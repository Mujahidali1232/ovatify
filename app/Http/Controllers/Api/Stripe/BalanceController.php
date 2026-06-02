<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Balance;
use Illuminate\Http\JsonResponse;
use Exception;

class BalanceController extends StripeBaseController
{
    public function retrieve(): JsonResponse
    {
        try {
            $balance = Balance::retrieve();
            return $this->successResponse($balance);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

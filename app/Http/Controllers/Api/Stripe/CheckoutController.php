<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Http\JsonResponse;
use Exception;

class CheckoutController extends StripeBaseController
{
    public function createSession(Request $request): JsonResponse
    {
        try {
            $session = Session::create($request->all());
            return $this->successResponse($session);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieveSession(string $id): JsonResponse
    {
        try {
            $session = Session::retrieve($id);
            return $this->successResponse($session);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function listSessions(Request $request): JsonResponse
    {
        try {
            $sessions = Session::all($request->all());
            return $this->successResponse($sessions);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

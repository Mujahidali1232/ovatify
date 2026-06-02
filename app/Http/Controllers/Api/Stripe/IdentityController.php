<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Identity\VerificationSession;
use Illuminate\Http\JsonResponse;
use Exception;

class IdentityController extends StripeBaseController
{
    public function createSession(Request $request): JsonResponse
    {
        try {
            $session = VerificationSession::create($request->all());
            return $this->successResponse($session);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieveSession(string $id): JsonResponse
    {
        try {
            $session = VerificationSession::retrieve($id);
            return $this->successResponse($session);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

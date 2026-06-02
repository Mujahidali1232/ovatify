<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Dispute;
use Illuminate\Http\JsonResponse;
use Exception;

class DisputeController extends StripeBaseController
{
    public function list(Request $request): JsonResponse
    {
        try {
            $disputes = Dispute::all($request->all());
            return $this->successResponse($disputes);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $dispute = Dispute::retrieve($id);
            return $this->successResponse($dispute);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function close(string $id): JsonResponse
    {
        try {
            $dispute = Dispute::retrieve($id);
            $dispute->close();
            return $this->successResponse($dispute);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

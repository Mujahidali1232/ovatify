<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Issuing\Card;
use Illuminate\Http\JsonResponse;
use Exception;

class IssuingController extends StripeBaseController
{
    public function createCard(Request $request): JsonResponse
    {
        try {
            $card = Card::create($request->all());
            return $this->successResponse($card);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieveCard(string $id): JsonResponse
    {
        try {
            $card = Card::retrieve($id);
            return $this->successResponse($card);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function listCards(Request $request): JsonResponse
    {
        try {
            $cards = Card::all($request->all());
            return $this->successResponse($cards);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

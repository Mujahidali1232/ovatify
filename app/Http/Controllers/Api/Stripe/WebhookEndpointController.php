<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\WebhookEndpoint;
use Illuminate\Http\JsonResponse;
use Exception;

class WebhookEndpointController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $endpoint = WebhookEndpoint::create($request->all());
            return $this->successResponse($endpoint);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $endpoint = WebhookEndpoint::retrieve($id);
            return $this->successResponse($endpoint);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $endpoints = WebhookEndpoint::all($request->all());
            return $this->successResponse($endpoints);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            $endpoint = WebhookEndpoint::retrieve($id);
            $endpoint->delete();
            return $this->successResponse(['deleted' => true]);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

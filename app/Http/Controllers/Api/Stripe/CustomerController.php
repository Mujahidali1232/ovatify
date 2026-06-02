<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Customer;
use Illuminate\Http\JsonResponse;
use Exception;

class CustomerController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $customer = Customer::create($request->all());
            return $this->successResponse($customer);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $customer = Customer::retrieve($id);
            return $this->successResponse($customer);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $customer = Customer::update($id, $request->all());
            return $this->successResponse($customer);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            $customer = Customer::retrieve($id);
            $customer->delete();
            return $this->successResponse(['deleted' => true]);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $customers = Customer::all($request->all());
            return $this->successResponse($customers);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Product;
use Illuminate\Http\JsonResponse;
use Exception;

class ProductController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $product = Product::create($request->all());
            return $this->successResponse($product);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $product = Product::retrieve($id);
            return $this->successResponse($product);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $products = Product::all($request->all());
            return $this->successResponse($products);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $product = Product::update($id, $request->all());
            return $this->successResponse($product);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            $product = Product::retrieve($id);
            $product->delete();
            return $this->successResponse(['deleted' => true]);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

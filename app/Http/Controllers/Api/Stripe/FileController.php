<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\File;
use Illuminate\Http\JsonResponse;
use Exception;

class FileController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            // Note: Stripe File creation usually requires a multi-part form data
            // and the 'file' field should be a resource or a stream.
            // For simplicity, we pass all request data.
            $file = File::create($request->all());
            return $this->successResponse($file);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $file = File::retrieve($id);
            return $this->successResponse($file);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $files = File::all($request->all());
            return $this->successResponse($files);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

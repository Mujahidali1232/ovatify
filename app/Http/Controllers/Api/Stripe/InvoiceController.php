<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Invoice;
use Illuminate\Http\JsonResponse;
use Exception;

class InvoiceController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $invoice = Invoice::create($request->all());
            return $this->successResponse($invoice);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $invoice = Invoice::retrieve($id);
            return $this->successResponse($invoice);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $invoices = Invoice::all($request->all());
            return $this->successResponse($invoices);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function pay(Request $request, string $id): JsonResponse
    {
        try {
            $invoice = Invoice::retrieve($id);
            $invoice->pay($request->all());
            return $this->successResponse($invoice);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function send(Request $request, string $id): JsonResponse
    {
        try {
            $invoice = Invoice::retrieve($id);
            $invoice->sendInvoice($request->all());
            return $this->successResponse($invoice);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

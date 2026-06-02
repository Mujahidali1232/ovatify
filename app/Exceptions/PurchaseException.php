<?php

namespace App\Exceptions;

use Exception;

class PurchaseException extends Exception
{
    public function __construct(
        string $message = 'An error occurred during purchase',
        int $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], 422);
    }
}
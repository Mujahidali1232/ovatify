<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class VerifyResetCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'email' => 'required|exists:users,email',
            'token' => 'required|string'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors()->all()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}

<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'email' => 'nullable|email|required_without:phone',
            'phone' => 'nullable|string|required_without:email',
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

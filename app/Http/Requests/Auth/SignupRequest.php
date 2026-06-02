<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|min:7|max:20|unique:users,phone',
            'password' => ['required', 'string'],
            'role' => 'nullable|in:consumer,creator,artist,admin'
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


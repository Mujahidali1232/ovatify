<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateProfileImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profile_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB max
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors()->all()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}

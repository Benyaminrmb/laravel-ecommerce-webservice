<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class SetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'password' => ['required' , 'confirmed' , \Illuminate\Validation\Rules\Password::default() ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'The password field is required.',
        ];
    }
}

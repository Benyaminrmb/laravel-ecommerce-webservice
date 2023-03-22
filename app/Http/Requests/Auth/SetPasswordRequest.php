<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', \Illuminate\Validation\Rules\Password::default()],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'The password field is required.',
        ];
    }
}

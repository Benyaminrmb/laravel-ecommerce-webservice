<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifyCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required' , 'numeric' ]
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'The code field is required.',
        ];
    }
}

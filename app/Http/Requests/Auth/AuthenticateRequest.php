<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $entry = $this->input('entry');
            if (filter_var($entry, FILTER_VALIDATE_EMAIL)) {
                $this->merge(['email' => $entry]);
                $this->request->remove('entry');
            } elseif (preg_match('/^(?:\+98|0)?9\d{9}$/', $entry)) {
                $this->merge(['phone_number' => $entry]);
                $this->request->remove('entry');
            } else {
                $validator->errors()->add('entry', 'The entry field must be a valid phone number or email address.');
            }
        });
    }

    public function rules(): array
    {
        return [
            'entry' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'entry.required' => 'The entry field is required.',
        ];
    }

}

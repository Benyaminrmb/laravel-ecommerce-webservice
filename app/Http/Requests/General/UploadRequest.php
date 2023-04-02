<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'title' => 'nullable|string|max:255',
        ];
    }
}

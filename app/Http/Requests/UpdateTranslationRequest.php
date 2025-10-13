<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => ['sometimes', 'string', 'max:191'],
            'value' => ['sometimes', 'string'],
            'tags' => ['array', 'nullable'],
            'tags.*' => ['string', 'exists:tags,slug'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}

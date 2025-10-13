<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:191'],
            'locale' => ['required', 'string', 'exists:locales,code'],
            'value' => ['required', 'string'],
            'tags' => ['array', 'nullable'],
            'tags.*' => ['string', 'exists:tags,slug'],
        ];
    }
}

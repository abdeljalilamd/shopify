<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'image' => ['nullable', 'image', 'max:1024'],
            'description' => ['nullable', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliateProgramUpdateRequest extends FormRequest
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
            'affiliate_id' => ['required', 'exists:customers,id'],
            'referral_id' => ['required', 'exists:customers,id'],
            'commission' => ['required', 'numeric'],
        ];
    }
}

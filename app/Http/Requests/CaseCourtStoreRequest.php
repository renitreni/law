<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CaseCourtStoreRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'law_cases_id' => 'required|exists:law_cases,id',
            'court_name' => 'required|string|max:255',
            'court_date' => 'required|date',
            'court_address' => 'nullable|string|max:500',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LawCaseUpdateRequest extends FormRequest
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
            'case_plaintiff' => 'required|string|max:255',
            'case_defendant' => 'required|string|max:255',
            'case_category' => 'required|string|max:100',
            'case_status' => 'required|string|max:50',
            'case_description' => 'nullable|string',
            'case_attorney' => 'nullable|string|max:255',
            'case_date' => 'required|date',
            'case_opponent' => 'nullable|string|max:255',
        ];
    }
}

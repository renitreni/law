<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TimeEntryRequest extends FormRequest
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
            'client_id' => ['required', 'exists:clients,id'],
            'sub_matter_id' => ['required', 'exists:sub_matters,id'],
            'office_id' => ['required', 'exists:offices,id'],
            'entry_date' => ['required', 'date_format:Y-m-d'],
            'duration' => ['required', 'numeric', 'min:0.01'],
            'narrative' => ['nullable', 'string'],
            'is_billable' => ['required', 'boolean'],
            'is_draft' => ['required', 'boolean'],
            'is_template' => ['required', 'boolean'],
            'template_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(fn () => $this->boolean('is_template')),
            ],
        ];
    }
}

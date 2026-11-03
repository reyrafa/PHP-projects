<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexTaskRequest extends FormRequest
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
            'search'    => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:all,pending,completed'],
            'sort'      => ['nullable', 'in:created_at,title,completed'],
            'direction' => ['nullable', 'in:asc,desc'],
            'per_page'  => ['sometimes', 'integer', 'min:1', 'max:50'],
        ];
    }
}

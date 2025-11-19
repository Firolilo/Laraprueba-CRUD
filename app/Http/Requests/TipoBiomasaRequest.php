<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoBiomasaRequest extends FormRequest
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
            'tipo_biomasa' => 'required|string|max:255|unique:tipo_biomasa,tipo_biomasa,' . ($this->route('tipo_biomasa') ?? 'NULL'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'tipo_biomasa' => 'tipo de biomasa',
        ];
    }
}

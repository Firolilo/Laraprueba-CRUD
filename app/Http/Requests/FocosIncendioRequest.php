<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FocosIncendioRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fecha' => ['required','date'],
            'ubicacion' => ['required','string','max:255'],
            'coordenadas' => ['required','json'],
            'intensidad' => ['required','numeric','min:0','max:10'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Si coordenadas viene como string JSON, parsearlo a array
        if ($this->has('coordenadas') && is_string($this->coordenadas)) {
            $this->merge([
                'coordenadas' => json_decode($this->coordenadas, true),
            ]);
        }
    }
}

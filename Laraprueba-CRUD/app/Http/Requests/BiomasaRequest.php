<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiomasaRequest extends FormRequest
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
            'fecha_reporte' => ['required','date'],
            'tipo_biomasa_id' => ['required','exists:tipo_biomasas,id'],
            'area_m2' => ['nullable','integer','min:0'],
            'perimetro_m' => ['nullable','numeric','min:0'],
            'densidad' => ['required','string','in:Baja,Media,Alta'],
            'coordenadas' => ['required','array'],
            'coordenadas.*' => ['required','numeric'],
            'descripcion' => ['nullable','string'],
        ];
    }
    
    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        // Ya no necesitamos validación extra porque ahora validamos directamente el array
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convertir coordenadas de string JSON a array antes de validar
        if ($this->has('coordenadas') && is_string($this->coordenadas)) {
            $decoded = json_decode($this->coordenadas, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->merge([
                    'coordenadas' => $decoded
                ]);
            }
        }
    }
}

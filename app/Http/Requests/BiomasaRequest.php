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
            'coordenadas' => ['required','json'],
            'descripcion' => ['nullable','string'],
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

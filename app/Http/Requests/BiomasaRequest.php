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
            'tipo_biomasa_id' => ['required','exists:tipo_biomasa,id'],
            'area_m2' => ['nullable','integer','min:0'],
            'densidad' => ['required','string','in:baja,media,alta'],
            'ubicacion' => ['nullable','string','max:255'],
            'coordenadas' => ['nullable','json'],
            'descripcion' => ['nullable','string'],
        ];
    }
}

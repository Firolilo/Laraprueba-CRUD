<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BiomasaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo_biomasa_id' => $this->tipo_biomasa_id,
            'tipo_biomasa' => $this->whenLoaded('tipoBiomasa'),
            'ubicacion' => $this->ubicacion,
            'coordenadas' => $this->coordenadas,
            'area_m2' => $this->area_m2,
            'densidad' => $this->densidad,
            'descripcion' => $this->descripcion,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

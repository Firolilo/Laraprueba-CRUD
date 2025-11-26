<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Biomasa
 *
 * @property $id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Biomasa extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fecha_reporte',
        'tipo_biomasa_id',
        'area_m2',
        'densidad',
        'ubicacion',
        'coordenadas',
        'descripcion',
        'user_id',
    ];

    protected $casts = [
        'area_m2' => 'integer',
        'densidad' => 'float',
        'coordenadas' => 'array',
        'fecha_reporte' => 'date',
    ];
    
    /**
     * Tipo de biomasa (catálogo)
     */
    public function tipoBiomasa()
    {
        return $this->belongsTo(\App\Models\TipoBiomasa::class, 'tipo_biomasa_id');
    }
    
    /**
     * Usuario que creó esta biomasa (cualquiera puede crear)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}

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
        'perimetro_m',
        'densidad',
        'ubicacion',
        'coordenadas',
        'descripcion',
        'user_id',
        'estado',
        'motivo_rechazo',
        'aprobada_por',
        'fecha_revision',
    ];

    protected $casts = [
        'area_m2' => 'float',
        'perimetro_m' => 'float',
        'coordenadas' => 'array',
        'fecha_reporte' => 'date',
        'fecha_revision' => 'datetime',
    ];
    
    /**
     * Scopes para filtrar por estado
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
    
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }
    
    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazada');
    }
    
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
    
    /**
     * Administrador que aprobó/rechazó la biomasa
     */
    public function aprobadaPor()
    {
        return $this->belongsTo(\App\Models\User::class, 'aprobada_por');
    }
    
    /**
     * Verificar si está aprobada
     */
    public function estaAprobada()
    {
        return $this->estado === 'aprobada';
    }
    
    /**
     * Verificar si está pendiente
     */
    public function estaPendiente()
    {
        return $this->estado === 'pendiente';
    }
    
    /**
     * Verificar si está rechazada
     */
    public function estaRechazada()
    {
        return $this->estado === 'rechazada';
    }
}

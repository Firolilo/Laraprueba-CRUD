<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Simulacione
 *
 * @property $id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Simulacione extends Model
{
    
    protected $perPage = 20;

    protected $fillable = [
        'nombre',
        'fecha',
        'duracion',
        'focos_activos',
        'num_voluntarios_enviados',
        'estado',
        'admin_id',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'duracion' => 'integer',
        'focos_activos' => 'integer',
        'num_voluntarios_enviados' => 'integer',
    ];

    /**
     * Administrador que creó esta simulación
     */
    public function admin()
    {
        return $this->belongsTo(\App\Models\Administrador::class, 'admin_id');
    }

    /**
     * Focos de incendio incluidos en esta simulación (many-to-many)
     */
    public function focos()
    {
        return $this->belongsToMany(\App\Models\FocosIncendio::class, 'foco_simulacion', 'simulacion_id', 'foco_incendio_id')
                    ->withPivot(['agregado_at', 'activo'])
                    ->withTimestamps();
    }
}

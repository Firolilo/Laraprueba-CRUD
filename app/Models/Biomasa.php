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
        'nombre',
        'tipo',
        'area_m2',
        'densidad',
        'humedad',
        'ubicacion',
        'descripcion',
        'user_id',
    ];

    protected $casts = [
        'area_m2' => 'integer',
        'densidad' => 'float',
        'humedad' => 'float',
    ];
    
    /**
     * Usuario que creó esta biomasa (cualquiera puede crear)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}

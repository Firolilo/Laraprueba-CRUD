<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'foco_incendio_id',
        'predicted_at',
        'path',
        'meta',
    ];

    protected $casts = [
        'predicted_at' => 'datetime',
        'path' => 'array',
        'meta' => 'array',
    ];

    /**
     * Foco de incendio al que pertenece esta predicción
     */
    public function focoIncendio()
    {
        return $this->belongsTo(\App\Models\FocosIncendio::class, 'foco_incendio_id');
    }
}

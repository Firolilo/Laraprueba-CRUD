<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocoIncendio extends Model
{
    use HasFactory;

    protected $table = 'focos_incendios';

    protected $fillable = [
        'fecha',
        'ubicacion',
        'coordenadas', // array [lat, lng] or object stored as JSON
        'intensidad',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'coordenadas' => 'array',
        'intensidad' => 'float',
    ];

    // You can add helpers to get latitude/longitude convenience accessors
    /**
     * The simulation this foco belongs to (nullable).
     */
    public function simulacion()
    {
        return $this->belongsTo(Simulacion::class, 'simulacion_id');
    }

    /**
     * The biomasa (area) related to this foco (nullable)
     */
    public function biomasa()
    {
        return $this->belongsTo(Biomasa::class, 'biomasa_id');
    }

    /**
     * User that reported the foco
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    /**
     * Movement / intensity tracks for this foco
     */
    public function tracks()
    {
        return $this->hasMany(FocoTrack::class, 'foco_incendio_id');
    }
}

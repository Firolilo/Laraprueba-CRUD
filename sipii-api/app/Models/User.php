<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'cedula_identidad',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación con Voluntario
     */
    public function voluntario()
    {
        return $this->hasOne(Voluntario::class);
    }

    /**
     * Relación con Administrador
     */
    public function administrador()
    {
        return $this->hasOne(Administrador::class);
    }

    // ============================================
    // MÉTODOS DE VERIFICACIÓN DE ROLES
    // ============================================

    /**
     * Check if user is a voluntario
     */
    public function isVoluntario()
    {
        return $this->voluntario()->exists();
    }

    /**
     * Check if user is an administrador
     */
    public function isAdministrador()
    {
        return $this->administrador()->exists();
    }

    /**
     * Get user role type
     */
    public function getRoleType()
    {
        if ($this->isAdministrador()) {
            return 'administrador';
        }
        if ($this->isVoluntario()) {
            return 'voluntario';
        }
        return 'user';
    }
}

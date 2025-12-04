<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Simulacione;
use App\Models\FocosIncendio;
use App\Models\Voluntario;
use App\Models\Administrador;

/**
 * Class User
 *
 * @property $id
 * @property $name
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'telefono', 'cedula_identidad', 'password', 'google_id'];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Biomasas created by this user (anyone can create)
     */
    public function biomasas()
    {
        return $this->hasMany(\App\Models\Biomasa::class, 'user_id');
    }

    /**
     * Voluntario profile for this user
     */
    public function voluntario()
    {
        return $this->hasOne(Voluntario::class);
    }

    /**
     * Administrador profile for this user
     */
    public function administrador()
    {
        return $this->hasOne(Administrador::class);
    }

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
        return 'user'; // base user without role extension
    }


}

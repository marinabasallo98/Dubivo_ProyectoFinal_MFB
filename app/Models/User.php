<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    //Campos que podemos llenar
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    //Campos ocultos (no los mostramos en JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //Conversiones automáticas
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Relaciones
    public function actorProfile()
    {
        return $this->hasOne(Actor::class);
    }

    public function schools()
    {
        return $this->hasManyThrough(School::class, Actor::class);
    }

    //Filtros por rol
    public function scopeActors($query)
    {
        return $query->where('role', 'actor');
    }

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    //Verificamos roles fácilmente
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isActor()
    {
        return $this->role === 'actor';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }
}
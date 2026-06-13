<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // 1. Le decimos a Laravel que tu clave primaria ahora se llama id_usuario
    protected $primaryKey = 'id_usuario';

    // 2. Agregamos todos tus campos al fillable para permitir el registro
    protected $fillable = [
        'id_rol',
        'nombres',
        'apellidos',
        'correo_institucional',
        'password',
        'carrera',
        'telefono',
        'estado_usuario',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

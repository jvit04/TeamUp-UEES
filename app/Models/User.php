<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'id_rol',
    'nombres',
    'apellidos',
    'correo_institucional',
    'password',
    'carrera',
    'telefono',
    'estado_usuario',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_usuario';

    public $incrementing = true;

    protected $keyType = 'int';

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'id_usuario', 'id_usuario');
    }
}
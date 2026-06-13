<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'clubes';
    protected $primaryKey = 'id_club';

    protected $fillable = [
        'id_publicacion', 
        'id_responsable', 
        'nombre_club',
        'descripcion_club', 
        'cupos_disponibles', 
        'horario',
        'lugar', 
        'contacto', 
        'requisitos', 
        'estado_club'
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'id_responsable', 'id_usuario');
    }

    public function postulaciones()
    {
        return $this->hasMany(PostulacionClub::class, 'id_club', 'id_club');
    }
}

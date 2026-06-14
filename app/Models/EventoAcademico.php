<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoAcademico extends Model
{
    protected $table = 'eventos_academicos';

    protected $primaryKey = 'id_evento';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_publicacion',
        'nombre_evento',
        'descripcion_evento',
        'fecha_evento',
        'hora_inicio',
        'hora_fin',
        'lugar',
        'expositor',
        'organizador',
        'modalidad',
        'estado_evento',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'id_publicacion', 'id_publicacion');
    }
}
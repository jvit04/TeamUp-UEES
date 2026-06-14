<?php

namespace App\Models;

use App\Models\PostulacionClub;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PostulacionClub extends Model
{
    protected $table = 'postulaciones_club';
    protected $primaryKey = 'id_postulacion_club';
    
    public $timestamps = false; 

    protected $fillable = [
        'id_club', 
        'id_usuario', 
        'motivo_postulacion',
        'experiencia_previa', 
        'disponibilidad_horaria',
        'estado_postulacion', 
        'fecha_postulacion',
        'fecha_respuesta', 
        'observacion_respuesta'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class, 'id_club', 'id_club');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}
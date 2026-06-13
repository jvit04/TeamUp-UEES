<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostulacionGrupo extends Model
{
    protected $table = 'postulaciones_grupo';
    protected $primaryKey = 'id_postulacion_grupo';
    
    // Desactivamos los timestamps porque no existen en esta tabla
    public $timestamps = false; 

    protected $fillable = [
        'id_grupo', 
        'id_usuario', 
        'mensaje_postulacion',
        'estado_postulacion', 
        'fecha_postulacion',
        'fecha_respuesta', 
        'observacion_respuesta'
    ];

    public function grupo()
    {
        return $this->belongsTo(GrupoConcurso::class, 'id_grupo', 'id_grupo');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}
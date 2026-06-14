<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoConcurso extends Model
{
    protected $table = 'grupos_concurso';
    protected $primaryKey = 'id_grupo';

    protected $fillable = [
        'id_concurso', 
        'id_lider', 
        'nombre_grupo',
        'descripcion_grupo', 
        'cupo_maximo', 
        'estado_grupo'
    ];

    public function concurso()
    {
        // Relación: Un grupo pertenece a un concurso
        return $this->belongsTo(Concurso::class, 'id_concurso', 'id_concurso');
    }

    public function lider()
    {
        // Relación: Un grupo es liderado por un usuario
        return $this->belongsTo(User::class, 'id_lider', 'id_usuario');
    }

    public function postulaciones()
    {
        // Relación: Un grupo tiene muchas postulaciones de estudiantes
        return $this->hasMany(PostulacionGrupo::class, 'id_grupo', 'id_grupo');
    }
}
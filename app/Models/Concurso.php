<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concurso extends Model
{
    protected $table = 'concursos';
    protected $primaryKey = 'id_concurso';

    protected $fillable = [
        'id_publicacion', 
        'nombre_concurso', 
        'descripcion_concurso',
        'area_concurso', 
        'fecha_inicio', 
        'fecha_fin',
        'fecha_limite_inscripcion', 
        'minimo_integrantes',
        'maximo_integrantes', 
        'cupo_maximo_grupos', 
        'modalidad',
        'lugar', 
        'requisitos', 
        'estado_concurso'
    ];

    public function grupos()
    {
        // Relación: Un concurso tiene muchos grupos
        return $this->hasMany(GrupoConcurso::class, 'id_concurso', 'id_concurso');
    }
}
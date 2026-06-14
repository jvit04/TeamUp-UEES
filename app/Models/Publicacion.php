<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $table = 'publicaciones';

    protected $primaryKey = 'id_publicacion';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_usuario',
        'titulo',
        'descripcion',
        'imagen',
        'tipo_publicacion',
        'fecha_publicacion',
        'estado_publicacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function eventoAcademico()
    {
        return $this->hasOne(EventoAcademico::class, 'id_publicacion', 'id_publicacion');
    }
}
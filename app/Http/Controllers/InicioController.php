<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
    public function index()
    {
        $publicaciones = DB::table('publicaciones')
            ->leftJoin('eventos_academicos', 'publicaciones.id_publicacion', '=', 'eventos_academicos.id_publicacion')
            ->select(
                'publicaciones.id_publicacion',
                'publicaciones.titulo',
                'publicaciones.descripcion',
                'publicaciones.imagen',
                'publicaciones.tipo_publicacion',
                'publicaciones.fecha_publicacion',
                'publicaciones.estado_publicacion',
                'eventos_academicos.fecha_evento',
                'eventos_academicos.hora_inicio',
                'eventos_academicos.hora_fin'
            )
            ->where('publicaciones.estado_publicacion', 'PUBLICADA')
            ->orderByDesc('publicaciones.fecha_publicacion')
            ->orderByDesc('publicaciones.id_publicacion')
            ->get();

        $totales = [
            'publicaciones' => $publicaciones->count(),
            'concursos' => $publicaciones->where('tipo_publicacion', 'CONCURSO')->count(),
            'clubes' => $publicaciones->where('tipo_publicacion', 'CLUB')->count(),
            'eventos' => $publicaciones->where('tipo_publicacion', 'EVENTO_ACADEMICO')->count(),
        ];

        return view('inicio.index', compact('publicaciones', 'totales'));
    }
}
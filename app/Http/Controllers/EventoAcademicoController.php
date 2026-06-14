<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class EventoAcademicoController extends Controller
{
    public function index()
    {
        $eventos = DB::table('eventos_academicos')
            ->join('publicaciones', 'eventos_academicos.id_publicacion', '=', 'publicaciones.id_publicacion')
            ->select(
                'eventos_academicos.id_evento',
                'eventos_academicos.nombre_evento',
                'eventos_academicos.descripcion_evento',
                'eventos_academicos.fecha_evento',
                'eventos_academicos.hora_inicio',
                'eventos_academicos.hora_fin',
                'eventos_academicos.lugar',
                'eventos_academicos.expositor',
                'eventos_academicos.organizador',
                'eventos_academicos.modalidad',
                'eventos_academicos.estado_evento',
                'publicaciones.titulo',
                'publicaciones.descripcion',
                'publicaciones.imagen',
                'publicaciones.fecha_publicacion',
                'publicaciones.estado_publicacion'
            )
            ->where('publicaciones.estado_publicacion', 'PUBLICADA')
            ->orderBy('eventos_academicos.fecha_evento')
            ->orderBy('eventos_academicos.hora_inicio')
            ->get();

        return view('eventos-academicos.index', compact('eventos'));
    }

    public function show($id)
    {
        $evento = DB::table('eventos_academicos')
            ->join('publicaciones', 'eventos_academicos.id_publicacion', '=', 'publicaciones.id_publicacion')
            ->select(
                'eventos_academicos.id_evento',
                'eventos_academicos.nombre_evento',
                'eventos_academicos.descripcion_evento',
                'eventos_academicos.fecha_evento',
                'eventos_academicos.hora_inicio',
                'eventos_academicos.hora_fin',
                'eventos_academicos.lugar',
                'eventos_academicos.expositor',
                'eventos_academicos.organizador',
                'eventos_academicos.modalidad',
                'eventos_academicos.estado_evento',
                'publicaciones.titulo',
                'publicaciones.descripcion',
                'publicaciones.imagen',
                'publicaciones.fecha_publicacion',
                'publicaciones.estado_publicacion'
            )
            ->where('eventos_academicos.id_evento', $id)
            ->where('publicaciones.estado_publicacion', 'PUBLICADA')
            ->first();

        if (!$evento) {
            abort(404);
        }

        return view('eventos-academicos.show', compact('evento'));
    }
}
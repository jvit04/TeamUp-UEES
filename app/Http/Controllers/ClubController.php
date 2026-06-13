<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;

class ClubController extends Controller
{
    // 1. Mostrar la lista de clubes
    public function index()
    {
        // Traemos todos los clubes disponibles
        $clubes = Club::where('estado_club', 'DISPONIBLE')->get();
        
        return view('clubes.index', compact('clubes'));
    }

    // 2. Ver el detalle de un club
    public function show($id)
    {
        $club = Club::findOrFail($id);
        
        return view('clubes.show', compact('club'));
    }

    public function postularClub(Request $request, $id)
    {
        // 1. Guardar en la base de datos principal
        $postulacion = new \App\Models\PostulacionClub();
        $postulacion->id_club = $id;
        $postulacion->id_usuario = auth()->user()->id_usuario;
        $postulacion->motivo_postulacion = $request->motivo_postulacion;
        $postulacion->experiencia_previa = $request->experiencia_previa;
        $postulacion->disponibilidad_horaria = $request->disponibilidad_horaria;
        $postulacion->estado_postulacion = 'PENDIENTE';
        $postulacion->fecha_postulacion = \Carbon\Carbon::now();
        $postulacion->save();

        // 2. Modelo de consistencia híbrido: Guardar en CSV local
        $rutaCsv = storage_path('app/respaldo_postulaciones.csv');
        $archivo = fopen($rutaCsv, 'a');
        fputcsv($archivo, [
            $postulacion->id_postulacion_club,
            'CLUB',
            $id,
            auth()->user()->id_usuario,
            $postulacion->fecha_postulacion
        ]);
        fclose($archivo);

        // 3. Regresar a la pantalla anterior con un mensaje de éxito
        return redirect()->back()->with('success', '¡Tu postulación al club fue enviada con éxito!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $club = \App\Models\Club::findOrFail($id);

        $esMiembro = false;
        $postulacionPendiente = false;

        if (auth()->check() && auth()->user()->id_rol != 1) {
            // Verificamos si ya es miembro oficial
            $esMiembro = \Illuminate\Support\Facades\DB::table('miembros_club')
                ->where('id_club', $id)
                ->where('id_usuario', auth()->user()->id_usuario)
                ->where('estado_miembro', 'ACTIVO')
                ->exists();

            // Verificamos si tiene postulación pendiente
            $postulacionPendiente = \Illuminate\Support\Facades\DB::table('postulaciones_club')
                ->where('id_club', $id)
                ->where('id_usuario', auth()->user()->id_usuario)
                ->where('estado_postulacion', 'PENDIENTE')
                ->exists();
        }

        return view('clubes.show', compact('club', 'esMiembro', 'postulacionPendiente'));
    }

   public function postularClub(Request $request, $id)
    {
        $club = \App\Models\Club::findOrFail($id);

        // Validación 1: El responsable del club no puede postularse
        if ($club->id_responsable == auth()->user()->id_usuario) {
            return redirect()->back()->with('error', 'No puedes postularte a un club del cual eres responsable.');
        }

        // Validación 2: Ya tiene una postulación pendiente
        $yaPostulado = \Illuminate\Support\Facades\DB::table('postulaciones_club')
                            ->where('id_club', $id)
                            ->where('id_usuario', auth()->user()->id_usuario)
                            ->where('estado_postulacion', 'PENDIENTE')
                            ->exists();

        if ($yaPostulado) {
            return redirect()->back()->with('error', 'Ya enviaste una solicitud a este club y está en revisión.');
        }

        // Validación 3: Ya es miembro oficial del club
        $esMiembro = \Illuminate\Support\Facades\DB::table('miembros_club')
                            ->where('id_club', $id)
                            ->where('id_usuario', auth()->user()->id_usuario)
                            ->where('estado_miembro', 'ACTIVO')
                            ->exists();

        if ($esMiembro) {
            return redirect()->back()->with('error', 'Ya eres miembro oficial de este club.');
        }

        // Validación 4: Control riguroso de cupos disponibles
        if ($club->cupos_disponibles <= 0) {
            return redirect()->back()->with('error', 'Lo sentimos, este club ya no tiene cupos disponibles.');
        }

        // Si pasa todas las validaciones, creamos la solicitud
        \Illuminate\Support\Facades\DB::table('postulaciones_club')->insert([
            'id_club' => $id,
            'id_usuario' => auth()->user()->id_usuario,
            'motivo_postulacion' => $request->motivo_postulacion,
            'experiencia_previa' => $request->experiencia_previa,
            'disponibilidad_horaria' => $request->disponibilidad_horaria,
            'estado_postulacion' => 'PENDIENTE',
            'fecha_postulacion' => \Carbon\Carbon::now(),
        ]);

        return redirect()->back()->with('success', '¡Tu postulación ha sido enviada con éxito!');
    }
    public function misClubes()
    {
        // Traemos solo los clubes donde el usuario actual fue designado como responsable
        $clubes = Club::where('id_responsable', auth()->user()->id_usuario)->get();

        return view('clubes.mis_clubes', compact('clubes'));
    }

    // Aceptar o rechazar una postulación al club
    public function responderPostulacion(Request $request, $id)
    {
        $postulacion = DB::table('postulaciones_club')->where('id_postulacion_club', $id)->first();
        $estadoNuevo = $request->accion === 'ACEPTAR' ? 'ACEPTADA' : 'RECHAZADA';
        $club = Club::findOrFail($postulacion->id_club);

        // Si el responsable presiona ACEPTAR, validamos y restamos el cupo
        if ($estadoNuevo === 'ACEPTADA') {
            if ($club->cupos_disponibles <= 0) {
                return redirect()->back()->with('error', 'No puedes aceptar más miembros. El club ya no tiene cupos disponibles.');
            }
            
            // Restamos 1 al cupo disponible
            $club->cupos_disponibles -= 1;
            $club->save();

            // Inscribimos al estudiante oficialmente en el club
            DB::table('miembros_club')->insert([
                'id_club' => $postulacion->id_club,
                'id_usuario' => $postulacion->id_usuario,
                'fecha_ingreso' => Carbon::now(),
                'rol_miembro' => 'MIEMBRO',
                'estado_miembro' => 'ACTIVO',
            ]);
        }

        // Finalmente, actualizamos el estado de la solicitud para que no vuelva a aparecer como pendiente
        DB::table('postulaciones_club')
            ->where('id_postulacion_club', $id)
            ->update([
                'estado_postulacion' => $estadoNuevo,
                'fecha_respuesta' => Carbon::now()
            ]);

        return redirect()->back()->with('success', "La solicitud ha sido {$estadoNuevo}.");
    }
    // Función para que un integrante abandone el club voluntariamente
    public function abandonarClub($id)
    {
        $idUsuario = auth()->user()->id_usuario;
        $club = \App\Models\Club::findOrFail($id);

        // Verificamos que realmente sea miembro para no regalar cupos por error
        $esMiembro = \Illuminate\Support\Facades\DB::table('miembros_club')
            ->where('id_club', $id)
            ->where('id_usuario', $idUsuario)
            ->exists();

        if ($esMiembro) {
            \Illuminate\Support\Facades\DB::table('miembros_club')->where('id_club', $id)->where('id_usuario', $idUsuario)->delete();
            \Illuminate\Support\Facades\DB::table('postulaciones_club')->where('id_club', $id)->where('id_usuario', $idUsuario)->delete();

            // Devolvemos el cupo al club
            $club->cupos_disponibles += 1;
            $club->save();
        }

        return redirect()->back()->with('success', 'Has abandonado el club. Tu cupo ha sido liberado.');
    }

    // Función para que un responsable expulse a un integrante
    public function expulsarMiembro($idClub, $idUsuario)
    {
        $club = \App\Models\Club::findOrFail($idClub);

        // Seguridad
        if ($club->id_responsable != auth()->user()->id_usuario) {
            return redirect()->back()->with('error', 'Solo el responsable puede expulsar miembros.');
        }

        $esMiembro = \Illuminate\Support\Facades\DB::table('miembros_club')
            ->where('id_club', $idClub)
            ->where('id_usuario', $idUsuario)
            ->exists();

        if ($esMiembro) {
            \Illuminate\Support\Facades\DB::table('miembros_club')->where('id_club', $idClub)->where('id_usuario', $idUsuario)->delete();
            \Illuminate\Support\Facades\DB::table('postulaciones_club')->where('id_club', $idClub)->where('id_usuario', $idUsuario)->delete();

            // Devolvemos el cupo al club
            $club->cupos_disponibles += 1;
            $club->save();
        }

        return redirect()->back()->with('success', 'El integrante ha sido expulsado y se ha liberado un cupo.');
    }
}
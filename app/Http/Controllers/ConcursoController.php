<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\PostulacionGrupo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Concurso;
use App\Models\GrupoConcurso;

class ConcursoController extends Controller
{
    // 1. Mostrar la lista de concursos disponibles
    public function index()
    {
        // Concursos que estén activos
        $concursos = Concurso::where('estado_concurso', 'DISPONIBLE')->get();
        
        // Enviamos la variable a la vista
        return view('concursos.index', compact('concursos'));
    }

  public function show($id)
    {
        $concurso = \App\Models\Concurso::findOrFail($id);
        
        $grupos = \App\Models\GrupoConcurso::where('id_concurso', $id)
                               ->where('estado_grupo', 'ABIERTO')
                               ->with(['lider', 'postulaciones'])
                               ->get();

        // Verificamos si el estudiante ya pertenece oficialmente a un grupo en este concurso
        $usuarioTieneGrupo = \Illuminate\Support\Facades\DB::table('miembros_grupo')
            ->join('grupos_concurso', 'miembros_grupo.id_grupo', '=', 'grupos_concurso.id_grupo')
            ->where('grupos_concurso.id_concurso', $id)
            ->where('miembros_grupo.id_usuario', auth()->user()->id_usuario)
            ->where('miembros_grupo.estado_miembro', 'ACTIVO')
            ->exists();

        return view('concursos.show', compact('concurso', 'grupos', 'usuarioTieneGrupo'));
    }
public function postularGrupo(Request $request, $id)
    {
        // Buscamos el grupo para verificar de quién es
        $grupo = \App\Models\GrupoConcurso::findOrFail($id);

        // Validación 1: Evitar que el líder se postule a su propio grupo
        if ($grupo->id_lider == auth()->user()->id_usuario) {
            return redirect()->back()->with('error', 'No puedes postularte a un grupo que tú mismo creaste.');
        }

        // Validación 2: Evitar que se postule dos veces al mismo grupo
        $yaPostulado = \App\Models\PostulacionGrupo::where('id_grupo', $id)
                            ->where('id_usuario', auth()->user()->id_usuario)
                            ->exists();

        if ($yaPostulado) {
            return redirect()->back()->with('error', 'Ya enviaste una solicitud a este grupo anteriormente.');
        }

        // Si pasa las validaciones, guardamos normalmente
        $postulacion = new \App\Models\PostulacionGrupo();
        $postulacion->id_grupo = $id;
        $postulacion->id_usuario = auth()->user()->id_usuario;
        $postulacion->mensaje_postulacion = "Me gustaría unirme al equipo.";
        $postulacion->estado_postulacion = 'PENDIENTE';
        $postulacion->fecha_postulacion = \Carbon\Carbon::now();
        $postulacion->save();

        // Guardado en CSV de respaldo
        $rutaCsv = storage_path('app/respaldo_postulaciones.csv');
        $archivo = fopen($rutaCsv, 'a');
        fputcsv($archivo, [
            $postulacion->id_postulacion_grupo,
            'GRUPO',
            $id,
            auth()->user()->id_usuario,
            $postulacion->fecha_postulacion
        ]);
        fclose($archivo);

        return redirect()->back()->with('success', '¡Te has postulado a este grupo con éxito!');
    }
    
    // 1. Mostrar formulario para crear un grupo
    public function crearGrupo($id)
    {
        $concurso = Concurso::findOrFail($id);
        return view('concursos.crear_grupo', compact('concurso'));
    }

    // 2. Guardar el nuevo grupo
    public function guardarGrupo(Request $request, $id)
    {
        $grupo = new GrupoConcurso();
        $grupo->id_concurso = $id;
        $grupo->id_lider = auth()->user()->id_usuario;
        $grupo->nombre_grupo = $request->nombre_grupo;
        $grupo->descripcion_grupo = $request->descripcion_grupo;
        $grupo->cupo_maximo = $request->cupo_maximo;
        $grupo->estado_grupo = 'ABIERTO';
        $grupo->save();

        // Convertimos automáticamente al creador en el líder oficial del equipo
        DB::table('miembros_grupo')->insert([
            'id_grupo' => $grupo->id_grupo,
            'id_usuario' => auth()->user()->id_usuario,
            'rol_en_grupo' => 'LIDER',
            'fecha_union' => Carbon::now(),
            'estado_miembro' => 'ACTIVO',
        ]);

        return redirect()->route('concursos.show', $id)->with('success', '¡Tu grupo ha sido creado exitosamente!');
    }

    // 3. Mostrar el panel de "Mis Grupos"
    public function misGrupos()
    {
        // Traemos todos los grupos donde el usuario es el líder, cargando a los postulantes
        $grupos = GrupoConcurso::where('id_lider', auth()->user()->id_usuario)
                               ->with(['postulaciones.usuario', 'concurso']) 
                               ->get();

        return view('concursos.mis_grupos', compact('grupos'));
    }

    // 4. Aceptar o rechazar una postulación
    public function responderPostulacion(Request $request, $id)
    {
        $postulacion = PostulacionGrupo::findOrFail($id);
        
        // Verificamos si el botón presionado fue ACEPTAR o RECHAZAR
        $estadoNuevo = $request->accion === 'ACEPTAR' ? 'ACEPTADA' : 'RECHAZADA';
        
        $postulacion->estado_postulacion = $estadoNuevo;
        $postulacion->fecha_respuesta = Carbon::now();
        $postulacion->save();

        // Si lo aceptamos, lo ingresamos a la tabla de miembros oficiales
        if ($estadoNuevo === 'ACEPTADA') {
            DB::table('miembros_grupo')->insert([
                'id_grupo' => $postulacion->id_grupo,
                'id_usuario' => $postulacion->id_usuario,
                'rol_en_grupo' => 'MIEMBRO',
                'fecha_union' => Carbon::now(),
                'estado_miembro' => 'ACTIVO',
            ]);
        }

        return redirect()->back()->with('success', "Postulación {$estadoNuevo} correctamente.");
    }
}
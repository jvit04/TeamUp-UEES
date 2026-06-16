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
                               ->get();

        // Buscamos si el estudiante ya pertenece a un grupo activo en este concurso
        $miembroActual = null;
        if (auth()->check() && auth()->user()->id_rol != 1) {
            $miembroActual = \Illuminate\Support\Facades\DB::table('miembros_grupo')
                ->join('grupos_concurso', 'miembros_grupo.id_grupo', '=', 'grupos_concurso.id_grupo')
                ->where('grupos_concurso.id_concurso', $id)
                ->where('miembros_grupo.id_usuario', auth()->user()->id_usuario)
                ->where('miembros_grupo.estado_miembro', 'ACTIVO')
                ->select('miembros_grupo.id_grupo', 'grupos_concurso.id_lider')
                ->first();
        }

        $usuarioTieneGrupo = $miembroActual ? true : false;

        return view('concursos.show', compact('concurso', 'grupos', 'usuarioTieneGrupo', 'miembroActual'));
    }
public function postularGrupo(Request $request, $id)
    {
        $grupo = \App\Models\GrupoConcurso::findOrFail($id);

        // Validación 1: Líder
        if ($grupo->id_lider == auth()->user()->id_usuario) {
            return redirect()->back()->with('error', 'No puedes postularte a un grupo que tú mismo creaste.');
        }

        // Validación 2: Ya postulado
        $yaPostulado = \Illuminate\Support\Facades\DB::table('postulaciones_grupo')
                            ->where('id_grupo', $id)
                            ->where('id_usuario', auth()->user()->id_usuario)
                            ->exists();

        if ($yaPostulado) {
            return redirect()->back()->with('error', 'Ya enviaste una solicitud a este grupo anteriormente.');
        }

        // --- FASE 2: VALIDACIÓN DE CUPOS ---
        $miembrosActuales = \Illuminate\Support\Facades\DB::table('miembros_grupo')
            ->where('id_grupo', $id)
            ->where('estado_miembro', 'ACTIVO')
            ->count();

        if ($miembrosActuales >= $grupo->cupo_maximo) {
            return redirect()->back()->with('error', 'Lo sentimos, este grupo ya alcanzó su límite máximo de integrantes.');
        }

        // Si pasa las validaciones, creamos la solicitud
        \Illuminate\Support\Facades\DB::table('postulaciones_grupo')->insert([
            'id_grupo' => $id,
            'id_usuario' => auth()->user()->id_usuario,
            'mensaje_postulacion' => 'Me gustaría unirme al equipo.',
            'estado_postulacion' => 'PENDIENTE',
            'fecha_postulacion' => \Carbon\Carbon::now(),
        ]);

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
        $existeNombre = \App\Models\GrupoConcurso::where('id_concurso', $id)
                                                 ->where('nombre_grupo', $request->nombre_grupo)
                                                 ->exists();

        if ($existeNombre) {
            return redirect()->back()
                ->withErrors(['nombre_grupo' => 'Ya existe un equipo con el nombre "' . $request->nombre_grupo . '". Por favor, elige uno distinto.'])
                ->withInput(); 
        }
        // ------------------------------------------------------------------------

        $grupo = new GrupoConcurso();
        // ------------------------------------------------------------------------

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
        $postulacion = \App\Models\PostulacionGrupo::findOrFail($id);
        $estadoNuevo = $request->accion === 'ACEPTAR' ? 'ACEPTADA' : 'RECHAZADA';
        
        // --- FASE 2: Validar cupo si el líder presiona "Aceptar" ---
        if ($estadoNuevo === 'ACEPTADA') {
            $grupo = \App\Models\GrupoConcurso::findOrFail($postulacion->id_grupo);
            
            $miembrosActuales = \Illuminate\Support\Facades\DB::table('miembros_grupo')
                ->where('id_grupo', $grupo->id_grupo)
                ->where('estado_miembro', 'ACTIVO')
                ->count();

            if ($miembrosActuales >= $grupo->cupo_maximo) {
                return redirect()->back()->with('error', 'No puedes aceptar más miembros. Tu equipo ya está lleno (' . $grupo->cupo_maximo . '/' . $grupo->cupo_maximo . ').');
            }
        }

        // Guardamos el nuevo estado de la postulación
        $postulacion->estado_postulacion = $estadoNuevo;
        $postulacion->fecha_respuesta = \Carbon\Carbon::now();
        $postulacion->save();

        // Si lo aceptamos, lo ingresamos a la tabla de miembros oficiales
        if ($estadoNuevo === 'ACEPTADA') {
            \Illuminate\Support\Facades\DB::table('miembros_grupo')->insert([
                'id_grupo' => $postulacion->id_grupo,
                'id_usuario' => $postulacion->id_usuario,
                'rol_en_grupo' => 'INTEGRANTE',
                'fecha_union' => \Carbon\Carbon::now(),
                'estado_miembro' => 'ACTIVO',
            ]);
        }

        return redirect()->back()->with('success', "Postulación {$estadoNuevo} correctamente.");
    }
    public function eliminarGrupo($id)
    {
        $grupo = \App\Models\GrupoConcurso::findOrFail($id);

        // Seguridad: Validamos que el usuario actual sea realmente el líder del grupo
        if ($grupo->id_lider != auth()->user()->id_usuario) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar este grupo.');
        }

        // 1. Limpiamos las dependencias (miembros y postulaciones) para evitar errores de SQL
        \Illuminate\Support\Facades\DB::table('miembros_grupo')->where('id_grupo', $id)->delete();
        \Illuminate\Support\Facades\DB::table('postulaciones_grupo')->where('id_grupo', $id)->delete();

        // 2. Eliminamos el grupo
        $grupo->delete();

        // Regresamos al panel con un mensaje
        return redirect()->route('mis_grupos.index')->with('success', 'El grupo ha sido disuelto exitosamente. Ahora eres libre de unirte a otro equipo.');
    }
    // Función para que un integrante abandone voluntariamente
   public function abandonarGrupo($id)
    {
        $idUsuario = auth()->user()->id_usuario;

        // 1. Lo sacamos de los miembros activos
        \Illuminate\Support\Facades\DB::table('miembros_grupo')
            ->where('id_grupo', $id)
            ->where('id_usuario', $idUsuario)
            ->delete();

        // 2. Eliminamos su postulación original para "resetear" la vista y dejarlo postularse de nuevo
        \Illuminate\Support\Facades\DB::table('postulaciones_grupo')
            ->where('id_grupo', $id)
            ->where('id_usuario', $idUsuario)
            ->delete();

        return redirect()->back()->with('success', 'Has abandonado el equipo exitosamente.');
    }

    // Función para que un líder expulse a un integrante
    public function expulsarMiembro($idGrupo, $idUsuario)
    {
        $grupo = \App\Models\GrupoConcurso::findOrFail($idGrupo);

        // Seguridad: Validamos que quien expulsa sea realmente el líder
        if ($grupo->id_lider != auth()->user()->id_usuario) {
            return redirect()->back()->with('error', 'Solo el líder puede expulsar miembros.');
        }

        // 1. Lo sacamos de los miembros activos
        \Illuminate\Support\Facades\DB::table('miembros_grupo')
            ->where('id_grupo', $idGrupo)
            ->where('id_usuario', $idUsuario)
            ->delete();

        // 2. Eliminamos su postulación original
        \Illuminate\Support\Facades\DB::table('postulaciones_grupo')
            ->where('id_grupo', $idGrupo)
            ->where('id_usuario', $idUsuario)
            ->delete();

        return redirect()->back()->with('success', 'El integrante ha sido expulsado del equipo.');
    }

    // Permite a un estudiante retirar su solicitud antes de que el líder la acepte
    public function cancelarPostulacion($id)
    {
        \Illuminate\Support\Facades\DB::table('postulaciones_grupo')
            ->where('id_grupo', $id)
            ->where('id_usuario', auth()->user()->id_usuario)
            ->where('estado_postulacion', 'PENDIENTE')
            ->delete();

        return redirect()->back()->with('success', 'Has cancelado tu solicitud al equipo correctamente.');
    }
}
@extends('layouts.teamup')

@section('title', 'Mis Grupos')

@section('content')
<h2 class="fw-bold text-dark mb-4">Panel de Gestión: Mis Grupos</h2>

@if(session('success'))
    <div class="alert alert-success fw-bold" role="alert">
        {{ session('success') }}
    </div>
@endif

@if($grupos->isEmpty())
    <div class="alert alert-light border border-secondary text-center text-muted p-5" role="alert">
        <p class="fs-5 m-0 text-dark">Actualmente no eres líder de ningún grupo.</p>
        <p class="mt-2 mb-0">¡Ve a la sección de concursos y anímate a fundar tu propio equipo!</p>
    </div>
@else
    <div class="row">
        @foreach($grupos as $grupo)
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-light h-100">
                    
              <div class="card-header bg-light d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                        <div class="mb-3 mb-md-0">
                            <h4 class="fw-bold text-dark m-0">{{ $grupo->nombre_grupo }}</h4>
                            <small class="text-muted fw-bold">Competencia: {{ $grupo->concurso->nombre_concurso ?? 'N/A' }}</small>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-dark p-2 fs-6">
                                Cupo Total: {{ $grupo->cupo_maximo }}
                            </span>
                            
                            <!-- Formulario para eliminar el grupo -->
                            <form action="{{ route('grupos.eliminar', $grupo->id_grupo) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás totalmente seguro de que deseas eliminar este grupo? Esta acción expulsará a los miembros, borrará las solicitudes y no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">
                                    Disolver Grupo
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        @php
                            // Consultamos directamente los integrantes activos del grupo (excluyendo al líder)
                            $integrantes = \Illuminate\Support\Facades\DB::table('miembros_grupo')
                                ->join('users', 'miembros_grupo.id_usuario', '=', 'users.id_usuario')
                                ->where('miembros_grupo.id_grupo', $grupo->id_grupo)
                                ->where('miembros_grupo.id_usuario', '!=', auth()->user()->id_usuario)
                                ->where('miembros_grupo.estado_miembro', 'ACTIVO')
                                ->get();
                        @endphp

                        @if($integrantes->isNotEmpty())
                            <h5 class="fw-bold text-dark mb-3">Integrantes del Equipo</h5>
                            <div class="row g-3 mb-4">
                                @foreach($integrantes as $integrante)
                                    <div class="col-md-6">
                                        <div class="card border-light shadow-sm bg-light">
                                            <div class="card-body d-flex justify-content-between align-items-center p-3">
                                                <div>
                                                    <h6 class="fw-bold m-0">{{ $integrante->nombres }} {{ $integrante->apellidos }}</h6>
                                                    <small class="text-muted">{{ $integrante->carrera }}</small>
                                                </div>
                                                <form action="{{ route('grupos.expulsar', ['idGrupo' => $grupo->id_grupo, 'idUsuario' => $integrante->id_usuario]) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de expulsar a este integrante del grupo?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Expulsar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="text-muted">
                        @endif
                        <h5 class="fw-bold text-dark mb-4">Postulaciones Pendientes</h5>
                        
                        @php
                            $pendientes = $grupo->postulaciones->where('estado_postulacion', 'PENDIENTE');
                        @endphp

                        @if($pendientes->isEmpty())
                            <div class="alert alert-secondary text-center text-muted m-0" role="alert">
                                No tienes solicitudes nuevas en este momento.
                            </div>
                        @else
                            @foreach($pendientes as $postulacion)
                                <div class="card border-light shadow-sm mb-3">
                                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                        
                                        <div class="mb-3 mb-md-0">
                                            <h6 class="fw-bold text-dark mb-1">
                                                {{ $postulacion->usuario->nombres ?? 'Estudiante' }} {{ $postulacion->usuario->apellidos ?? '' }}
                                            </h6>
                                            <p class="text-dark fst-italic mb-2">"{{ $postulacion->mensaje_postulacion }}"</p>
                                            <span class="badge bg-light text-secondary border border-secondary">
                                                Carrera: {{ $postulacion->usuario->carrera ?? 'N/A' }}
                                            </span>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('postulaciones.responder', $postulacion->id_postulacion_grupo) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="accion" value="ACEPTAR">
                                                <button type="submit" class="btn btn-success fw-bold">
                                                    Aceptar
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('postulaciones.responder', $postulacion->id_postulacion_grupo) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="accion" value="RECHAZAR">
                                                <button type="submit" class="btn btn-danger fw-bold">
                                                    Rechazar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
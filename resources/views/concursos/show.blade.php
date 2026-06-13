@extends('layouts.teamup')

@section('title', $concurso->nombre_concurso)

@section('content')
<div class="mb-3">
    <a href="{{ route('concursos.index') }}" class="text-decoration-none text-dark fw-bold">
        &larr; Volver a concursos
    </a>
</div>

<h2 class="fw-bold text-dark mb-4">{{ $concurso->nombre_concurso }}</h2>

<div class="row">
    
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-light">
            <div class="card-body">
                <h4 class="card-title fw-bold mb-3">Detalles</h4>
                <p class="card-text">{{ $concurso->descripcion_concurso }}</p>
                
                <ul class="list-unstyled mt-3 mb-0">
                    <li class="mb-2"><strong>Área:</strong> {{ $concurso->area_concurso }}</li>
                    <li class="mb-2"><strong>Lugar:</strong> {{ $concurso->lugar }}</li>
                    <li><strong>Integrantes:</strong> {{ $concurso->minimo_integrantes }} a {{ $concurso->maximo_integrantes }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        
        @if(session('success'))
            <div class="alert alert-success fw-bold" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger fw-bold" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">Grupos buscando miembros</h3>
            
          @if(!$usuarioTieneGrupo)
                <a href="{{ route('grupos.crear', $concurso->id_concurso) }}" class="btn btn-success fw-bold">
                    + Crear mi grupo
                </a>
            @else
                @if($miembroActual->id_lider == auth()->user()->id_usuario)
                    <!-- Si es el líder, no puede abandonar, tiene que ir a Mis Grupos a disolverlo -->
                    <span class="badge bg-secondary p-2 fs-6">Eres el líder de tu equipo</span>
                @else
                    <!-- Si es integrante, le damos el botón para huir -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary p-2 fs-6">Ya eres miembro de un equipo</span>
                        <form action="{{ route('grupos.abandonar', $miembroActual->id_grupo) }}" method="POST" class="m-0" onsubmit="return confirm('¿Seguro que deseas abandonar tu equipo actual?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">Abandonar Equipo</button>
                        </form>
                    </div>
                @endif
            @endif
        </div>

        @if($grupos->isEmpty())
            <div class="alert alert-light border border-secondary text-center text-muted" role="alert">
                No hay grupos creados para este concurso.
            </div>
        @else
            @foreach($grupos as $grupo)
                <div class="card shadow-sm mb-3 border-light">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <h5 class="fw-bold mb-1">{{ $grupo->nombre_grupo }}</h5>
                            <p class="mb-1 text-dark">{{ $grupo->descripcion_grupo }}</p>
                            <small class="text-muted fw-bold">Líder: {{ $grupo->lider->nombres ?? 'Estudiante' }}</small>
                        </div>
                        
                       <div>
                        @php
                            // Solo mostramos "Solicitud Enviada" si existe una solicitud que siga PENDIENTE
                            $yaPostulo = $grupo->postulaciones
                                ->where('id_usuario', auth()->user()->id_usuario)
                                ->where('estado_postulacion', 'PENDIENTE')
                                ->isNotEmpty();
                            
                            // Contamos cuántos miembros activos tiene este grupo
                            $miembrosActuales = \Illuminate\Support\Facades\DB::table('miembros_grupo')
                                ->where('id_grupo', $grupo->id_grupo)
                                ->where('estado_miembro', 'ACTIVO')
                                ->count();
                            
                            $grupoLleno = $miembrosActuales >= $grupo->cupo_maximo;
                        @endphp

                        @if(auth()->user()->id_usuario == $grupo->id_lider)
                            <span class="badge bg-secondary p-2 fs-6">Eres el líder</span>
                        @elseif($usuarioTieneGrupo)
                            @elseif($yaPostulo)
                            <span class="badge bg-warning text-dark p-2 fs-6">Solicitud Enviada</span>
                        @elseif($grupoLleno)
                            <span class="badge bg-danger p-2 fs-6">Grupo Lleno ({{ $miembrosActuales }}/{{ $grupo->cupo_maximo }})</span>
                        @else
                            <form action="{{ route('grupos.postular', $grupo->id_grupo) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-primary fw-bold">
                                    Postularme ({{ $miembrosActuales }}/{{ $grupo->cupo_maximo }})
                                </button>
                            </form>
                        @endif
                    </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>
@endsection
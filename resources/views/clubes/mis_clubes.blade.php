@extends('layouts.teamup')

@section('title', 'Mis Clubes')

@section('content')
<h2 class="fw-bold text-dark mb-4">Panel de Gestión: Mis Clubes</h2>

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

@if($clubes->isEmpty())
    <div class="alert alert-light border border-secondary text-center text-muted p-5" role="alert">
        <p class="fs-5 m-0 text-dark">Actualmente no eres responsable de ningún club.</p>
    </div>
@else
    <div class="row">
        @foreach($clubes as $club)
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-light h-100">
                    
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                        <h4 class="fw-bold text-dark m-0">{{ $club->nombre_club }}</h4>
                        <span class="badge bg-dark p-2 fs-6">
                            Cupos Disponibles: {{ $club->cupos_disponibles }}
                        </span>
                    </div>

                    <div class="card-body">
                        <h5 class="fw-bold text-dark mb-4">Solicitudes Pendientes</h5>
                        
                        @php
                            $pendientes = \Illuminate\Support\Facades\DB::table('postulaciones_club')
                                ->join('users', 'postulaciones_club.id_usuario', '=', 'users.id_usuario')
                                ->where('postulaciones_club.id_club', $club->id_club)
                                ->where('postulaciones_club.estado_postulacion', 'PENDIENTE')
                                ->select('postulaciones_club.*', 'users.nombres', 'users.apellidos', 'users.carrera')
                                ->get();
                        @endphp

                        @if($pendientes->isEmpty())
                            <div class="alert alert-secondary text-center text-muted m-0" role="alert">
                                No tienes solicitudes nuevas en este momento.
                            </div>
                        @else
                            @foreach($pendientes as $postulacion)
                                <div class="card border-light shadow-sm mb-3">
                                    <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
                                        
                                        <div class="mb-3 mb-lg-0">
                                            <h6 class="fw-bold text-dark mb-1">
                                                {{ $postulacion->nombres }} {{ $postulacion->apellidos }}
                                            </h6>
                                            <p class="text-dark fst-italic mb-2">"{{ $postulacion->motivo_postulacion }}"</p>
                                            <p class="text-muted small mb-2">
                                                <strong>Experiencia:</strong> {{ $postulacion->experiencia_previa ?? 'Ninguna' }} <br>
                                                <strong>Horario:</strong> {{ $postulacion->disponibilidad_horaria }}
                                            </p>
                                            <span class="badge bg-light text-secondary border border-secondary">
                                                Carrera: {{ $postulacion->carrera }}
                                            </span>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('postulaciones_club.responder', $postulacion->id_postulacion_club) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="accion" value="ACEPTAR">
                                                <button type="submit" class="btn btn-success fw-bold">Aceptar</button>
                                            </form>
                                            
                                            <form action="{{ route('postulaciones_club.responder', $postulacion->id_postulacion_club) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="accion" value="RECHAZAR">
                                                <button type="submit" class="btn btn-danger fw-bold">Rechazar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                        <hr class="my-4 text-muted">
                      @php
                            $integrantes = \Illuminate\Support\Facades\DB::table('miembros_club')
                                ->join('users', 'miembros_club.id_usuario', '=', 'users.id_usuario')
                                ->where('miembros_club.id_club', $club->id_club)
                                ->where('miembros_club.estado_miembro', 'ACTIVO')
                                ->select('users.id_usuario', 'users.nombres', 'users.apellidos', 'users.carrera', 'miembros_club.fecha_ingreso')
                                ->get();
                        @endphp
                        
                        <h5 class="fw-bold text-dark mb-3">Integrantes del Club</h5>
                        
                        @if($integrantes->isEmpty())
                            <p class="text-muted">Aún no hay integrantes aprobados.</p>
                        @else
                            <div class="row g-3">
                                @foreach($integrantes as $integrante)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card border-light shadow-sm bg-light">
                                            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="fw-bold m-0">{{ $integrante->nombres }} {{ $integrante->apellidos }}</h6>
                                                    <small class="text-muted d-block mt-1">{{ $integrante->carrera }}</small>
                                                    <small class="text-secondary fw-bold">Se unió: {{ \Carbon\Carbon::parse($integrante->fecha_ingreso)->format('d/m/Y') }}</small>
                                                </div>
                                                
                                                <form action="{{ route('clubes.expulsar', ['idClub' => $club->id_club, 'idUsuario' => $integrante->id_usuario]) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de expulsar a este integrante del club? Se liberará un cupo.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Expulsar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
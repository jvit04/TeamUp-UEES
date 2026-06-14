@extends('layouts.teamup')

@section('title', $club->nombre_club)

@section('content')
<div class="mb-3">
    <a href="{{ route('clubes.index') }}" class="text-decoration-none text-dark fw-bold">
        &larr; Volver a clubes
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark m-0">{{ $club->nombre_club }}</h2>
    <span class="badge bg-secondary p-2 fs-6">
        Cupos: {{ $club->cupos_disponibles }}
    </span>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-light h-100">
            <div class="card-body">
                <h4 class="card-title fw-bold mb-3">Acerca del Club</h4>
                <p class="card-text">{{ $club->descripcion_club }}</p>

                <h5 class="fw-bold mt-4 mb-3">Detalles Adicionales</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Horario:</strong> {{ $club->horario }}</li>
                    <li class="mb-2"><strong>Lugar:</strong> {{ $club->lugar }}</li>
                    <li class="mb-2"><strong>Requisitos:</strong> {{ $club->requisitos }}</li>
                    <li class="mb-2"><strong>Contacto:</strong> {{ $club->contacto }}</li>
                    <li><strong>Responsable:</strong> {{ $club->responsable->nombres ?? 'Administrador' }} {{ $club->responsable->apellidos ?? '' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-light">
            <div class="card-body">
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

                @php
                    // Usamos auth()->id() como respaldo de seguridad adicional
                    $esResponsable = (auth()->check() && (auth()->user()->id_usuario == $club->id_responsable || auth()->id() == $club->id_responsable));
                @endphp

                @if($esResponsable)
                    <div class="alert alert-secondary text-center fw-bold m-0" role="alert">
                        Eres el responsable de este club.
                    </div>
                @elseif(isset($esMiembro) && $esMiembro)
                    <h5 class="fw-bold mb-3 text-center">Tu Membresía</h5>
                    <div class="alert alert-success text-center fw-bold mb-4" role="alert">
                        ¡Eres miembro oficial!
                    </div>
                    <form action="{{ route('clubes.abandonar', $club->id_club) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas abandonar el club? Liberarás tu cupo y tendrás que volver a postularte si deseas regresar.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger fw-bold w-100">
                            Abandonar Club
                        </button>
                    </form>
                @elseif(isset($postulacionPendiente) && $postulacionPendiente)
                    <h5 class="fw-bold mb-3 text-center">Estado de Solicitud</h5>
                    <div class="alert alert-warning text-center fw-bold text-dark mb-4" role="alert">
                        Tu solicitud ha sido enviada y está en revisión.
                    </div>
                    <form action="{{ route('clubes.cancelar_postulacion', $club->id_club) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar tu solicitud a este club?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger fw-bold w-100">
                            Cancelar Solicitud
                        </button>
                    </form>
                @elseif($club->cupos_disponibles <= 0)
                    <div class="alert alert-danger text-center fw-bold m-0" role="alert">
                        Este club ya no tiene cupos disponibles.
                    </div>
                @else
                    <h5 class="fw-bold mb-2">Únete al Club</h5>
                    <p class="text-muted small mb-4">Llena este formulario para enviar tu solicitud de ingreso. El responsable la revisará pronto.</p>

                    <form action="{{ route('clubes.postular', $club->id_club) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Motivo de postulación:</label>
                            <textarea name="motivo_postulacion" rows="2" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Experiencia previa (opcional):</label>
                            <textarea name="experiencia_previa" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Disponibilidad horaria:</label>
                            <input type="text" name="disponibilidad_horaria" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold w-100">
                            Enviar Postulación
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
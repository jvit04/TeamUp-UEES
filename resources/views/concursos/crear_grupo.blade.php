@extends('layouts.teamup')

@section('title', 'Crear Grupo')

@section('content')
<div class="mb-3">
    <a href="{{ route('concursos.show', $concurso->id_concurso) }}" class="text-decoration-none text-dark fw-bold">
        &larr; Volver al concurso
    </a>
</div>

<h2 class="fw-bold text-dark mb-4">Crear Grupo para: {{ $concurso->nombre_concurso }}</h2>

<div class="card shadow-sm border-light" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('grupos.guardar', $concurso->id_concurso) }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold text-dark">Nombre del Grupo</label>
                <input type="text" name="nombre_grupo" class="form-control @error('nombre_grupo') is-invalid @enderror" value="{{ old('nombre_grupo') }}" required>
                @error('nombre_grupo')
                    <div class="invalid-feedback fw-bold">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-dark">Descripción / ¿Qué perfiles buscas?</label>
                <textarea name="descripcion_grupo" rows="3" placeholder="Ej: Buscamos un integrante adicional que sepa programar o diseñar..." class="form-control" required>{{ old('descripcion_grupo') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Cupo Máximo (Total de integrantes)</label>
                <input type="number" name="cupo_maximo" min="{{ $concurso->minimo_integrantes }}" max="{{ $concurso->maximo_integrantes }}" value="{{ old('cupo_maximo', $concurso->minimo_integrantes) }}" class="form-control" required>
                <div class="form-text text-muted">Este concurso permite entre {{ $concurso->minimo_integrantes }} y {{ $concurso->maximo_integrantes }} personas.</div>
            </div>

            <button type="submit" class="btn btn-success fw-bold w-100 py-2">
                Guardar y Publicar Grupo
            </button>
        </form>
    </div>
</div>
@endsection
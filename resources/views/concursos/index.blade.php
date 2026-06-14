@extends('layouts.teamup')

@section('title', 'Concursos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark m-0">Concursos y Competencias</h2>
</div>

<div class="row g-4">
    @foreach($concursos as $concurso)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 border-light">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">{{ $concurso->nombre_concurso }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">{{ $concurso->area_concurso }}</h6>
                    
                    <p class="card-text text-dark flex-grow-1">{{ $concurso->descripcion_concurso }}</p>
                    
                    <div class="mb-4 text-dark small">
                        <strong>Modalidad:</strong> {{ $concurso->modalidad }} <br>
                        <strong>Cierre:</strong> {{ \Carbon\Carbon::parse($concurso->fecha_limite_inscripcion)->format('d/m/Y') }}
                    </div>

                    <a href="{{ route('concursos.show', $concurso->id_concurso) }}" class="text-decoration-none text-dark fw-bold mt-auto">
                        Ver detalles y grupos &rarr;
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
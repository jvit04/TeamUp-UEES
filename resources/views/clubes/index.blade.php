@extends('layouts.teamup')

@section('title', 'Clubes Universitarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark m-0">Clubes Universitarios</h2>
</div>

<div class="row g-4">
    @foreach($clubes as $club)
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-light border-start border-4 border-primary">
                <div class="card-body flex-column d-flex">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold text-dark m-0">{{ $club->nombre_club }}</h5>
                        <span class="badge bg-secondary p-2 ms-2 text-nowrap">
                            Cupos: {{ $club->cupos_disponibles }}
                        </span>
                    </div>
                    
                    <p class="small text-dark mb-3"><strong>Horario:</strong> {{ $club->horario }}</p>
                    <p class="card-text text-dark flex-grow-1">{{ $club->descripcion_club }}</p>
                    
                    <a href="{{ route('clubes.show', $club->id_club) }}" class="text-decoration-none text-dark fw-bold mt-auto">
                        Ver detalles y unirse &rarr;
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
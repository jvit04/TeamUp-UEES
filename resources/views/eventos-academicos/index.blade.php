@extends('layouts.teamup')

@section('title', 'Eventos Académicos | TeamUp UEES')

@push('styles')
<style>
    .events-hero {
        background: linear-gradient(135deg, #111827 0%, #7A1E2C 65%, #991B1B 100%);
        color: white;
        border-radius: 24px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .events-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -70px;
        top: -70px;
    }

    .events-hero h1,
    .events-hero p {
        position: relative;
        z-index: 1;
    }

    .event-card {
        border: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.10);
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.16);
    }

    .event-img {
        width: 100%;
        height: 210px;
        object-fit: cover;
        background: #f3f4f6;
    }

    .badge-event {
        background-color: #ede9fe;
        color: #5b21b6;
        border-radius: 999px;
        padding: 0.5rem 0.8rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    .info-label {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 0.1rem;
    }

    .info-value {
        color: #111827;
        font-weight: 600;
        margin-bottom: 0.7rem;
    }

    .section-title {
        font-weight: 800;
        color: #111827;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <section class="events-hero">
        <h1 class="display-5 fw-bold mb-3">Eventos Académicos</h1>
        <p class="lead mb-0">
            Consulta conferencias, seminarios y talleres publicados para la comunidad universitaria UEES.
        </p>
    </section>

    <section class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Próximos eventos</h2>
            <p class="text-muted mb-0">
                Eventos informativos relacionados con formación académica y extracurricular.
            </p>
        </div>

        <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">
            Volver al inicio
        </a>
    </section>

    @if($eventos->isEmpty())
        <div class="alert alert-info">
            Todavía no hay eventos académicos publicados.
        </div>
    @else
        <div class="row g-4">
            @foreach($eventos as $evento)
                <div class="col-12 col-md-6 col-xl-4">
                    <article class="card event-card">
                        @if($evento->imagen)
                            <img
                                src="{{ asset($evento->imagen) }}"
                                class="event-img"
                                alt="{{ $evento->nombre_evento }}"
                            >
                        @else
                            <div class="event-img d-flex align-items-center justify-content-center">
                                <span class="text-muted">Sin imagen</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="badge-event">EVENTO ACADÉMICO</span>
                            </div>

                            <h5 class="card-title fw-bold">
                                {{ $evento->nombre_evento }}
                            </h5>

                            <p class="card-text text-muted flex-grow-1">
                                {{ $evento->descripcion_evento }}
                            </p>

                            <div class="border-top pt-3 mt-2">
                                <p class="info-label">Fecha</p>
                                <p class="info-value">
                                    {{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y') }}
                                </p>

                                <p class="info-label">Horario</p>
                                <p class="info-value">
                                    {{ \Carbon\Carbon::parse($evento->hora_inicio)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($evento->hora_fin)->format('H:i') }}
                                </p>

                                <p class="info-label">Lugar</p>
                                <p class="info-value">
                                    {{ $evento->lugar }}
                                </p>

                                <p class="info-label">Modalidad</p>
                                <p class="info-value">
                                    {{ $evento->modalidad }}
                                </p>

                                <a
                                    href="{{ route('eventos-academicos.show', $evento->id_evento) }}"
                                    class="btn btn-danger w-100 mt-2"
                                >
                                    Ver detalle
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
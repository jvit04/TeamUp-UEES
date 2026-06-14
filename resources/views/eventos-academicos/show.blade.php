@extends('layouts.teamup')

@section('title', $evento->nombre_evento . ' | TeamUp UEES')

@push('styles')
<style>
    .detail-hero {
        background: linear-gradient(135deg, #7A1E2C 0%, #111827 100%);
        color: white;
        border-radius: 24px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .detail-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -80px;
        top: -80px;
    }

    .detail-hero h1,
    .detail-hero p,
    .detail-hero span {
        position: relative;
        z-index: 1;
    }

    .detail-img {
        width: 100%;
        max-height: 430px;
        object-fit: cover;
        border-radius: 22px;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.18);
        background: #f3f4f6;
    }

    .info-card {
        border: 0;
        border-radius: 20px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.10);
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
        margin-bottom: 1rem;
    }

    .section-title {
        font-weight: 800;
        color: #111827;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <section class="detail-hero">
        <span class="badge-event d-inline-block mb-3">EVENTO ACADÉMICO</span>

        <h1 class="display-5 fw-bold mb-3">
            {{ $evento->nombre_evento }}
        </h1>

        <p class="lead mb-0">
            {{ $evento->descripcion_evento }}
        </p>
    </section>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            @if($evento->imagen)
                <img
                    src="{{ asset($evento->imagen) }}"
                    alt="{{ $evento->nombre_evento }}"
                    class="detail-img mb-4"
                >
            @endif

            <div class="card info-card">
                <div class="card-body p-4">
                    <h2 class="section-title h4 mb-3">Descripción del evento</h2>

                    <p class="text-muted mb-0">
                        {{ $evento->descripcion_evento }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card info-card">
                <div class="card-body p-4">
                    <h2 class="section-title h4 mb-4">Información</h2>

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

                    <p class="info-label">Expositor</p>
                    <p class="info-value">
                        {{ $evento->expositor }}
                    </p>

                    <p class="info-label">Organizador</p>
                    <p class="info-value">
                        {{ $evento->organizador }}
                    </p>

                    <p class="info-label">Modalidad</p>
                    <p class="info-value">
                        {{ $evento->modalidad }}
                    </p>

                    <p class="info-label">Estado</p>
                    <p class="info-value">
                        {{ $evento->estado_evento }}
                    </p>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('eventos-academicos.index') }}" class="btn btn-danger">
                            Volver a eventos
                        </a>

                        <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">
                            Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
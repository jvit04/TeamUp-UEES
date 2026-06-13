@extends('layouts.teamup')

@section('title', 'Inicio | TeamUp UEES')

@push('styles')
<style>
    .hero-teamup {
        background: linear-gradient(135deg, #6b1024 0%, #9f1d35 55%, #111827 100%);
        color: white;
        border-radius: 24px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .hero-teamup::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -80px;
        top: -80px;
    }

    .hero-teamup h1 {
        font-weight: 800;
        position: relative;
        z-index: 1;
    }

    .hero-teamup p {
        max-width: 760px;
        position: relative;
        z-index: 1;
    }

    .stat-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }

    .publication-card {
        border: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.10);
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .publication-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.16);
    }

    .publication-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f3f4f6;
    }

    .badge-teamup {
        border-radius: 999px;
        padding: 0.5rem 0.8rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    .badge-concurso {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .badge-club {
        background-color: #e5e7eb;
        color: #111827;
    }

    .badge-evento {
        background-color: #ede9fe;
        color: #5b21b6;
    }

    .section-title {
        font-weight: 800;
        color: #111827;
    }

    .text-muted-small {
        font-size: 0.92rem;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <section class="hero-teamup">
        <h1 class="display-5 mb-3">Inicio TeamUp UEES</h1>
        <p class="lead mb-0">
            Explora publicaciones destacadas sobre concursos, clubes universitarios y eventos académicos.
            Este muro centraliza las actividades extracurriculares disponibles para la comunidad estudiantil.
        </p>
    </section>

    <section class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <div class="card stat-card text-center p-3">
                <h2 class="fw-bold mb-0">{{ $totales['publicaciones'] }}</h2>
                <p class="text-muted-small mb-0">Publicaciones</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card stat-card text-center p-3">
                <h2 class="fw-bold mb-0">{{ $totales['concursos'] }}</h2>
                <p class="text-muted-small mb-0">Concursos</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card stat-card text-center p-3">
                <h2 class="fw-bold mb-0">{{ $totales['clubes'] }}</h2>
                <p class="text-muted-small mb-0">Clubes</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card stat-card text-center p-3">
                <h2 class="fw-bold mb-0">{{ $totales['eventos'] }}</h2>
                <p class="text-muted-small mb-0">Eventos</p>
            </div>
        </div>
    </section>

    <section class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="section-title mb-1">Publicaciones recientes</h2>
            <p class="text-muted-small mb-0">
                Muro principal de anuncios académicos y extracurriculares.
            </p>
        </div>
    </section>

    @if($publicaciones->isEmpty())
        <div class="alert alert-info">
            Todavía no hay publicaciones disponibles.
        </div>
    @else
        <div class="row g-4">
            @foreach($publicaciones as $publicacion)
                <div class="col-12 col-md-6 col-xl-4">
                    <article class="card publication-card">
                        @if($publicacion->imagen)
                            <img
                                src="{{ asset($publicacion->imagen) }}"
                                class="publication-img"
                                alt="{{ $publicacion->titulo }}"
                            >
                        @else
                            <div class="publication-img d-flex align-items-center justify-content-center">
                                <span class="text-muted">Sin imagen</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                @if($publicacion->tipo_publicacion === 'CONCURSO')
                                    <span class="badge-teamup badge-concurso">CONCURSO</span>
                                @elseif($publicacion->tipo_publicacion === 'CLUB')
                                    <span class="badge-teamup badge-club">CLUB</span>
                                @else
                                    <span class="badge-teamup badge-evento">EVENTO ACADÉMICO</span>
                                @endif
                            </div>

                            <h5 class="card-title fw-bold">
                                {{ $publicacion->titulo }}
                            </h5>

                            <p class="card-text text-muted flex-grow-1">
                                {{ $publicacion->descripcion }}
                            </p>

                            <div class="border-top pt-3 mt-2">
                                @if($publicacion->tipo_publicacion === 'EVENTO_ACADEMICO' && $publicacion->fecha_evento)
                                    <p class="text-muted-small mb-3">
                                        Fecha del evento:
                                        {{ \Carbon\Carbon::parse($publicacion->fecha_evento)->format('d/m/Y') }}
                                    </p>
                                @else
                                    <p class="text-muted-small mb-3">
                                        Fecha de publicación:
                                        {{ \Carbon\Carbon::parse($publicacion->fecha_publicacion)->format('d/m/Y') }}
                                    </p>
                                @endif

                                @if($publicacion->tipo_publicacion === 'EVENTO_ACADEMICO')
                                    <a href="{{ route('eventos-academicos.index') }}" class="btn btn-outline-danger w-100">
                                        Ver eventos académicos
                                    </a>
                                @elseif($publicacion->tipo_publicacion === 'CONCURSO')
                                    <a href="{{ url('/concursos') }}" class="btn btn-outline-danger w-100">
                                        Ver concursos
                                    </a>
                                @else
                                    <a href="{{ url('/clubes') }}" class="btn btn-outline-danger w-100">
                                        Ver clubes
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
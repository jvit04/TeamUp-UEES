<div class="topbar-uees py-2">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <span>Portal de actividades extracurriculares</span>
        </div>

        <div class="d-flex align-items-center gap-3">
            @auth
                <span>{{ Auth::user()->nombres ?? 'Usuario' }}</span>

                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Cerrar sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
            @endauth
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-uees">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            TeamUp UEES
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTeamUp" aria-controls="navbarTeamUp" aria-expanded="false" aria-label="Abrir navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTeamUp">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('eventos-academicos*') ? 'active' : '' }}" href="{{ url('/eventos-academicos') }}">
                        Eventos académicos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('concursos*') ? 'active' : '' }}" href="{{ url('/concursos') }}">
                        Concursos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('clubes*') ? 'active' : '' }}" href="{{ url('/clubes') }}">
                        Clubes
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
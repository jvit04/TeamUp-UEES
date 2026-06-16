<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TeamUp UEES')</title>

    {{-- Favicon TeamUp --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}?v=2">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --uees-primary: #8B1538;
            --uees-primary-dark: #70112D;
            --uees-dark: #212529;
            --uees-light: #F8F9FA;
            --uees-border: #DEE2E6;
            --uees-text: #343A40;
        }

        body {
            background-color: #ffffff;
            color: var(--uees-text);
        }

        .topbar-uees {
            background-color: var(--uees-primary);
            color: white;
            font-size: 0.95rem;
        }

        .topbar-uees a {
            color: white;
            text-decoration: none;
        }

        .topbar-uees a:hover {
            text-decoration: underline;
        }

        .navbar-uees {
            background-color: #ffffff;
            border-bottom: 1px solid var(--uees-border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .navbar-uees .navbar-brand {
            color: var(--uees-primary);
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .navbar-uees .navbar-brand:hover {
            color: var(--uees-primary-dark);
        }

        .navbar-uees .nav-link {
            color: #6c757d;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .navbar-uees .nav-link:hover,
        .navbar-uees .nav-link.active {
            color: var(--uees-primary);
        }

        .btn-uees-primary {
            background-color: var(--uees-primary);
            color: white;
            border: none;
        }

        .btn-uees-primary:hover {
            background-color: var(--uees-primary-dark);
            color: white;
        }

        .btn-uees-dark {
            background-color: var(--uees-dark);
            color: white;
            border: none;
        }

        .btn-uees-dark:hover {
            background-color: #111418;
            color: white;
        }

        .teamup-card {
            border: 1px solid var(--uees-border);
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
        }

        .teamup-card .card-title {
            color: var(--uees-primary);
            font-weight: 700;
        }

        .teamup-footer {
            background-color: #111111;
            color: white;
            margin-top: 4rem;
        }

        .teamup-footer p {
            color: #d6d6d6;
        }

        .teamup-footer a {
            color: #f8f9fa;
            text-decoration: none;
        }

        .teamup-footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    @include('partials.teamup-navbar')

    <main class="container py-4 flex-grow-1">
        @yield('content')
    </main>

    @include('partials.teamup-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | TeamUp UEES</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}?v=2">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --teamup-vino: #8f0f3f;
            --teamup-vino-oscuro: #6f0b31;
            --teamup-gris: #f5f6f8;
            --teamup-texto: #111827;
            --teamup-muted: #6b7280;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f6f8;
            color: var(--teamup-texto);
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
        }

        .login-left {
            background: linear-gradient(135deg, var(--teamup-vino), var(--teamup-vino-oscuro));
            color: white;
            padding: 64px 78px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -120px;
            right: -90px;
        }

        .login-left::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            bottom: -90px;
            left: -70px;
        }

        .login-content {
            position: relative;
            z-index: 1;
            max-width: 560px;
        }

        .brand-small {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: 0.9;
            margin-bottom: 18px;
        }

        .login-left h1 {
            font-size: 54px;
            line-height: 1.05;
            margin: 0 0 20px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .login-left p {
            margin: 0;
            font-size: 18px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
        }

        .login-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 42px;
            background:
                radial-gradient(circle at top right, rgba(143, 15, 63, 0.08), transparent 35%),
                #f8fafc;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 28px;
            padding: 38px;
            box-shadow: 0 24px 70px rgba(17, 24, 39, 0.12);
            border: 1px solid rgba(143, 15, 63, 0.08);
        }

        .login-card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-box {
            width: 74px;
            height: 74px;
            border-radius: 24px;
            background: linear-gradient(135deg, var(--teamup-vino), var(--teamup-vino-oscuro));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 26px;
            font-weight: 900;
            box-shadow: 0 14px 30px rgba(143, 15, 63, 0.28);
        }

        .login-card h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 900;
            color: var(--teamup-vino);
        }

        .login-card .subtitle {
            margin: 8px 0 0;
            font-size: 14px;
            color: var(--teamup-muted);
        }

        .session-status {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            padding: 13px 15px;
            font-size: 15px;
            outline: none;
            transition: 0.2s ease;
            background: #ffffff;
        }

        .form-control:focus {
            border-color: var(--teamup-vino);
            box-shadow: 0 0 0 4px rgba(143, 15, 63, 0.12);
        }

        .form-error {
            margin-top: 7px;
            color: #dc2626;
            font-size: 13px;
            font-weight: 700;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin: 8px 0 24px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #4b5563;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: var(--teamup-vino);
        }

        .forgot-link {
            color: var(--teamup-vino);
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--teamup-vino), var(--teamup-vino-oscuro));
            color: white;
            padding: 14px 18px;
            font-size: 15px;
            font-weight: 900;
            cursor: pointer;
            transition: 0.2s ease;
            box-shadow: 0 12px 26px rgba(143, 15, 63, 0.25);
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 34px rgba(143, 15, 63, 0.32);
        }

        @media (max-width: 950px) {
            .login-page {
                grid-template-columns: 1fr;
            }

            .login-left {
                padding: 42px 28px;
                text-align: center;
            }

            .login-content {
                max-width: 100%;
            }

            .login-left h1 {
                font-size: 38px;
            }

            .login-right {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <main class="login-page">
        <section class="login-left">
            <div class="login-content">
                <div class="brand-small">TeamUp UEES</div>

                <h1>Conecta con tu comunidad universitaria</h1>

                <p>
                    Accede a concursos, clubes y eventos académicos desde un solo lugar.
                    Forma equipos, descubre oportunidades y participa activamente en la vida universitaria.
                </p>
            </div>
        </section>

        <section class="login-right">
            <div class="login-card">
                <div class="login-card-header">
                    <div class="logo-box">TU</div>

                    <h2>Iniciar sesión</h2>
                    <p class="subtitle">Ingresa con tu correo institucional UEES</p>
                </div>

                @if (session('status'))
                    <div class="session-status">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="correo_institucional" class="form-label">
                            Correo institucional
                        </label>

                        <input
                            id="correo_institucional"
                            class="form-control"
                            type="email"
                            name="correo_institucional"
                            value="{{ old('correo_institucional') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="usuario@uees.edu.ec"
                        >

                        @error('correo_institucional')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            Contraseña
                        </label>

                        <input
                            id="password"
                            class="form-control"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Ingresa tu contraseña"
                        >

                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="remember-row">
                        <label for="remember_me" class="remember">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Recordarme</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">
                        Entrar a TeamUp
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
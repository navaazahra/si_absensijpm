<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Supir</title>
    <style>
        * { box-sizing: border-box; }

        :root {
            --bg-1: #081226;
            --bg-2: #0f1d3a;
            --bg-3: #152a54;
            --card: rgba(255,255,255,0.08);
            --card-border: rgba(255,255,255,0.12);
            --text: #f8fafc;
            --muted: #cbd5e1;
            --input-bg: rgba(255,255,255,0.08);
            --input-border: rgba(255,255,255,0.14);
            --primary: #60a5fa;
            --danger-bg: rgba(239,68,68,0.14);
            --danger-text: #fecaca;
            --success-bg: rgba(34,197,94,0.14);
            --success-text: #bbf7d0;
            --shadow: 0 20px 60px rgba(0,0,0,0.35);
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            color: var(--text);
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(96,165,250,0.22), transparent 28%),
                radial-gradient(circle at bottom right, rgba(59,130,246,0.18), transparent 26%),
                linear-gradient(135deg, var(--bg-1), var(--bg-2) 45%, var(--bg-3));
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
            align-items: center;
            padding: 24px 16px;
        }

        .wrap {
            width: 100%;
            max-width: 1120px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
            align-items: center;
        }

        .showcase {
            display: none;
        }

        .showcase-card,
        .login-card {
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            background: var(--card);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow);
        }

        .showcase-card {
            border-radius: 30px;
            padding: 34px;
            min-height: 560px;
        }

        .showcase-badge {
            display: inline-flex;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.12);
            color: #dbeafe;
            font-size: 13px;
            font-weight: 600;
        }

        .showcase h1 {
            margin: 22px 0 12px;
            font-size: 46px;
            line-height: 1.05;
            letter-spacing: -0.03em;
            max-width: 520px;
        }

        .showcase p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.75;
            max-width: 520px;
        }

        .mini-panels {
            margin-top: 28px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            max-width: 470px;
        }

        .mini-panel {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .mini-panel strong {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .mini-panel span {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .login-card {
            width: 100%;
            max-width: 470px;
            margin: 0 auto;
            border-radius: 28px;
            padding: 26px 22px 22px;
        }

        .logo-img {
            width: 72px;
            height: 72px;
            object-fit: contain;
            border-radius: 18px;
            margin-bottom: 16px;
            padding: 8px;
            background: rgba(255,255,255,0.95);
            box-shadow: 0 16px 34px rgba(37,99,235,0.25);
            display: block;
        }

        .title {
            margin: 0;
            font-size: 34px;
            line-height: 1.08;
            letter-spacing: -0.03em;
        }

        .subtitle {
            margin: 10px 0 24px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .alert {
            padding: 13px 14px;
            border-radius: 14px;
            margin-bottom: 16px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .alert-danger {
            background: var(--danger-bg);
            color: var(--danger-text);
            border-color: rgba(239,68,68,0.18);
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: rgba(34,197,94,0.18);
        }

        .form-group {
            margin-bottom: 14px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #e2e8f0;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border-radius: 14px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            color: white;
            font-size: 15px;
            outline: none;
        }

        input::placeholder {
            color: #94a3b8;
        }

        input:focus {
            border-color: rgba(96,165,250,0.55);
            box-shadow: 0 0 0 4px rgba(96,165,250,0.12);
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 52px;
        }

        .eye-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #cbd5e1;
            cursor: pointer;
            font-size: 18px;
            padding: 6px;
            border-radius: 10px;
            transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }

        .eye-btn:hover {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .eye-btn:active {
            transform: translateY(-50%) scale(0.96);
        }

        .submit-btn {
            width: 100%;
            border: none;
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            background: linear-gradient(135deg, #60a5fa, #2563eb);
            box-shadow: 0 14px 30px rgba(37,99,235,0.3);
            margin-top: 4px;
            transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(37,99,235,0.38);
        }

        .submit-btn:active {
            transform: translateY(0);
            box-shadow: 0 10px 20px rgba(37,99,235,0.28);
            opacity: 0.96;
        }

        .forgot {
            text-align: center;
            margin-top: 14px;
        }

        .forgot a,
        .footer-links a {
            color: #bfdbfe;
            text-decoration: none;
            font-size: 14px;
            position: relative;
            transition: color 0.18s ease, opacity 0.18s ease;
        }

        .forgot a::after,
        .footer-links a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -3px;
            width: 100%;
            height: 1px;
            background: currentColor;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.18s ease;
        }

        .forgot a:hover,
        .footer-links a:hover {
            color: #dbeafe;
        }

        .forgot a:hover::after,
        .footer-links a:hover::after {
            transform: scaleX(1);
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 18px 0 14px;
        }

        .footer-links {
            display: grid;
            gap: 10px;
            text-align: center;
        }

        @media (min-width: 980px) {
            .wrap {
                grid-template-columns: 1.05fr 0.95fr;
            }

            .showcase {
                display: block;
            }
        }

        @media (max-width: 640px) {
            .login-card {
                padding: 22px 16px 18px;
            }

            .title {
                font-size: 28px;
            }

            .showcase h1 {
                font-size: 36px;
            }
        }

        .mini-panel {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        }

        .mini-panel:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,0.1);
            border-color: rgba(191,219,254,0.22);
        }

        .mini-panel {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        }

        .mini-panel:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,0.1);
            border-color: rgba(191,219,254,0.22);
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="wrap">
            <div class="showcase">
                <div class="showcase-card">
                    <span class="showcase-badge">PT Djanjikita Putra Mandiri</span>
                    <h1>Masuk ke Sistem Absensi & Operasional</h1>
                    <p>
                        Kelola jadwal supir, absensi berbasis lokasi, dokumentasi foto, dan validasi operasional
                        dalam satu sistem yang sederhana dan terstruktur.
                    </p>

                    <div class="mini-panels">
                        <div class="mini-panel">
                            <strong>Geolocation</strong>
                            <span>Lokasi dicatat real-time saat absensi dilakukan.</span>
                        </div>
                        <div class="mini-panel">
                            <strong>Live Photo</strong>
                            <span>Dokumentasi diambil langsung dari perangkat.</span>
                        </div>
                        <div class="mini-panel">
                            <strong>Validasi Admin</strong>
                            <span>Status absensi bisa ditinjau dan diputuskan admin.</span>
                        </div>
                        <div class="mini-panel">
                            <strong>Laporan</strong>
                            <span>Rekap absensi siap dipakai untuk evaluasi.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-card">
                <img src="{{ asset('images/logo_dpm.png') }}" alt="Logo PT Djanjikita Putra Mandiri" class="logo-img">
                <h1 class="title">Login</h1>
                <p class="subtitle">Masuk untuk mengakses Sistem Absensi Supir.</p>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->has('login'))
                    <div class="alert alert-danger">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                @if($errors->any() && !$errors->has('login'))
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrap">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Masukkan password"
                                required
                            >
                            <button type="button" class="eye-btn" id="togglePassword">👁</button>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Masuk ke Sistem</button>

                    <div class="forgot">
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    </div>
                </form>

                <div class="divider"></div>

                <div class="footer-links">
                    <a href="{{ route('admin.register') }}">Belum punya akun admin? Registrasi</a>
                    <a href="{{ route('guide.umum') }}">Lihat guidebook sistem</a>
                    <a href="{{ route('home') }}">Kembali ke halaman awal</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            this.textContent = isPassword ? '🙈' : '👁';
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Djanjikita Putra Mandiri - Sistem Absensi Supir</title>
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
            --primary: #60a5fa;
            --primary-strong: #2563eb;
            --shadow: 0 20px 60px rgba(0,0,0,0.32);
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(96,165,250,0.18), transparent 30%),
                radial-gradient(circle at bottom right, rgba(59,130,246,0.16), transparent 28%),
                linear-gradient(135deg, var(--bg-1), var(--bg-2) 45%, var(--bg-3));
            min-height: 100vh;
        }

        .page {
            width: 100%;
            max-width: 1160px;
            margin: 0 auto;
            padding: 24px 16px 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform 0.18s ease;
        }

        .brand:hover {
            transform: translateY(-1px);
        }

        .logo {
            width: 58px;
            height: 58px;
            object-fit: contain;
            border-radius: 14px;
            background: white;
            padding: 6px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.18);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .logo:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 14px 30px rgba(0,0,0,0.24);
        }

        .brand-text h1 {
            margin: 0;
            font-size: 18px;
        }

        .brand-text p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease, border-color 0.18s ease, opacity 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
            opacity: 0.96;
        }

        .btn-primary {
            background: linear-gradient(135deg, #60a5fa, #2563eb);
            color: white;
            box-shadow: 0 14px 30px rgba(37,99,235,0.28);
        }

        .btn-primary:hover {
            box-shadow: 0 18px 36px rgba(37,99,235,0.36);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.08);
            color: white;
            border: 1px solid rgba(255,255,255,0.12);
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(191,219,254,0.24);
            box-shadow: 0 10px 24px rgba(0,0,0,0.16);
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            align-items: stretch;
        }

        .hero-main, .hero-side {
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 30px;
            box-shadow: var(--shadow);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .hero-main:hover, .hero-side:hover {
            transform: translateY(-3px);
            box-shadow: 0 26px 60px rgba(0,0,0,0.36);
            border-color: rgba(191,219,254,0.18);
        }

        .hero-main {
            padding: 30px 24px;
        }

        .badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            font-size: 12px;
            font-weight: 700;
            color: #dbeafe;
            margin-bottom: 16px;
        }

        .hero-main h2 {
            margin: 0 0 12px;
            font-size: 34px;
            line-height: 1.1;
            letter-spacing: -0.03em;
            max-width: 700px;
        }

        .hero-main p {
            margin: 0;
            color: var(--muted);
            line-height: 1.8;
            font-size: 15px;
            max-width: 760px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            margin-top: 24px;
        }

        .feature {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px;
            padding: 16px;
            transition: transform 0.18s ease, background 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .feature:hover {
            transform: translateY(-4px);
            background: rgba(255,255,255,0.1);
            border-color: rgba(191,219,254,0.22);
            box-shadow: 0 16px 28px rgba(0,0,0,0.16);
        }

        .feature h3 {
            margin: 0 0 8px;
            font-size: 16px;
        }

        .feature p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .hero-side {
            padding: 22px;
        }

        .hero-side h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .hero-side p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            font-size: 14px;
        }

        .side-list {
            margin-top: 18px;
            display: grid;
            gap: 12px;
        }

        .side-item {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        }

        .side-item:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,0.1);
            border-color: rgba(191,219,254,0.22);
        }

        .side-item strong {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .footer {
            margin-top: 28px;
            padding: 18px 0 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
            color: var(--muted);
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (min-width: 920px) {
            .hero {
                grid-template-columns: 1.2fr 0.8fr;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-main h2 {
                font-size: 46px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <div class="brand">
                <img src="{{ asset('images/logo_dpm.png') }}" alt="Logo PT Djanjikita Putra Mandiri" class="logo">

                <div class="brand-text">
                    <h1>PT Djanjikita Putra Mandiri</h1>
                    <p>Sistem Absensi Supir Berbasis Web</p>
                </div>
            </div>

            <div class="top-actions">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('guide.umum') }}" class="btn btn-secondary">Panduan Sistem</a>
                <a href="{{ route('admin.register') }}" class="btn btn-secondary">Registrasi Admin</a>
                <a href="{{ route('petinggi.register') }}" class="btn btn-secondary">Registrasi Petinggi</a>
            </div>
        </div>

        <section class="hero">
            <div class="hero-main">
                <span class="badge">PT Djanjikita Putra Mandiri</span>
                <h2>Sistem Operasional dan Absensi Supir</h2>
                <p>
                    Sistem ini dirancang untuk membantu operasional perusahaan dalam mencatat kehadiran supir berdasarkan jadwal,
                    lokasi real-time, dan dokumentasi foto. Admin dapat memvalidasi absensi, sedangkan pimpinan dapat melihat laporan akhir
                    untuk kebutuhan evaluasi operasional.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk ke Sistem</a>
                    <a href="{{ route('guide.umum') }}" class="btn btn-secondary">Lihat Guidebook</a>
                </div>

                <div class="feature-grid">
                    <div class="feature">
                        <h3>Absensi berbasis lokasi</h3>
                        <p>Koordinat latitude dan longitude dicatat saat absensi dilakukan untuk membantu proses verifikasi.</p>
                    </div>
                    <div class="feature">
                        <h3>Dokumentasi foto langsung</h3>
                        <p>Foto diambil saat absensi berlangsung, sehingga data lebih relevan dan sesuai kondisi terkini.</p>
                    </div>
                    <div class="feature">
                        <h3>Validasi admin</h3>
                        <p>Absensi supir dapat diperiksa, disetujui, atau ditolak sesuai hasil pengecekan admin.</p>
                    </div>
                    <div class="feature">
                        <h3>Laporan operasional</h3>
                        <p>Rekap absensi dapat disusun dan dipantau sebagai bahan dokumentasi dan evaluasi perusahaan.</p>
                    </div>
                </div>
            </div>

            <aside class="hero-side">
                <h3>Akses Pengguna</h3>
                <p>Setiap role memiliki fungsi berbeda agar sistem tetap terstruktur dan mudah digunakan.</p>

                <div class="side-list">
                    <div class="side-item">
                        <strong>Supir</strong>
                        Melihat jadwal, melakukan absensi, dan memantau status validasi.
                    </div>
                    <div class="side-item">
                        <strong>Admin</strong>
                        Mengelola jadwal, memvalidasi absensi, dan menyusun laporan.
                    </div>
                    <div class="side-item">
                        <strong>Petinggi</strong>
                        Melihat laporan akhir sebagai bahan pemantauan operasional.
                    </div>
                </div>
            </aside>
        </section>

        <footer class="footer">
            <div>© {{ date('Y') }} PT Djanjikita Putra Mandiri</div>
            <div>Sistem Absensi Supir · Responsive Web Interface</div>
        </footer>
    </div>
</body>
</html>
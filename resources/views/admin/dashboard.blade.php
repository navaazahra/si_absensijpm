@extends('layouts.app')

@section('content')
    <style>
        .dashboard-menu {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 20px;
        }

        .menu-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .menu-card {
            position: relative;
            background: white;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
            min-height: 150px;
        }

        .menu-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #60a5fa, #2563eb);
            transform: scaleY(0);
            transform-origin: top;
            transition: transform 0.22s ease;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px rgba(37, 99, 235, 0.12);
            border-color: #bfdbfe;
        }

        .menu-card:hover::before {
            transform: scaleY(1);
        }

        .menu-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .menu-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
            font-size: 22px;
            flex-shrink: 0;
        }

        .menu-arrow {
            font-size: 20px;
            color: #9ca3af;
            transition: transform 0.22s ease, color 0.22s ease;
        }

        .menu-card:hover .menu-arrow {
            transform: translateX(4px);
            color: #2563eb;
        }

        .menu-card h3 {
            margin: 0 0 8px;
            font-size: 18px;
            color: #111827;
        }

        .menu-card p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.7;
        }

        .menu-hint {
            display: inline-block;
            margin-top: 14px;
            font-size: 13px;
            font-weight: 700;
            color: #2563eb;
        }

        @media (min-width: 768px) {
            .dashboard-menu {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="card">
        <span class="badge">Hak Akses: Admin</span>
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="text-muted">
            Selamat datang, <strong>{{ auth()->user()->display_name }}</strong>. Anda berada di pusat pengelolaan sistem absensi supir
            PT Djanjikita Putra Mandiri.
        </p>
    </div>

    <h2 class="section-title">Menu Utama</h2>

    <div class="dashboard-menu">
        <a href="{{ route('admin.supir.index') }}" class="menu-card-link">
            <div class="menu-card">
                <div class="menu-card-top">
                    <div class="menu-icon">👤</div>
                    <div class="menu-arrow">→</div>
                </div>
                <h3>Kelola Supir</h3>
                <p>Mengatur data supir dan identitas kendaraan operasional.</p>
                <span class="menu-hint">Buka Menu</span>
            </div>
        </a>

        <a href="{{ route('jadwal-absensi.index') }}" class="menu-card-link">
            <div class="menu-card">
                <div class="menu-card-top">
                    <div class="menu-icon">📅</div>
                    <div class="menu-arrow">→</div>
                </div>
                <h3>Jadwal Absensi</h3>
                <p>Membuat dan mengatur jadwal supir berdasarkan kebutuhan operasional.</p>
                <span class="menu-hint">Buka Menu</span>
            </div>
        </a>

        <a href="{{ route('admin.verifikasi.index') }}" class="menu-card-link">
            <div class="menu-card">
                <div class="menu-card-top">
                    <div class="menu-icon">✅</div>
                    <div class="menu-arrow">→</div>
                </div>
                <h3>Verifikasi Absensi</h3>
                <p>Memeriksa absensi normal maupun yang perlu konfirmasi dari supir.</p>
                <span class="menu-hint">Buka Menu</span>
            </div>
        </a>

        <a href="{{ route('admin.user.reset.index') }}" class="menu-card-link">
            <div class="menu-card">
                <div class="menu-card-top">
                    <div class="menu-icon">🔑</div>
                    <div class="menu-arrow">→</div>
                </div>
                <h3>Reset Password User</h3>
                <p>Membantu admin mengatur ulang password user yang lupa akses akun.</p>
                <span class="menu-hint">Buka Menu</span>
            </div>
        </a>

        <a href="{{ route('admin.laporan.index') }}" class="menu-card-link">
            <div class="menu-card">
                <div class="menu-card-top">
                    <div class="menu-icon">📄</div>
                    <div class="menu-arrow">→</div>
                </div>
                <h3>Laporan Absensi</h3>
                <p>Menyusun dan mengunggah laporan untuk periode tertentu.</p>
                <span class="menu-hint">Buka Menu</span>
            </div>
        </a>

        <a href="{{ route('guide.admin') }}" class="menu-card-link">
            <div class="menu-card">
                <div class="menu-card-top">
                    <div class="menu-icon">📘</div>
                    <div class="menu-arrow">→</div>
                </div>
                <h3>Panduan Admin</h3>
                <p>Petunjuk pengelolaan sistem, verifikasi, dan laporan.</p>
                <span class="menu-hint">Buka Panduan</span>
            </div>
        </a>
    </div>
@endsection
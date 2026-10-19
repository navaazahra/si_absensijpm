<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Absensi Supir' }}</title>
    <style>
        * { box-sizing: border-box; }

        :root {
            --primary: #1d4ed8;
            --primary-dark: #1e40af;
            --bg: #f3f4f6;
            --card: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --danger: #dc2626;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);
            --radius: 16px;
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 14px 16px;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .navbar-inner {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            object-fit: contain;
            border-radius: 14px;
            background: rgba(255,255,255,0.95);
            padding: 5px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        .brand-text {
            min-width: 0;
        }

        .brand-title {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.2;
            color: white;
        }

        .brand-subtitle {
            font-size: 12px;
            color: rgba(255,255,255,0.85);
            margin-top: 2px;
            line-height: 1.4;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .user-badge {
            font-size: 14px;
            background: rgba(255,255,255,0.14);
            padding: 8px 12px;
            border-radius: 999px;
            color: white;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            border: none;
            background: white;
            color: var(--primary);
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
        }

        .top-menu {
            background: white;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 76px;
            z-index: 15;
        }

        .top-menu-inner {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 16px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .menu-link {
            display: inline-flex;
            align-items: center;
            padding: 14px 4px;
            color: #374151;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: 0.2s ease;
        }

        .menu-link:hover {
            color: var(--primary);
        }

        .menu-link.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .container {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 20px 16px 32px;
        }

        .card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .page-title {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .text-muted {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 20px;
        }

        .menu-item {
            background: white;
            border-radius: var(--radius);
            padding: 18px;
            box-shadow: var(--shadow);
            border: 1px solid #edf2f7;
        }

        .menu-item h3 {
            margin: 0 0 8px;
            font-size: 18px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            background: #dbeafe;
            color: #1d4ed8;
            margin-bottom: 10px;
        }

        .section-title {
            margin: 22px 0 10px;
            font-size: 20px;
        }

        .footer {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 16px 22px;
            color: #6b7280;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (min-width: 768px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .top-menu {
                top: 98px;
            }
        }

        @media (max-width: 640px) {
            .brand-logo {
                width: 42px;
                height: 42px;
                border-radius: 12px;
            }

            .brand-title {
                font-size: 15px;
            }

            .brand-subtitle {
                font-size: 11px;
            }

            .user-badge {
                font-size: 13px;
            }

            .logout-btn {
                padding: 9px 12px;
                font-size: 13px;
            }

            .menu-link {
                padding: 12px 4px;
                font-size: 14px;
            }

            .top-menu {
                top: 90px;
            }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="navbar-inner">
            <div class="brand-wrap">
                <img src="{{ asset('images/logo_dpm.png') }}" alt="Logo PT Djanjikita Putra Mandiri" class="brand-logo">

                <div class="brand-text">
                    <div class="brand-title">PT Djanjikita Putra Mandiri</div>
                    <div class="brand-subtitle">Sistem Absensi Supir</div>
                </div>
            </div>

            <div class="nav-right">
                <div class="user-badge">
                    {{ auth()->user()->display_name ?? 'Guest' }}
                </div>

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </header>
    
    @auth
        <nav class="top-menu">
            <div class="top-menu-inner">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.supir.index') }}" class="menu-link {{ request()->routeIs('admin.supir.*') ? 'active' : '' }}">
                        Kelola Supir
                    </a>
                    <a href="{{ route('jadwal-absensi.index') }}" class="menu-link {{ request()->routeIs('jadwal-absensi.*') ? 'active' : '' }}">
                        Jadwal Absensi
                    </a>
                    <a href="{{ route('admin.verifikasi.index') }}" class="menu-link {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
                        Verifikasi Absensi
                    </a>
                    <a href="{{ route('admin.user.reset.index') }}" class="menu-link {{ request()->routeIs('admin.user.reset.*') ? 'active' : '' }}">
                        Reset Password User
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="menu-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        Laporan Absensi
                    </a>
                    <a href="{{ route('profil.index') }}" class="menu-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                        Profil
                    </a>

                @elseif(auth()->user()->role === 'supir')
                    <a href="{{ route('supir.dashboard') }}" class="menu-link {{ request()->routeIs('supir.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('supir.jadwal') }}" class="menu-link {{ request()->routeIs('supir.jadwal') ? 'active' : '' }}">
                        Jadwal Saya
                    </a>
                    <a href="{{ route('supir.absen') }}" class="menu-link {{ request()->routeIs('supir.absen') ? 'active' : '' }}">
                        Absen Sekarang
                    </a>
                    <a href="{{ route('supir.riwayat') }}" class="menu-link {{ request()->routeIs('supir.riwayat*') ? 'active' : '' }}">
                        Riwayat Absensi
                    </a>
                    <a href="{{ route('profil.index') }}" class="menu-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                        Profil
                    </a>
                    
                @elseif(auth()->user()->role === 'petinggi')
                    <a href="{{ route('petinggi.dashboard') }}" class="menu-link {{ request()->routeIs('petinggi.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('petinggi.laporan-final') }}" class="menu-link {{ request()->routeIs('petinggi.laporan-final') ? 'active' : '' }}">
                        Laporan Final
                    </a>
                    <a href="{{ route('petinggi.dokumentasi') }}" class="menu-link {{ request()->routeIs('petinggi.dokumentasi') ? 'active' : '' }}">
                        Dokumentasi Operasional
                    </a>
                    <a href="{{ route('profil.index') }}" class="menu-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                        Profil
                    </a>
                @endif
            </div>
        </nav>
    @endauth

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <div>© {{ date('Y') }} PT Djanjikita Putra Mandiri</div>
        <div>Sistem Absensi Supir</div>
    </footer>
</body>
</html>
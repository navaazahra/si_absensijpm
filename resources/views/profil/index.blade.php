@extends('layouts.app')

@section('content')
    <style>
        .profil-shell {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .profil-card {
            background: white;
            border-radius: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            overflow: hidden;
        }

        .profil-head {
            padding: 22px 22px 0;
        }

        .profil-head h2 {
            margin: 8px 0 6px;
            font-size: 24px;
        }

        .profil-head p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
            font-size: 14px;
        }

        .profil-body {
            padding: 22px;
        }

        .profil-hero {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .profil-avatar {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #60a5fa, #2563eb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 700;
            box-shadow: 0 12px 24px rgba(37,99,235,0.20);
        }

        .profil-name {
            margin: 0;
            font-size: 24px;
            color: #111827;
        }

        .profil-sub {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .profil-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .profil-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 16px;
        }

        .profil-label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .profil-value {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            line-height: 1.6;
            word-break: break-word;
        }

        .profil-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .btn-neutral-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #111827;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 13px 18px;
            font-weight: 700;
            text-decoration: none;
        }

        /* @media (min-width: 768px) {
            .profil-grid {
                grid-template-columns: 1fr 1fr;
            }
        } */

        .form-card {
            background: white;
            border-radius: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            overflow: hidden;
        }

        .form-head {
            padding: 22px 22px 0;
        }

        .form-head h2 {
            margin: 0;
            font-size: 24px;
        }

        .form-head p {
            margin: 8px 0 0;
            color: #6b7280;
            line-height: 1.7;
            font-size: 14px;
        }

        .form-body {
            padding: 22px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            font-size: 15px;
            outline: none;
            background: #fff;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 48px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border: none;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: background 0.18s ease, color 0.18s ease;
        }

        .toggle-password:hover {
            background: #f3f4f6;
            color: #2563eb;
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
        }

        .btn-primary-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 13px 18px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(37,99,235,0.18);
            transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
        }

        .btn-primary-soft:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(37,99,235,0.22);
        }

        .btn-primary-soft:active {
            transform: translateY(0);
            opacity: 0.96;
        }

        .alert-box {
            margin-top: 16px;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 14px;
            line-height: 1.7;
        }

        .alert-success {
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .note-box {
            margin-top: 18px;
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 14px;
            line-height: 1.7;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-group.full {
                grid-column: 1 / -1;
            }
        }
    </style>

    <div class="card">
        <span class="badge">Profil Pengguna</span>
        <h1 class="page-title">Profil</h1>
        <p class="text-muted">
            Lihat informasi akun dan data identitas Anda di sistem.
        </p>
    </div>
    @if(session('success'))
        <div class="alert-box alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-box alert-error">
            <strong style="display:block; margin-bottom:8px;">Terdapat kesalahan:</strong>
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br>
    <div class="profil-shell">
        <div class="profil-card">
            <div class="profil-head">
                <h2>Informasi Profil</h2>
            </div>

            <div class="profil-body">
                <div class="profil-hero">
                    <div class="profil-avatar">
                        {{ strtoupper(substr($user->display_name ?? $user->username, 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="profil-name">{{ $user->display_name }}</h3>
                        <p class="profil-sub">
                            {{ ucfirst($user->role) }} · Username: {{ $user->username }}
                        </p>
                    </div>
                </div>

                <div class="profil-grid">
                    <div class="profil-box">
                        <span class="profil-label">Nama Lengkap</span>
                        <div class="profil-value">{{ $user->display_name }}</div>
                    </div>

                    <div class="profil-box">
                        <span class="profil-label">Hak Akses</span>
                        <div class="profil-value">{{ ucfirst($user->role) }}</div>
                    </div>

                    <div class="profil-box">
                        <span class="profil-label">Username</span>
                        <div class="profil-value">{{ $user->username }}</div>
                    </div>

                    <div class="profil-box">
                        <span class="profil-label">Status Akun</span>
                        <div class="profil-value">{{ ucfirst($user->status_aktif) }}</div>
                    </div>

                    @if($user->role === 'admin' && $user->admin)
                        <div class="profil-box">
                            <span class="profil-label">No. HP</span>
                            <div class="profil-value">{{ $user->admin->no_hp ?? '-' }}</div>
                        </div>

                        <div class="profil-box">
                            <span class="profil-label">Alamat</span>
                            <div class="profil-value">{{ $user->admin->alamat ?? '-' }}</div>
                        </div>
                    @endif

                    @if($user->role === 'supir' && $user->supir)
                        <div class="profil-box">
                            <span class="profil-label">No. HP</span>
                            <div class="profil-value">{{ $user->supir->no_hp ?? '-' }}</div>
                        </div>

                        <div class="profil-box">
                            <span class="profil-label">Alamat</span>
                            <div class="profil-value">{{ $user->supir->alamat ?? '-' }}</div>
                        </div>

                        <div class="profil-box">
                            <span class="profil-label">No. Polisi</span>
                            <div class="profil-value">{{ $user->supir->no_polisi ?? '-' }}</div>
                        </div>

                        <div class="profil-box">
                            <span class="profil-label">Merk Truk</span>
                            <div class="profil-value">{{ $user->supir->merk_truk ?? '-' }}</div>
                        </div>

                        <div class="profil-box">
                            <span class="profil-label">Tahun Truk</span>
                            <div class="profil-value">{{ $user->supir->tahun_truk ?? '-' }}</div>
                        </div>
                    @endif

                    @if($user->role === 'petinggi' && $user->petinggi)
                        <div class="profil-box">
                            <span class="profil-label">Jabatan</span>
                            <div class="profil-value">{{ ucfirst($user->petinggi->jabatan ?? '-') }}</div>
                        </div>

                        <div class="profil-box">
                            <span class="profil-label">No. HP</span>
                            <div class="profil-value">{{ $user->petinggi->no_hp ?? '-' }}</div>
                        </div>

                        <div class="profil-box">
                            <span class="profil-label">Alamat</span>
                            <div class="profil-value">{{ $user->petinggi->alamat ?? '-' }}</div>
                        </div>
                    @endif
                </div>

                <div class="profil-actions">
                    @if($user->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-neutral-soft">Kembali ke Dashboard</a>
                    @elseif($user->role === 'supir')
                        <a href="{{ route('supir.dashboard') }}" class="btn-neutral-soft">Kembali ke Dashboard</a>
                    @elseif($user->role === 'petinggi')
                        <a href="{{ route('petinggi.dashboard') }}" class="btn-neutral-soft">Kembali ke Dashboard</a>
                    @endif
                </div>
            </div>
        </div>

        @if(in_array($user->role, ['admin', 'petinggi']))
            <div class="form-card">
                <div class="form-head">
                    <h2>Edit Profil</h2>
                    <p>Perbarui data akun dan identitas Anda di sistem.</p>
                </div>

                <div class="form-body">
                    <form method="POST" action="{{ route('profil.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input id="nama" type="text" name="nama" value="{{ old('nama', $user->display_name) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="no_hp">No. HP</label>
                                <input id="no_hp" type="text" name="no_hp"
                                    value="{{ old('no_hp', $user->role === 'admin' ? ($user->admin->no_hp ?? '') : ($user->petinggi->no_hp ?? '')) }}">
                            </div>

                            @if($user->role === 'petinggi')
                                <div class="form-group">
                                    <label for="jabatan">Jabatan</label>
                                    <select id="jabatan" name="jabatan" required>
                                        <option value="direktur" {{ old('jabatan', $user->petinggi->jabatan ?? '') == 'direktur' ? 'selected' : '' }}>Direktur</option>
                                        <option value="pimpinan" {{ old('jabatan', $user->petinggi->jabatan ?? '') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                    </select>
                                </div>
                            @endif

                            <div class="form-group full">
                                <label for="alamat">Alamat</label>
                                <textarea id="alamat" name="alamat">{{ old('alamat', $user->role === 'admin' ? ($user->admin->alamat ?? '') : ($user->petinggi->alamat ?? '')) }}</textarea>
                            </div>
                        </div>

                        <div class="profil-actions">
                            <button type="submit" class="btn-primary-soft">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if(in_array($user->role, ['admin', 'petinggi']))
            <div class="form-card">
                <div class="form-head">
                    <h2>Ganti Password</h2>
                    <p>Gunakan password lama Anda untuk mengatur password baru.</p>
                </div>

                <div class="form-body">
                    <form method="POST" action="{{ route('profil.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="password_lama">Password Lama</label>
                                <div class="password-wrapper">
                                    <input id="password_lama" type="password" name="password_lama" required>
                                    <button type="button" class="toggle-password" onclick="togglePassword('password_lama', this)" title="Lihat Password">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_baru">Password Baru</label>
                                <div class="password-wrapper">
                                    <input id="password_baru" type="password" name="password_baru" required>
                                    <button type="button" class="toggle-password" onclick="togglePassword('password_baru', this)" title="Lihat Password">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group full">
                                <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                                <div class="password-wrapper">
                                    <input id="password_baru_confirmation" type="password" name="password_baru_confirmation" required>
                                    <button type="button" class="toggle-password" onclick="togglePassword('password_baru_confirmation', this)" title="Lihat Password">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="profil-actions">
                            <button type="submit" class="btn-primary-soft">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="form-card">
                <div class="form-head">
                    <h2>Perubahan Data & Password</h2>
                </div>

                <div class="form-body">
                    <div class="note-box">
                        Untuk perubahan data profil atau reset password, silakan hubungi admin.
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);

            if (input.type === 'password') {
                input.type = 'text';
                button.title = 'Sembunyikan Password';
            } else {
                input.type = 'password';
                button.title = 'Lihat Password';
            }
        }
    </script>
@endsection
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: #f8fafc;
            color: #111827;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .card {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 14px 35px rgba(0,0,0,0.08);
        }

        .badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .subtitle {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
            font-size: 14px;
        }

        .alert {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 14px;
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

        .form-group {
            margin-top: 16px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 14px;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .example {
            display: block;
            margin-top: 6px;
            color: #6b7280;
            font-size: 12px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 46px;
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
            border-radius: 8px;
        }

        .toggle-password:hover {
            background: #f3f4f6;
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
        }

        .note {
            margin-top: 18px;
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
            padding: 14px;
            border-radius: 14px;
            font-size: 14px;
            line-height: 1.7;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: #2563eb;
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0,0,0,0.18);
        }

        .btn-light {
            background: #e5e7eb;
            color: #111827;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0,0,0,0.18);
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <span class="badge">Registrasi Admin</span>
            <h1>Buat Akun Admin</h1>
            <p class="subtitle">
                Registrasi ini hanya untuk admin yang memiliki kode akses resmi dari perusahaan.
            </p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <strong style="display:block; margin-bottom:8px;">Terdapat kesalahan:</strong>
                    <ul style="margin:0; padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Admin</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Contoh: Rina Pratiwi" required>
                    <small class="example">Isi nama lengkap admin.</small>
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890">
                    <small class="example">Gunakan nomor aktif yang bisa dihubungi.</small>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" placeholder="Contoh: Kudus, Jawa Tengah">{{ old('alamat') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="Contoh: admin.rina" required>
                    <small class="example">Gunakan username unik tanpa spasi.</small>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input id="password" name="password" type="password" placeholder="Minimal 6 karakter" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" title="Lihat Password">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)" title="Lihat Password">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="kode_akses">Kode Admin Khusus</label>
                    <input id="kode_akses" name="kode_akses" type="text" value="{{ old('kode_akses') }}" placeholder="Contoh: DPM-ADM-2026" required>
                    <small class="example">Kode ini diberikan oleh pihak perusahaan.</small>
                </div>

                <div class="note">
                    Registrasi hanya akan berhasil jika kode akses admin sesuai dengan kode yang telah ditetapkan pada sistem.
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Daftar Admin</button>
                    <a href="{{ route('login') }}" class="btn btn-light">Kembali ke Login</a>
                </div>
            </form>

            <div class="footer">
                © {{ date('Y') }} PT Djanjikita Putra Mandiri
            </div>
        </div>
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
</body>
</html>
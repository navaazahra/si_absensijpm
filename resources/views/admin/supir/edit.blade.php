@extends('layouts.app')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.07);
        border: 1px solid #edf2f7;
        margin-top: 20px;
    }

    .form-section {
        margin-top: 18px;
    }

    .form-section h3 {
        margin: 0 0 10px;
        font-size: 16px;
        color: #111827;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
    }

    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .form-group {
        display: grid;
        gap: 6px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 12px;
        padding: 11px 13px;
        font-size: 14px;
        outline: none;
        width: 100%;
    }

    textarea {
        resize: vertical;
    }

    .form-actions {
        margin-top: 18px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-primary-soft {
        background: #2563eb;
        color: white;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-neutral-soft {
        background: #f3f4f6;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 700;
        text-decoration: none;
    }

    .btn-danger-soft {
        background: #dc2626;
        color: white;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 700;
        border: none;
        cursor: pointer;
    }

    .alert-box {
        margin-top: 16px;
        border-radius: 16px;
        padding: 14px 16px;
        font-size: 14px;
        line-height: 1.7;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
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
        border-radius: 8px;
    }

    .toggle-password:hover {
        background: #f3f4f6;
    }

    .toggle-password svg {
        width: 18px;
        height: 18px;
    }
</style>

<div class="card">
    <h1 class="page-title">Edit Supir</h1>
    <p class="text-muted">Perbarui data supir, akun login, status aktif, dan reset password bila diperlukan.</p>
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

<div class="form-card">
    <form action="{{ route('admin.supir.update', $supir->supir_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3>Data Supir</h3>

            <div class="form-grid">
                <div class="form-group">
                    <label>ID Supir</label>
                    <input value="{{ $supir->supir_id }}" disabled>
                </div>

                <div class="form-group">
                    <label>Nama Supir</label>
                    <input name="nama_supir" value="{{ old('nama_supir', $supir->nama_supir) }}" required>
                </div>

                <div class="form-group">
                    <label>No Polisi</label>
                    <input name="no_polisi" value="{{ old('no_polisi', $supir->no_polisi) }}" required>
                </div>

                <div class="form-group">
                    <label>Merk Truk</label>
                    <input name="merk_truk" value="{{ old('merk_truk', $supir->merk_truk) }}">
                </div>

                <div class="form-group">
                    <label>Tahun Truk</label>
                    <input type="number" name="tahun_truk" value="{{ old('tahun_truk', $supir->tahun_truk) }}">
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input name="no_hp" value="{{ old('no_hp', $supir->no_hp) }}">
                </div>

                <div class="form-group">
                    <label>Status Akun</label>
                    <select name="status_aktif" required>
                        <option value="aktif" {{ old('status_aktif', $supir->user->status_aktif ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status_aktif', $supir->user->status_aktif) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat">{{ old('alamat', $supir->alamat) }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>Akun Login</h3>

            <div class="form-grid">
                <div class="form-group">
                    <label>Username</label>
                    <input name="username" value="{{ old('username', $supir->user->username ?? '') }}" required>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary-soft">Simpan Perubahan</button>
            <a href="{{ route('admin.supir.index') }}" class="btn-neutral-soft">Kembali</a>
        </div>
    </form>
</div>

<div class="form-card">
    <div class="form-section" style="margin-top:0;">
        <h3>Reset Password Supir</h3>

        <form action="{{ route('admin.supir.reset-password', $supir->supir_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password_baru" id="password_baru" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password_baru', this)" title="Lihat Password">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password_baru_confirmation" id="password_baru_confirmation" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password_baru_confirmation', this)" title="Lihat Password">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-danger-soft">Reset Password</button>
            </div>
        </form>
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
@endsection
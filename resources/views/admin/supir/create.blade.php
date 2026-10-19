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
    .form-group textarea {
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

    .alert-box {
        margin-top: 16px;
        border-radius: 16px;
        padding: 14px 16px;
        font-size: 14px;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>

<div class="card">
    <h1 class="page-title">Tambah Supir</h1>
    <p class="text-muted">Buat akun login sekaligus data supir untuk digunakan dalam sistem absensi.</p>
</div>

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
<form action="{{ route('admin.supir.store') }}" method="POST">
@csrf

    <!-- DATA SUPIR -->
    <div class="form-section">
        <h3>Data Supir</h3>

        <div class="form-grid">
            <div class="form-group">
                <label>Nama Supir</label>
                <input name="nama_supir" value="{{ old('nama_supir') }}" required>
            </div>

            <div class="form-group">
                <label>No Polisi</label>
                <input name="no_polisi" value="{{ old('no_polisi') }}" required>
            </div>

            <div class="form-group">
                <label>Merk Truk</label>
                <input name="merk_truk" value="{{ old('merk_truk') }}">
            </div>

            <div class="form-group">
                <label>Tahun Truk</label>
                <input name="tahun_truk" type="number" value="{{ old('tahun_truk') }}">
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input name="no_hp" value="{{ old('no_hp') }}">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat">{{ old('alamat') }}</textarea>
            </div>
        </div>
    </div>

    <!-- AKUN LOGIN -->
    <div class="form-section">
        <h3>Akun Login</h3>

        <div class="form-grid">
            <div class="form-group">
                <label>Username</label>
                <input name="username" value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>
    </div>

    <!-- ACTION -->
    <div class="form-actions">
        <button type="submit" class="btn-primary-soft">Simpan</button>

        <a href="{{ route('admin.supir.index') }}" class="btn-neutral-soft">
            Kembali
        </a>
    </div>

</form>
</div>

@endsection
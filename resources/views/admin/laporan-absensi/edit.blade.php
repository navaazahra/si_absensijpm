@extends('layouts.app')

@section('content')
    <style>
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            margin-top: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 12px;
            padding: 11px 13px;
            font-size: 14px;
            outline: none;
        }

        .btn-primary-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-neutral-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            line-height: 1.7;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .file-preview {
            margin-top: 8px;
            font-size: 13px;
        }
    </style>

    <div class="card">
        <span class="badge">Hak Akses: Admin</span>
        <h1 class="page-title">Edit Laporan Absensi</h1>
        <p class="text-muted">
            Perbarui data laporan, periode, petinggi, atau ganti file scan laporan final.
        </p>
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
        <form action="{{ route('admin.laporan.update', $laporan->laporan_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>ID Laporan</label>
                    <input type="text" value="{{ $laporan->laporan_id }}" disabled>
                </div>

                <div class="form-group">
                    <label>Periode Mulai</label>
                    <input type="date" name="periode_mulai" value="{{ old('periode_mulai', $laporan->periode_awal?->format('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label>Periode Selesai</label>
                    <input type="date" name="periode_selesai" value="{{ old('periode_selesai', $laporan->periode_akhir?->format('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label>Direktur / Petinggi</label>
                    <select name="petinggi_id">
                        <option value="">-- Pilih Direktur / Petinggi --</option>
                        @foreach($daftarPetinggi as $petinggi)
                            <option value="{{ $petinggi->petinggi_id }}"
                                {{ old('petinggi_id', $laporan->petinggi_id) == $petinggi->petinggi_id ? 'selected' : '' }}>
                                {{ $petinggi->nama_petinggi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>File Scan Laporan Baru</label>
                    <input type="file" name="file_laporan" accept=".pdf,.jpg,.jpeg,.png">

                    <div class="file-preview">
                        File saat ini:
                        @if($laporan->file_laporan)
                            <a href="{{ asset('storage/laporan-final/' . $laporan->file_laporan) }}" target="_blank">
                                {{ $laporan->file_laporan }}
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="margin-top:20px; display:flex; gap:10px; flex-wrap:wrap;">
                <button type="submit" class="btn-primary-soft">Simpan Perubahan</button>
                <a href="{{ route('admin.laporan.index') }}" class="btn-neutral-soft">Kembali</a>
            </div>
        </form>
    </div>
@endsection
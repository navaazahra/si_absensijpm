@extends('layouts.app')

@section('content')
    <style>
        .form-shell {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-card {
            background: white;
            border-radius: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            overflow: hidden;
        }

        .form-card-head {
            padding: 22px 22px 0;
        }

        .form-card-head h2 {
            margin: 8px 0 6px;
            font-size: 24px;
        }

        .form-card-head p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
            font-size: 14px;
        }

        .error-box {
            margin-top: 16px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 16px;
            padding: 14px 16px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-body {
            padding: 22px;
        }

        .form-grid-custom {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .field-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 16px;
        }

        .field-box label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }

        .field-box input,
        .field-box select {
            width: 100%;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 12px;
            padding: 13px 14px;
            font-size: 15px;
            outline: none;
        }

        .field-box input:focus,
        .field-box select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.10);
        }

        .field-help {
            display: block;
            margin-top: 7px;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.6;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .btn-primary-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 13px 18px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.18);
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

        @media (min-width: 768px) {
            .form-grid-custom {
                grid-template-columns: 1fr 1fr;
            }

            .field-full {
                grid-column: 1 / -1;
            }
        }
    </style>

    <div class="card">
        <span class="badge">Jadwal Absensi</span>
        <h1 class="page-title">Tambah Jadwal Absensi</h1>
        <p class="text-muted">
            Lengkapi data jadwal absensi supir dengan rapi agar proses operasional lebih mudah dipantau.
        </p>
    </div>

    @if($errors->any())
        <div class="error-box">
            <strong style="display:block; margin-bottom:8px;">Terdapat kesalahan input:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <br>
    <div class="form-shell">
        <div class="form-card">
            <div class="form-card-head">
                <h2>Form Jadwal</h2>
                <p>Masukkan data jadwal absensi sesuai kebutuhan operasional PT Djanjikita Putra Mandiri.</p>
            </div>

            <div class="form-body">
                <form action="{{ route('jadwal-absensi.store') }}" method="POST">
                    @csrf

                    <div class="form-grid-custom">
                        <div class="field-box field-full">
                            <label for="supir_id">Pilih Supir</label>
                            <select name="supir_id" id="supir_id" required>
                                <option value="">-- Pilih Supir --</option>
                                @foreach($supirs as $supir)
                                    <option value="{{ $supir->supir_id }}" {{ old('supir_id') == $supir->supir_id ? 'selected' : '' }}>
                                        {{ $supir->nama_supir }} - {{ $supir->no_polisi }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="field-help">Pilih supir yang akan diberikan jadwal absensi.</small>
                        </div>

                        <div class="field-box">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                            <small class="field-help">Tanggal awal periode absensi.</small>
                        </div>

                        <div class="field-box">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                            <small class="field-help">Tanggal akhir periode absensi.</small>
                        </div>
                        
                        <div class="field-box">
                            <label for="kota_asal">Kota Asal</label>
                            <input type="text" name="kota_asal" id="kota_asal" value="{{ old('kota_asal') }}" placeholder="Contoh: Jakarta" required>
                            <small class="field-help">Isi kota keberangkatan operasional.</small>
                        </div>

                        <div class="field-box">
                            <label for="kota_tujuan">Kota Tujuan</label>
                            <input type="text" name="kota_tujuan" id="kota_tujuan" value="{{ old('kota_tujuan') }}" placeholder="Contoh: Bandung" required>
                            <small class="field-help">Isi kota tujuan operasional.</small>
                        </div>
                      
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary-soft">Simpan Jadwal</button>
                        <a href="{{ route('jadwal-absensi.index') }}" class="btn-neutral-soft">Kembali</a>
                    </div>
                </form>
                <br>
                <div class="field-box field-full">
                    <label>Informasi Otomatis</label>
                    <div style="color:#374151; line-height:1.7;">
                        <ul>
                            <li>Jam absensi akan otomatis diset dari <strong>00:00</strong> sampai <strong>23:59</strong> WIB.</li>
                            <li>Status jadwal akan otomatis menyesuaikan tanggal saat ini.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
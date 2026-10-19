@extends('layouts.app')

@section('content')
    <style>
        .detail-shell {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .detail-card {
            background: white;
            border-radius: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            overflow: hidden;
        }

        .detail-head {
            padding: 22px 22px 0;
        }

        .detail-head h2 {
            margin: 8px 0 6px;
            font-size: 24px;
        }

        .detail-head p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
            font-size: 14px;
        }

        .detail-body {
            padding: 22px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 16px;
        }

        .info-label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            line-height: 1.6;
        }

        .info-sub {
            display: block;
            margin-top: 4px;
            color: #6b7280;
            font-size: 13px;
            font-weight: 400;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status-aktif {
            background: #dcfce7;
            color: #166534;
        }

        .status-nonaktif {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-selesai {
            background: #e0f2fe;
            color: #075985;
        }

        .detail-actions {
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

        .btn-danger-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 13px 18px;
            font-weight: 700;
            cursor: pointer;
        }

        @media (min-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    <div class="card">
        <span class="badge">Jadwal Absensi</span>
        <h1 class="page-title">Detail Jadwal Absensi</h1>
        <p class="text-muted">
            Lihat informasi lengkap jadwal absensi supir PT Djanjikita Putra Mandiri.
        </p>
    </div>
    <br>
    <div class="detail-shell">
        <div class="detail-card">
            <div class="detail-head">
                <h2>Informasi Jadwal</h2>
                <p>Detail data jadwal yang tersimpan di sistem.</p>
            </div>

            <div class="detail-body">
                <div class="info-grid">
                    <div class="info-box">
                        <span class="info-label">ID Jadwal</span>
                        <div class="info-value">{{ $jadwalAbsensi->jadwal_id }}</div>
                    </div>

                    <div class="info-box">
                        <span class="info-label">Status Jadwal</span>
                        <div class="info-value">
                            <span class="status-badge status-{{ $jadwalAbsensi->status_jadwal }}">
                                {{ $jadwalAbsensi->status_jadwal }}
                            </span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-label">Nama Supir</span>
                        <div class="info-value">
                            {{ $jadwalAbsensi->supir->nama_supir ?? '-' }}
                            <span class="info-sub">No. Polisi: {{ $jadwalAbsensi->supir->no_polisi ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-label">Periode Jadwal</span>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($jadwalAbsensi->tanggal_mulai)->format('d M Y') }}
                            <span class="info-sub">s/d {{ \Carbon\Carbon::parse($jadwalAbsensi->tanggal_selesai)->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-label">Jam Absen</span>
                        <div class="info-value">
                            {{ $jadwalAbsensi->jam_absen_mulai }} - {{ $jadwalAbsensi->jam_absen_selesai }}
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-label">Rute Operasional</span>
                        <div class="info-value">
                            {{ $jadwalAbsensi->kota_asal }} → {{ $jadwalAbsensi->kota_tujuan }}
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-label">Dibuat Pada</span>
                        <div class="info-value">
                            {{ $jadwalAbsensi->created_at?->format('d M Y H:i') ?? '-' }} WIB
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-label">Diperbarui Pada</span>
                        <div class="info-value">
                            {{ $jadwalAbsensi->updated_at?->format('d M Y H:i') ?? '-' }} WIB
                        </div>
                    </div>
                </div>

                <div class="detail-actions">
                    <a href="{{ route('jadwal-absensi.edit', $jadwalAbsensi->jadwal_id) }}" class="btn-primary-soft">Edit Jadwal</a>
                    <a href="{{ route('jadwal-absensi.index') }}" class="btn-neutral-soft">Kembali</a>

                    <form action="{{ route('jadwal-absensi.destroy', $jadwalAbsensi->jadwal_id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-soft">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
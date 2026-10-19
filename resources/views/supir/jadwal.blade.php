@extends('layouts.app')

@section('content')
    <style>
        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
            flex-wrap: wrap;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 20px;
        }

        .summary-card {
            background: white;
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
        }

        .summary-card h3 {
            margin: 0 0 8px;
            font-size: 16px;
        }

        .summary-card p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
            font-size: 14px;
        }

        .jadwal-list {
            display: grid;
            gap: 16px;
            margin-top: 22px;
        }

        .jadwal-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
        }

        .jadwal-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .jadwal-id {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .jadwal-title {
            margin: 0;
            font-size: 20px;
            color: #111827;
        }

        .jadwal-subtitle {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
            white-space: nowrap;
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

        .jadwal-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            margin-top: 14px;
        }

        .jadwal-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 14px;
        }

        .jadwal-label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .jadwal-value {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            line-height: 1.6;
        }

        .jadwal-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .btn-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 700;
            text-decoration: none;
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
            padding: 12px 16px;
            font-weight: 700;
            text-decoration: none;
        }

        .empty-state {
            background: white;
            border-radius: 20px;
            padding: 28px 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            text-align: center;
            margin-top: 20px;
        }

        .empty-state h3 {
            margin: 0 0 8px;
        }

        .empty-state p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
        }

        @media (min-width: 768px) {
            .summary-grid,
            .jadwal-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    <div class="card">
        <div class="page-head">
            <div>
                <span class="badge">Hak Akses: Supir</span>
                <h1 class="page-title">Jadwal Saya</h1>
                <p class="text-muted">
                    Lihat jadwal absensi Anda dan pantau periode operasional yang sedang berjalan.
                </p>
            </div>
        </div>
    </div>

    @if($supir)
        <div class="summary-grid">
            <div class="summary-card">
                <h3>Nama Supir</h3>
                <p>{{ $supir->nama_supir }}</p>
            </div>

            <div class="summary-card">
                <h3>Kendaraan</h3>
                <p>{{ $supir->merk_truk ?? '-' }} · {{ $supir->no_polisi ?? '-' }} · Tahun {{ $supir->tahun_truk ?? '-' }}</p>
            </div>
        </div>
    @endif

    @if($jadwals->count())
        <div class="jadwal-list">
            @foreach($jadwals as $jadwal)
                <div class="jadwal-card">
                    <div class="jadwal-top">
                        <div>
                            <span class="jadwal-id">{{ $jadwal->jadwal_id }}</span>
                            <h2 class="jadwal-title">{{ $jadwal->kota_asal }} → {{ $jadwal->kota_tujuan }}</h2>
                            <p class="jadwal-subtitle">
                                Jadwal absensi untuk kebutuhan operasional supir.
                            </p>
                        </div>

                        <div>
                            <span class="status-badge status-{{ $jadwal->status_jadwal }}">
                                {{ $jadwal->status_jadwal }}
                            </span>
                        </div>
                    </div>

                    <div class="jadwal-grid">
                        <div class="jadwal-box">
                            <span class="jadwal-label">Periode Jadwal</span>
                            <div class="jadwal-value">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}
                                s/d
                                {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="jadwal-box">
                            <span class="jadwal-label">Jam Absensi</span>
                            <div class="jadwal-value">
                                {{ $jadwal->jam_absen_mulai }} - {{ $jadwal->jam_absen_selesai }}
                            </div>
                        </div>
                    </div>

                    <div class="jadwal-actions">
                        <a href="{{ route('supir.absen') }}" class="btn-soft">Absen Sekarang</a>
                        <a href="{{ route('supir.dashboard') }}" class="btn-neutral-soft">Kembali ke Dashboard</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <h3>Belum ada jadwal</h3>
            <p>
                Saat ini Anda belum memiliki jadwal absensi. Silakan hubungi admin operasional.
            </p>
        </div>
    @endif
@endsection
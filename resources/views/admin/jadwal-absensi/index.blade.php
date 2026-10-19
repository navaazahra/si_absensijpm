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

        .page-head-left h1 {
            margin: 8px 0 6px;
        }

        .page-head-right {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-soft {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            background: #2563eb;
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.18);
        }

        .btn-outline-soft {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #111827;
            border: 1px solid #dbe3ef;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .alert-success-box {
            margin-top: 18px;
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(22, 163, 74, 0.06);
        }

        .table-card {
            margin-top: 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            overflow: hidden;
            border: 1px solid #edf2f7;
        }

        .table-card-head {
            padding: 18px 18px 0;
        }

        .table-card-head h2 {
            margin: 0 0 6px;
            font-size: 20px;
        }

        .table-card-head p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.7;
        }

        .table-wrap {
            overflow-x: auto;
            padding: 18px;
        }

        .jadwal-table {
            width: 100%;
            min-width: 980px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .jadwal-table thead th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .jadwal-table tbody td {
            padding: 16px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #111827;
            line-height: 1.6;
            text-align: center;
        }

        .jadwal-table tbody tr:hover {
            background: #fbfdff;
        }

        .id-chip {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
        }

        .route-text {
            font-weight: 700;
            color: #1f2937;
        }

        .muted-sm {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-top: 2px;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
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

        .action-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-mini {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            line-height: 1;
        }

        .btn-detail {
            background: #e7edf8;
            color: #111827;
        }

        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .empty-state {
            padding: 30px 20px 36px;
            text-align: center;
            color: #6b7280;
        }

        .empty-state h3 {
            margin: 0 0 8px;
            color: #111827;
        }

        @media (max-width: 640px) {
            .table-card-head {
                padding: 16px 16px 0;
            }

            .table-wrap {
                padding: 16px;
            }
        }
    </style>

    <div class="card">
        <div class="page-head">
            <div class="page-head-left">
                <span class="badge">Jadwal Absensi</span>
                <h1 class="page-title">Data Jadwal Absensi</h1>
                <p class="text-muted">
                    Kelola jadwal absensi supir PT Djanjikita Putra Mandiri
                </p>
            </div>

            <div class="page-head-right">
                <a href="{{ route('jadwal-absensi.create') }}" class="btn-soft">+ Tambah Jadwal</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-box">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div style="margin-top: 16px; background: #fffbeb; color: #92400e; border: 1px solid #fde68a; border-radius: 16px; padding: 14px 16px;">
            {{ session('warning') }}
        </div>
    @endif

    <div class="table-card">
        <div class="table-card-head">
            <h2>Daftar Jadwal</h2>
            <p>Data jadwal absensi supir ditampilkan berdasarkan data yang tersimpan di sistem.</p>
        </div>

        <div class="table-wrap">
            @if($jadwals->count())
                <table class="jadwal-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Jadwal</th>
                            <th>Supir</th>
                            <th>Periode</th>
                            <th>Jam Absensi</th>
                            <th>Rute</th>
                            <th>Status</th>
                            <th style="min-width: 190px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $index => $jadwal)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <span class="id-chip">{{ $jadwal->jadwal_id }}</span>
                                </td>

                                <td>
                                    <strong>{{ $jadwal->supir->nama_supir ?? '-' }}</strong>
                                    <span class="muted-sm">{{ $jadwal->supir->no_polisi ?? '-' }}</span>
                                </td>

                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}</strong>
                                    <span class="muted-sm">s/d {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}</span>
                                </td>

                                <td>
                                    <strong>{{ $jadwal->jam_absen_mulai }}</strong>
                                    <span class="muted-sm">sampai {{ $jadwal->jam_absen_selesai }}</span>
                                </td>

                                <td>
                                    <span class="route-text">{{ $jadwal->kota_asal }} → {{ $jadwal->kota_tujuan }}</span>
                                </td>

                                <td>
                                    <span class="status-badge status-{{ $jadwal->status_jadwal }}">
                                        {{ $jadwal->status_jadwal }}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('jadwal-absensi.show', $jadwal->jadwal_id) }}" class="btn-mini btn-detail">Detail</a>
                                        <a href="{{ route('jadwal-absensi.edit', $jadwal->jadwal_id) }}" class="btn-mini btn-edit">Edit</a>

                                        <form action="{{ route('jadwal-absensi.destroy', $jadwal->jadwal_id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-mini btn-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <h3>Belum ada data jadwal</h3>
                    <p>Silakan tambahkan jadwal absensi baru untuk mulai mengelola data operasional supir.</p>
                    <div style="margin-top:16px;">
                        <a href="{{ route('jadwal-absensi.create') }}" class="btn-soft">+ Tambah Jadwal Pertama</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <style>
        .page-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            margin-top: 20px;
        }

        .table-wrap {
            overflow-x: auto;
            margin-top: 18px;
        }

        .laporan-table {
            width: 100%;
            min-width: 1100px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .laporan-table thead th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .laporan-table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #111827;
            text-align: center;
        }

        .laporan-table tbody tr:hover {
            background: #fbfdff;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
            white-space: nowrap;
            background: #dcfce7;
            color: #166534;
        }

        .action-cell {
            white-space: nowrap;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            transition: 0.2s ease;
            background: white;
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
        }

        .icon-btn-view {
            background: #f3f4f6;
            color: #111827;
            border: 1px solid #e5e7eb;
        }

        .icon-btn-download {
            background: #dbeafe;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .icon-btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .table-footer {
            margin-top: 18px;
            display: flex;
            justify-content: flex-end;
        }

        .empty-state {
            text-align: center;
            color: #6b7280;
            padding: 22px 16px !important;
        }

        .filter-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: end;
            margin-top: 16px;
        }

        .filter-group {
            display: grid;
            gap: 6px;
        }

        .filter-group label {
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }

        .filter-group input {
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 12px;
            padding: 11px 13px;
            font-size: 14px;
            outline: none;
            min-width: 180px;
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
    </style>

    <div class="page-card">
        <span class="badge">Hak Akses: Petinggi</span>
        <h1 class="page-title">Laporan Final</h1>
        <p class="text-muted">
            Daftar laporan absensi final yang telah dibuat dan diunggah oleh admin.
        </p>

        <form method="GET" action="{{ route('petinggi.laporan-final') }}" class="filter-form">
            <div class="filter-group">
                <label for="periode_mulai">Periode Mulai</label>
                <input type="date" name="periode_mulai" id="periode_mulai" value="{{ $periodeMulai }}">
            </div>

            <div class="filter-group">
                <label for="periode_selesai">Periode Selesai</label>
                <input type="date" name="periode_selesai" id="periode_selesai" value="{{ $periodeSelesai }}">
            </div>

            <button type="submit" class="btn-primary-soft">Filter</button>

            <a href="{{ route('petinggi.laporan-final') }}" class="btn-neutral-soft">
                Reset
            </a>
        </form>

        <div class="table-wrap">
            <table class="laporan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Laporan</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Admin</th>
                        <th>Petinggi</th>
                        <th>Waktu Dibuat</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $index => $laporan)
                        <tr>
                            <td>{{ $laporans->firstItem() + $index }}</td>
                            <td>{{ $laporan->laporan_id }}</td>
                            <td>
                                {{ $laporan->periode_awal?->format('d M Y') }} s/d
                                {{ $laporan->periode_akhir?->format('d M Y') }}
                            </td>
                            <td>
                                <span class="status-badge">
                                    {{ ucfirst($laporan->status_laporan) }}
                                </span>
                            </td>
                            <td>{{ $laporan->admin->nama_admin ?? '-' }}</td>
                            <td>{{ $laporan->petinggi->nama_petinggi ?? '-' }}</td>
                            <td>{{ $laporan->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    @if($laporan->file_laporan)
                                        <a href="{{ asset('storage/laporan-final/' . $laporan->file_laporan) }}"
                                           target="_blank"
                                           class="icon-btn icon-btn-view"
                                           title="Lihat File">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.laporan.download', $laporan->laporan_id) }}"
                                           class="icon-btn icon-btn-download"
                                           title="Unduh File">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14" />
                                            </svg>
                                        </a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">Belum ada laporan final.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            {{ $laporans->links() }}
        </div>
    </div>
@endsection
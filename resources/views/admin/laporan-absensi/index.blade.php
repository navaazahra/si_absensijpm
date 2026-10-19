@extends('layouts.app')
@php
    \Carbon\Carbon::setLocale('id');
@endphp
@section('content')
    <style>
        .laporan-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            margin-top: 20px;
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

        .filter-group input,
        .filter-group select {
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

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 20px;
        }

        .summary-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 16px;
        }

        .summary-box h3 {
            margin: 0 0 8px;
            font-size: 14px;
            color: #6b7280;
        }

        .summary-box p {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .table-wrap {
            overflow-x: auto;
            margin-top: 18px;
        }

        .laporan-table {
            width: 100%;
            min-width: 1200px;
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
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #111827;
            line-height: 1.6;
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
        }

        .status-normal {
            background: #e0f2fe;
            color: #075985;
        }

        .status-perlu_konfirmasi {
            background: #fffbeb;
            color: #92400e;
        }

        .status-disetujui {
            background: #dcfce7;
            color: #166534;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #991b1b;
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

        .upload-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            margin-top: 16px;
        }

        .upload-grid input,
        .upload-grid select {
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 12px;
            padding: 11px 13px;
            font-size: 14px;
            outline: none;
            width: 100%;
        }

        .arsip-table {
            width: 100%;
            min-width: 900px;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 18px;
        }

        .arsip-table thead th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .arsip-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            vertical-align: middle;
            text-align: center;
        }

        @media (min-width: 768px) {
            .summary-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        .action-cell {
            white-space: nowrap;
            text-align: center;
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

        .icon-btn-edit {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .icon-btn-delete {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .icon-btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .arsip-table {
            table-layout: auto;
        }

        .arsip-table th,
        .arsip-table td {
            text-align: center;
            vertical-align: middle;
        }

    </style>

    <div class="card">
        <span class="badge">Hak Akses: Admin</span>
        <h1 class="page-title">Laporan Absensi</h1>
        <p class="text-muted">
            Rekap data absensi berdasarkan periode, cetak laporan siap tanda tangan, dan unggah scan laporan final.
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

    <div class="laporan-card">
        <h2 style="margin:0 0 6px;">Filter Periode</h2>
        <p class="text-muted" style="margin:0;">Pilih periode untuk menampilkan rekap laporan absensi.</p>

        <form method="GET" action="{{ route('admin.laporan.index') }}" class="filter-form">
            <div class="filter-group">
                <label for="periode_mulai">Periode Mulai</label>
                <input type="date" name="periode_mulai" id="periode_mulai" value="{{ $periodeMulai }}">
            </div>

            <div class="filter-group">
                <label for="periode_selesai">Periode Selesai</label>
                <input type="date" name="periode_selesai" id="periode_selesai" value="{{ $periodeSelesai }}">
            </div>

            <button type="submit" class="btn-primary-soft">Tampilkan</button>

            <a href="{{ route('admin.laporan.cetak', ['periode_mulai' => $periodeMulai, 'periode_selesai' => $periodeSelesai]) }}"
               target="_blank"
               class="btn-neutral-soft">
                Cetak Laporan
            </a>
            <a href="{{ route('admin.laporan.export-excel', ['periode_mulai' => $periodeMulai, 'periode_selesai' => $periodeSelesai]) }}"
            class="btn-neutral-soft">
                Export Excel (CSV)
            </a>
        </form>

        <div class="summary-grid">
            <div class="summary-box">
                <h3>Total</h3>
                <p>{{ $ringkasan['total'] }}</p>
            </div>

            <div class="summary-box">
                <h3>Normal</h3>
                <p>{{ $ringkasan['normal'] }}</p>
            </div>

            <div class="summary-box">
                <h3>Perlu Konfirmasi</h3>
                <p>{{ $ringkasan['perlu_konfirmasi'] }}</p>
            </div>

            <div class="summary-box">
                <h3>Disetujui</h3>
                <p>{{ $ringkasan['disetujui'] }}</p>
            </div>

            <div class="summary-box">
                <h3>Ditolak</h3>
                <p>{{ $ringkasan['ditolak'] }}</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="laporan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu Absensi</th>
                        <th>Supir</th>
                        <th>ID Jadwal</th>
                        <th>Progress</th>
                        <th>Rute</th>
                        <th>Status</th>
                        <th>Validator</th>
                        <th>Keterangan Supir</th>
                        <th>Alasan Penolakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensis as $index => $absensi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $absensi->waktu_absensi?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                            <td>{{ $absensi->supir->nama_supir ?? '-' }}</td>
                            <td>{{ $absensi->jadwal_id }}</td>
                            <td>{{ $absensi->progress_absensi ?? '-' }}</td>
                            <td>{{ $absensi->jadwal->kota_asal ?? '-' }} → {{ $absensi->jadwal->kota_tujuan ?? '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ $absensi->status_absensi }}">
                                    {{ str_replace('_', ' ', $absensi->status_absensi) }}
                                </span>
                            </td>
                            <td>{{ $absensi->validator->nama_admin ?? '-' }}</td>
                            <td>{{ $absensi->alasan ?? '-' }}</td>
                            <td>{{ $absensi->alasan_penolakan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center;">Tidak ada data absensi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="laporan-card">
        <h2 style="margin:0 0 6px;">Upload Scan Laporan Final</h2>
        <p class="text-muted" style="margin:0;">
            Unggah dokumen scan yang sudah ditandatangani lengkap oleh admin dan direktur.
        </p>

        <form action="{{ route('admin.laporan.upload-scan') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="upload-grid">
                <div>
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:700;">Periode Mulai</label>
                    <input type="date" name="periode_mulai" value="{{ $periodeMulai }}" required>
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:700;">Periode Selesai</label>
                    <input type="date" name="periode_selesai" value="{{ $periodeSelesai }}" required>
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:700;">Direktur / Pimpinan</label>
                    <select name="petinggi_id">
                        <option value="">-- Pilih Direktur / Pimpinan --</option>
                        @foreach($daftarPetinggi as $petinggi)
                            <option value="{{ $petinggi->petinggi_id }}">
                                {{ $petinggi->nama_petinggi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:700;">File Scan Laporan</label>
                    <input type="file" name="file_laporan" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
            </div>

            <div style="margin-top:16px;">
                <button type="submit" class="btn-primary-soft">Upload Scan Laporan</button>
            </div>
        </form>
    </div>

    <div class="laporan-card">
        <h2 style="margin:0 0 6px;">Arsip Laporan</h2>
        <p class="text-muted" style="margin:0;">
            Daftar laporan yang sudah dibuat dan/atau diunggah.
        </p>

        <form method="GET" action="{{ route('admin.laporan.index') }}" class="filter-form">
            <div class="filter-group">
                <label for="arsip_periode_mulai">Periode Mulai Arsip</label>
                <input type="date" name="arsip_periode_mulai" id="arsip_periode_mulai" value="{{ $arsipPeriodeMulai }}">
            </div>

            <div class="filter-group">
                <label for="arsip_periode_selesai">Periode Selesai Arsip</label>
                <input type="date" name="arsip_periode_selesai" id="arsip_periode_selesai" value="{{ $arsipPeriodeSelesai }}">
            </div>

            <input type="hidden" name="periode_mulai" value="{{ $periodeMulai }}">
            <input type="hidden" name="periode_selesai" value="{{ $periodeSelesai }}">

            <button type="submit" class="btn-primary-soft">Cari</button>

            <a href="{{ route('admin.laporan.index', [
                'periode_mulai' => $periodeMulai,
                'periode_selesai' => $periodeSelesai
            ]) }}" class="btn-neutral-soft">
                Reset
            </a>
        </form>

        <div class="table-wrap">
            <table class="arsip-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Laporan</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Staf Operasional</th>
                        <th>Direktur / Petinggi</th>
                        <th>Waktu Dibuat</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsipLaporan as $index => $arsip)
                        <tr>
                            <td>{{ $arsipLaporan->firstItem() + $index }}</td>
                            <td>{{ $arsip->laporan_id }}</td>
                            <td>
                                {{ $arsip->periode_awal?->format('d M Y') }} s/d {{ $arsip->periode_akhir?->format('d M Y') }}
                            </td>
                            <td>{{ ucfirst($arsip->status_laporan) }}</td>
                            <td>{{ $arsip->admin->nama_admin ?? '-' }}</td>
                            <td>{{ $arsip->petinggi->nama_petinggi ?? '-' }}</td>
                            <td>{{ $arsip->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    @if($arsip->file_laporan)
                                        <a href="{{ asset('storage/laporan-final/' . $arsip->file_laporan) }}"
                                        target="_blank"
                                        class="icon-btn icon-btn-view"
                                        title="Lihat">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.laporan.download', $arsip->laporan_id) }}"
                                        class="icon-btn icon-btn-download"
                                        title="Unduh">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14" />
                                            </svg>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.laporan.edit', $arsip->laporan_id) }}"
                                    class="icon-btn icon-btn-edit"
                                    title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 3.487a2.25 2.25 0 1 1 3.182 3.182L7.5 19.213 3 20.25l1.037-4.5L16.862 3.487Z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.laporan.destroy', $arsip->laporan_id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus laporan ini?')"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="icon-btn icon-btn-delete"
                                                title="Hapus">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 7h12m-10 0V5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m-9 0 1 12a1 1 0 0 0 1 .917h6a1 1 0 0 0 1-.917L17 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;">Belum ada arsip laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px; display:flex; justify-content:center;">
            {{ $arsipLaporan->links() }}
        </div>
    </div>
@endsection
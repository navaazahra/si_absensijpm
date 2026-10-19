@extends('layouts.app')
@php
    \Carbon\Carbon::setLocale('id');
@endphp
@section('content')
<style>
    .page-card {
        background: white;
        border-radius: 20px;
        padding: 22px;
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

    .filter-group input {
        border: 1px solid #d1d5db;
        border-radius: 12px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .btn-primary-soft {
        background: #2563eb;
        color: white;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 700;
        border: none;
        cursor: pointer;
    }

    .btn-neutral-soft {
        background: #f3f4f6;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 700;
        text-decoration: none;
        color: #111827;
        border: 1px solid #e5e7eb;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-top: 20px;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .summary-box h3 {
        margin: 0 0 6px;
        font-size: 13px;
        color: #6b7280;
    }

    .summary-box p {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #111827;
    }

    .section-title {
        margin-top: 28px;
        font-size: 18px;
        font-weight: 700;
        text-align: center;
    }

    .table-wrap {
        margin-top: 16px;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 14px;
        font-size: 13px;
        text-align: center;
        border-bottom: 1px solid #e5e7eb;
    }

    .custom-table td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .custom-table tr:hover {
        background: #fbfdff;
    }

    .empty-state {
        padding: 20px;
        color: #6b7280;
    }

    .chart-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    .chart-box {
        margin-top: 14px;
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 16px;
    }

    .chart-box canvas {
        width: 100% !important;
        height: 320px !important;
    }

    @media (min-width: 992px) {
        .chart-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 900px) {
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="page-card">
    <span class="badge">Hak Akses: Petinggi</span>
    <h1 class="page-title">Dokumentasi Operasional</h1>
    <p class="text-muted">
        Ringkasan operasional berdasarkan absensi supir dalam periode tertentu.
    </p>

    {{-- FILTER --}}
    <form method="GET" class="filter-form">
        <div class="filter-group">
            <label>Periode Mulai</label>
            <input type="date" name="periode_mulai" value="{{ $periodeMulai }}">
        </div>

        <div class="filter-group">
            <label>Periode Selesai</label>
            <input type="date" name="periode_selesai" value="{{ $periodeSelesai }}">
        </div>

        <button type="submit" class="btn-primary-soft">Filter</button>

        <a href="{{ route('petinggi.dokumentasi') }}" class="btn-neutral-soft">Reset</a>
    </form>

    {{-- STATISTIK --}}
    <div class="summary-grid">
        <div class="summary-box">
            <h3>Total Absensi</h3>
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

    <div class="chart-grid">
        <div class="page-card">
            <h2 class="section-title">Grafik Status Absensi</h2>
            <div class="chart-box">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="page-card">
            <h2 class="section-title">Supir Paling Aktif (Top 5)</h2>
            <div class="chart-box">
                <canvas id="supirChart"></canvas>
            </div>
        </div>
    </div>

    <div id="chart-data"
        data-status-labels='@json($statusChartLabels)'
        data-status-data='@json($statusChartData)'
        data-supir-labels='@json($supirChartLabels)'
        data-supir-data='@json($supirChartData)'>
    </div>
</div>

{{-- SUPIR TERAKTIF --}}
<div class="page-card">
    <h2 class="section-title">🧑‍✈️ Supir Paling Aktif</h2>

    <div class="table-wrap">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supir</th>
                    <th>Total Absensi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($supirTeraktif as $supir)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $supir['nama'] }}</td>
                        <td>{{ $supir['total'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- TABEL LAPORAN --}}
<div class="page-card">
    <h2 class="section-title">📋 Daftar Laporan Final</h2>

    <div class="table-wrap">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Laporan</th>
                    <th>Periode</th>
                    <th>Admin</th>
                    <th>Waktu Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $i => $laporan)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $laporan->laporan_id }}</td>
                        <td>
                            {{ $laporan->periode_awal?->translatedFormat('d F Y') }} s/d {{ $laporan->periode_akhir?->translatedFormat('d F Y') }}                        
                        </td>
                        <td>{{ $laporan->admin->nama_admin ?? '-' }}</td>
                        <td>{{ $laporan->created_at?->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartDataEl = document.getElementById('chart-data');

    const statusLabels = JSON.parse(chartDataEl.dataset.statusLabels);
    const statusData = JSON.parse(chartDataEl.dataset.statusData);
    const supirLabels = JSON.parse(chartDataEl.dataset.supirLabels);
    const supirData = JSON.parse(chartDataEl.dataset.supirData);

    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Jumlah Absensi',
                data: statusData,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('supirChart'), {
        type: 'bar',
        data: {
            labels: supirLabels,
            datasets: [{
                label: 'Total Absensi',
                data: supirData,
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endsection
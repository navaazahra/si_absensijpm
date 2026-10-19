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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-header-left h1 {
            margin: 0 0 6px;
            font-size: 24px;
            color: #111827;
        }

        .page-header-left p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
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

        .table-wrap {
            overflow-x: auto;
            margin-top: 18px;
        }

        .supir-table {
            width: 100%;
            min-width: 1400px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .supir-table thead th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .supir-table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #111827;
            text-align: center;
        }

        .supir-table tbody tr:hover {
            background: #fbfdff;
        }

        .text-left {
            text-align: left !important;
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

        .icon-btn-toggle-active {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .icon-btn-toggle-inactive {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .pagination {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
            align-items: center;
        }

        .pagination li {
            list-style: none;
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 10px;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            color: #374151;
            background: white;
            font-size: 14px;
        }

        .pagination li.active span {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .pagination li.disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <div class="page-card">
        <div class="page-header">
            <div class="page-header-left">
                <h1>Kelola Supir</h1>
                <p>Kelola data supir beserta akun login yang digunakan untuk absensi dan riwayat jadwal.</p>
            </div>

            <a href="{{ route('admin.supir.create') }}" class="btn-primary-soft">
                + Tambah Supir
            </a>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrap">
            <table class="supir-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th style="width: 90px;">ID Supir</th>
                        <th style="width: 100px;">Nama Supir</th>
                        <th style="width: 90px;">Username</th>
                        <th style="width: 40px;">No Polisi</th>
                        <th style="width: 70px;">Merk Truk</th>
                        <th style="width: 80px;">Tahun</th>
                        <th style="width: 80px;">No HP</th>
                        <th style="width: 200px;">Alamat</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supirs as $index => $supir)
                        <tr>
                            <td>{{ $supirs->firstItem() + $index }}</td>
                            <td>{{ $supir->supir_id }}</td>
                            <td class="text-left">{{ $supir->nama_supir }}</td>
                            <td>{{ $supir->user->username ?? '-' }}</td>
                            <td>{{ $supir->no_polisi }}</td>
                            <td>{{ $supir->merk_truk ?? '-' }}</td>
                            <td>{{ $supir->tahun_truk ?? '-' }}</td>
                            <td>{{ $supir->no_hp ?? '-' }}</td>
                            <td class="text-left">{{ $supir->alamat ?? '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ $supir->user->status_aktif ?? 'nonaktif' }}">
                                    {{ $supir->user->status_aktif ?? 'nonaktif' }}
                                </span>
                            </td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.supir.edit', $supir->supir_id) }}"
                                    class="icon-btn icon-btn-edit"
                                    title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 3.487a2.25 2.25 0 1 1 3.182 3.182L7.5 19.213 3 20.25l1.037-4.5L16.862 3.487Z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.supir.toggle-status', $supir->supir_id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin mengubah status akun supir ini?')"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="icon-btn {{ ($supir->user->status_aktif ?? 'nonaktif') === 'aktif' ? 'icon-btn-toggle-inactive' : 'icon-btn-toggle-active' }}"
                                                title="{{ ($supir->user->status_aktif ?? 'nonaktif') === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            @if(($supir->user->status_aktif ?? 'nonaktif') === 'aktif')
                                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18.364 5.636 5.636 18.364M5.636 5.636l12.728 12.728" />
                                                </svg>
                                            @else
                                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.supir.destroy', $supir->supir_id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data supir ini?')"
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
                            <td colspan="11" class="empty-state">Belum ada data supir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            {{ $supirs->links() }}
        </div>
    </div>
@endsection
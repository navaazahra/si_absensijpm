@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        .verifikasi-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            margin-top: 20px;
        }

        .verifikasi-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .verifikasi-head h2 {
            margin: 0 0 6px;
            font-size: 22px;
        }

        .verifikasi-head p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.7;
        }

        .filter-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-form select {
            min-width: 180px;
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

        .table-wrap {
            overflow-x: auto;
        }

        .verifikasi-table {
            width: 100%;
            min-width: 1400px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .verifikasi-table thead th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .verifikasi-table tbody td {
            padding: 14px 16px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #111827;
            line-height: 1.6;
        }

        .verifikasi-table tbody tr:hover {
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

        .thumb-photo {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            display: block;
        }

        .btn-mini {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-map {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .btn-setujui {
            background: #16a34a;
            color: white;
        }

        .btn-tolak {
            background: #dc2626;
            color: white;
        }

        .aksi-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
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

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 9999;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: white;
            width: 100%;
            max-width: 760px;
            border-radius: 20px;
            box-shadow: 0 18px 50px rgba(0,0,0,0.18);
            overflow: hidden;
        }

        .modal-head {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .modal-head h3 {
            margin: 0;
            font-size: 20px;
        }

        .modal-close {
            background: #f3f4f6;
            border: none;
            border-radius: 10px;
            padding: 8px 12px;
            cursor: pointer;
            font-weight: 700;
        }

        .modal-body {
            padding: 20px;
        }

        #mapModalCanvas {
            width: 100%;
            height: 380px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }

        .photo-modal-img {
            width: 100%;
            max-height: 70vh;
            object-fit: contain;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
        }

        .tolak-form textarea {
            width: 100%;
            min-height: 140px;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 12px;
            padding: 13px 14px;
            font-size: 15px;
            outline: none;
            resize: vertical;
        }

        .tolak-form textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.10);
        }

        .tolak-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 16px;
        }
    </style>

    <div class="card">
        <span class="badge">Hak Akses: Admin</span>
        <h1 class="page-title">Verifikasi Absensi</h1>
        <p class="text-muted">
            Periksa lokasi, foto selfie, keterangan, dan validasi absensi supir dalam satu halaman.
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

    <div class="verifikasi-card">
        <div class="verifikasi-head">
            <div>
                <h2>Daftar Absensi</h2>
                <p>Filter data absensi berdasarkan status untuk memudahkan proses verifikasi.</p>
            </div>

            <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="filter-form">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="normal" {{ request('status') === 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="perlu_konfirmasi" {{ request('status') === 'perlu_konfirmasi' ? 'selected' : '' }}>Perlu Konfirmasi</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <button type="submit" class="btn-primary-soft">Filter</button>
                <a href="{{ route('admin.verifikasi.index') }}" class="btn-neutral-soft">Reset</a>
            </form>
        </div>

        @if($absensis->count())
            <div class="table-wrap">
                <table class="verifikasi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu Absensi</th>
                            <th>Supir</th>
                            <th>ID Jadwal</th>
                            <th>Rute</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                            <th>Map</th>
                            <th>Validator</th>
                            <th>Waktu Validasi</th>
                            <th>Alasan Penolakan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absensis as $index => $absensi)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $absensi->waktu_absensi?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                </td>

                                <td>
                                    {{ $absensi->supir->nama_supir ?? '-' }}
                                </td>

                                <td>{{ $absensi->jadwal_id }}</td>

                                <td>
                                    {{ $absensi->jadwal->kota_asal ?? '-' }} → {{ $absensi->jadwal->kota_tujuan ?? '-' }}
                                </td>

                                <td>
                                    <span class="status-badge status-{{ $absensi->status_absensi }}">
                                        {{ str_replace('_', ' ', $absensi->status_absensi) }}
                                    </span>
                                </td>

                                <td style="max-width: 240px;">
                                    {{ $absensi->alasan ?: '-' }}
                                </td>

                                <td>
                                    @if($absensi->foto)
                                        <img
                                            src="{{ asset('storage/' . $absensi->foto) }}"
                                            alt="Foto Absensi"
                                            class="thumb-photo photo-trigger"
                                            data-photo="{{ asset('storage/' . $absensi->foto) }}"
                                        >
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn-mini btn-map map-trigger"
                                        data-lat="{{ $absensi->latitude }}"
                                        data-lng="{{ $absensi->longitude }}"
                                        data-title="{{ ($absensi->jadwal->kota_asal ?? '-') . ' → ' . ($absensi->jadwal->kota_tujuan ?? '-') }}"
                                    >
                                        Lihat Map
                                    </button>
                                </td>

                                <td>
                                    {{ $absensi->validator->nama_admin ?? '-' }}
                                </td>

                                <td>
                                    {{ $absensi->waktu_validasi ? $absensi->waktu_validasi->timezone('Asia/Jakarta')->format('d M Y H:i') . ' WIB' : '-' }}
                                </td>

                                <td style="max-width: 240px;">
                                    {{ $absensi->alasan_penolakan ?: '-' }}
                                </td>

                                <td>
                                    @if(!in_array($absensi->status_absensi, ['disetujui', 'ditolak']))
                                        <div class="aksi-group">
                                            <form action="{{ route('admin.verifikasi.setujui', $absensi->absensi_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui absensi ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-mini btn-setujui">Setujui</button>
                                            </form>

                                            <button
                                                type="button"
                                                class="btn-mini btn-tolak tolak-trigger"
                                                data-absensi-id="{{ $absensi->absensi_id }}"
                                                data-mode="tolak"
                                            >
                                                Tolak
                                            </button>
                                        </div>
                                    @elseif($absensi->status_absensi === 'disetujui')
                                        <div class="aksi-group">
                                            <span class="status-badge status-disetujui">Sudah Disetujui</span>

                                            <button
                                                type="button"
                                                class="btn-mini btn-tolak tolak-trigger"
                                                data-absensi-id="{{ $absensi->absensi_id }}"
                                                data-mode="ubah-ke-ditolak"
                                                data-alasan="{{ $absensi->alasan_penolakan }}"
                                            >
                                                Ubah ke Ditolak
                                            </button>
                                        </div>
                                    @elseif($absensi->status_absensi === 'ditolak')
                                        <div class="aksi-group">
                                            <span class="status-badge status-ditolak">Sudah Ditolak</span>

                                            <form action="{{ route('admin.verifikasi.ubah-ke-disetujui', $absensi->absensi_id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengubah keputusan menjadi disetujui?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-mini btn-setujui">Ubah ke Disetujui</button>
                                            </form>

                                            <button
                                                type="button"
                                                class="btn-mini btn-tolak tolak-trigger"
                                                data-absensi-id="{{ $absensi->absensi_id }}"
                                                data-mode="ubah-ke-ditolak"
                                                data-alasan="{{ $absensi->alasan_penolakan }}"
                                            >
                                                Edit Penolakan
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <h3>Belum ada data absensi</h3>
                <p>Tidak ada absensi yang sesuai dengan filter saat ini.</p>
            </div>
        @endif
    </div>

    {{-- MODAL MAP --}}
    <div class="modal-overlay" id="mapModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Lokasi Absensi</h3>
                <button type="button" class="modal-close" onclick="closeMapModal()">Tutup</button>
            </div>
            <div class="modal-body">
                <div id="mapModalCanvas"></div>
            </div>
        </div>
    </div>

    {{-- MODAL FOTO --}}
    <div class="modal-overlay" id="photoModal">
        <div class="modal-box" style="max-width: 820px;">
            <div class="modal-head">
                <h3>Foto Selfie Absensi</h3>
                <button type="button" class="modal-close" onclick="closePhotoModal()">Tutup</button>
            </div>
            <div class="modal-body">
                <img src="" id="photoModalImage" class="photo-modal-img" alt="Foto Absensi">
            </div>
        </div>
    </div>

    {{-- MODAL TOLAK --}}
    <div class="modal-overlay" id="tolakModal">
        <div class="modal-box" style="max-width: 720px;">
            <div class="modal-head">
                <h3 id="tolakModalTitle">Alasan Penolakan</h3>
                <button type="button" class="modal-close" onclick="closeTolakModal()">Tutup</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="tolakForm" class="tolak-form">
                    @csrf
                    @method('PATCH')

                    <label for="alasan_penolakan" style="display:block; margin-bottom:8px; font-weight:700; font-size:14px;">
                        Isi alasan penolakan
                    </label>
                    <textarea name="alasan_penolakan" id="alasan_penolakan" placeholder="Masukkan alasan mengapa absensi ditolak..." required></textarea>

                    <div class="tolak-actions">
                        <button type="submit" class="btn-primary-soft">Simpan Penolakan</button>
                        <button type="button" class="btn-neutral-soft" onclick="closeTolakModal()">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let mapModalInstance = null;
        let mapModalMarker = null;

        function openMapModal(lat, lng, title) {
            const modal = document.getElementById('mapModal');
            modal.classList.add('active');

            setTimeout(() => {
                if (!mapModalInstance) {
                    mapModalInstance = L.map('mapModalCanvas').setView([lat, lng], 16);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(mapModalInstance);

                    mapModalMarker = L.marker([lat, lng]).addTo(mapModalInstance)
                        .bindPopup(title)
                        .openPopup();
                } else {
                    mapModalInstance.setView([lat, lng], 16);

                    if (mapModalMarker) {
                        mapModalMarker.setLatLng([lat, lng]).bindPopup(title).openPopup();
                    } else {
                        mapModalMarker = L.marker([lat, lng]).addTo(mapModalInstance)
                            .bindPopup(title)
                            .openPopup();
                    }

                    mapModalInstance.invalidateSize();
                }
            }, 150);
        }

        function closeMapModal() {
            document.getElementById('mapModal').classList.remove('active');
        }

        function openPhotoModal(src) {
            document.getElementById('photoModalImage').src = src;
            document.getElementById('photoModal').classList.add('active');
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.remove('active');
            document.getElementById('photoModalImage').src = '';
        }

        function openTolakModal(absensiId, mode, alasan) {
            const form = document.getElementById('tolakForm');
            const title = document.getElementById('tolakModalTitle');
            const textarea = document.getElementById('alasan_penolakan');
            const modal = document.getElementById('tolakModal');

            textarea.value = alasan || '';

            if (mode === 'ubah-ke-ditolak') {
                title.textContent = 'Ubah / Edit Penolakan';
                form.action = '/admin/verifikasi-absensi/' + absensiId + '/ubah-ke-ditolak';
            } else {
                title.textContent = 'Alasan Penolakan';
                form.action = '/admin/verifikasi-absensi/' + absensiId + '/tolak';
            }

            document.getElementById('tolakModal').classList.add('active');
        }

        function closeTolakModal() {
            document.getElementById('tolakModal').classList.remove('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.photo-trigger').forEach(function (el) {
                el.addEventListener('click', function () {
                    openPhotoModal(this.dataset.photo);
                });
            });

            document.querySelectorAll('.map-trigger').forEach(function (el) {
                el.addEventListener('click', function () {
                    const lat = parseFloat(this.dataset.lat);
                    const lng = parseFloat(this.dataset.lng);
                    const title = this.dataset.title || 'Lokasi Absensi';

                    openMapModal(lat, lng, title);
                });
            });

            document.querySelectorAll('.tolak-trigger').forEach(function (el) {
                el.addEventListener('click', function () {
                    const absensiId = this.getAttribute('data-absensi-id');
                    const mode = this.getAttribute('data-mode') || 'tolak';
                    const alasan = this.getAttribute('data-alasan') || '';

                    openTolakModal(absensiId, mode, alasan);
                });
            });
        });

        window.addEventListener('click', function(event) {
            ['mapModal', 'photoModal', 'tolakModal'].forEach(function(id) {
                const modal = document.getElementById(id);
                if (event.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>
@endsection
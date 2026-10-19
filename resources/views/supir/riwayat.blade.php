@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        .riwayat-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            margin-top: 20px;
        }

        .riwayat-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .riwayat-head h2 {
            margin: 0 0 6px;
            font-size: 22px;
        }

        .riwayat-head p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.7;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .riwayat-table {
            width: 100%;
            min-width: 1150px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .riwayat-table thead th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .riwayat-table tbody td {
            padding: 14px 16px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #111827;
            line-height: 1.6;
        }

        .riwayat-table tbody tr:hover {
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

        .validasi-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .validasi-sudah {
            background: #dcfce7;
            color: #166534;
        }

        .validasi-belum {
            background: #f3f4f6;
            color: #374151;
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

        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .btn-disabled {
            background: #e5e7eb;
            color: #6b7280;
            cursor: not-allowed;
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

        .edit-form textarea {
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

        .edit-form textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.10);
        }

        .edit-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 16px;
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
            cursor: pointer;
            text-decoration: none;
        }
    </style>

    <div class="card">
        <span class="badge">Hak Akses: Supir</span>
        <h1 class="page-title">Riwayat Absensi</h1>
        <p class="text-muted">
            Lihat semua absensi Anda, status validasinya, lokasi pada peta, dan ubah keterangan sebelum divalidasi admin.
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

    @if($absensis->count())
        <div class="riwayat-card">
            <div class="riwayat-head">
                <div>
                    <h2>Data Riwayat Absensi</h2>
                    <p>Tabel riwayat dibuat ringkas agar tetap nyaman saat data absensi sudah banyak.</p>
                </div>
            </div>

            <div class="table-wrap">
                <table class="riwayat-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu Absensi</th>
                            <th>ID Jadwal</th>
                            <th>Progres</th>
                            <th>Rute</th>
                            <th>Status Absensi</th>
                            <th>Status Validasi</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                            <th>Map</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absensis as $index => $absensi)
                            @php
                                $sudahValidasi = !is_null($absensi->waktu_validasi) || in_array($absensi->status_absensi, ['disetujui', 'ditolak']);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $absensi->waktu_absensi?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                </td>

                                <td>{{ $absensi->jadwal_id }}</td>
                                
                                <td>
                                    <span style="display:inline-block; padding:6px 10px; border-radius:999px; background:#eff6ff; color:#1d4ed8; font-size:12px; font-weight:700;">
                                        {{ $absensi->absensi_ke }}/{{ $absensi->target_absensi }}
                                    </span>
                                </td>
                                
                                <td>
                                    {{ $absensi->jadwal->kota_asal ?? '-' }} → {{ $absensi->jadwal->kota_tujuan ?? '-' }}
                                </td>

                                <td>
                                    <span class="status-badge status-{{ $absensi->status_absensi }}">
                                        {{ str_replace('_', ' ', $absensi->status_absensi) }}
                                    </span>
                                </td>

                                <td>
                                    @if($sudahValidasi)
                                        <span class="validasi-badge validasi-sudah">Sudah divalidasi</span>
                                    @else
                                        <span class="validasi-badge validasi-belum">Belum divalidasi</span>
                                    @endif
                                </td>

                                <td style="max-width: 260px;">
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
                                    @if(!$sudahValidasi)
                                        <button
                                            type="button"
                                            class="btn-mini btn-edit edit-trigger"
                                            data-absensi-id="{{ $absensi->absensi_id }}"
                                            data-alasan="{{ $absensi->alasan }}"
                                        >
                                            Edit Alasan
                                        </button>
                                    @else
                                        <button type="button" class="btn-mini btn-disabled" disabled>
                                            Terkunci
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state">
            <h3>Belum ada riwayat absensi</h3>
            <p>Anda belum pernah mengirim absensi ke sistem.</p>
        </div>
    @endif

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

    {{-- MODAL EDIT ALASAN --}}
    <div class="modal-overlay" id="editModal">
        <div class="modal-box" style="max-width: 720px;">
            <div class="modal-head">
                <h3>Edit Keterangan / Alasan</h3>
                <button type="button" class="modal-close" onclick="closeEditModal()">Tutup</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editAlasanForm" class="edit-form">
                    @csrf
                    @method('PATCH')

                    <label for="edit_alasan" style="display:block; margin-bottom:8px; font-weight:700; font-size:14px;">
                        Keterangan / Alasan
                    </label>
                    <textarea name="alasan" id="edit_alasan" placeholder="Isi atau perbarui keterangan absensi..."></textarea>

                    <div class="edit-actions">
                        <button type="submit" class="btn-primary-soft">Simpan Perubahan</button>
                        <button type="button" class="btn-neutral-soft" onclick="closeEditModal()">Batal</button>
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

        function openEditModal(absensiId, alasan) {
            const form = document.getElementById('editAlasanForm');
            const textarea = document.getElementById('edit_alasan');

            form.action = '/supir/riwayat/' + absensiId;
            textarea.value = alasan ?? '';

            document.getElementById('editModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
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

            document.querySelectorAll('.edit-trigger').forEach(function (el) {
                el.addEventListener('click', function () {
                    openEditModal(this.dataset.absensiId, this.dataset.alasan);
                });
            });
        });

        window.addEventListener('click', function(event) {
            ['mapModal', 'photoModal', 'editModal'].forEach(function(id) {
                const modal = document.getElementById(id);
                if (event.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>
@endsection
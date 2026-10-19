@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        .absen-shell {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .absen-card {
            background: white;
            border-radius: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            overflow: hidden;
        }

        .absen-head {
            padding: 22px 22px 0;
        }

        .absen-head h2 {
            margin: 8px 0 6px;
            font-size: 24px;
        }

        .absen-head p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
            font-size: 14px;
        }

        .absen-body {
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
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            line-height: 1.6;
        }

        .notice-box {
            margin-top: 18px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            border-radius: 16px;
            padding: 14px 16px;
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

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
            margin-top: 18px;
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

        .field-box textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 12px;
            padding: 13px 14px;
            font-size: 15px;
            outline: none;
            resize: vertical;
        }

        .field-box textarea:focus {
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
            cursor: pointer;
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

        .camera-wrap {
            display: grid;
            gap: 12px;
        }

        .camera-video,
        .camera-preview {
            width: 100%;
            max-width: 380px;
            border-radius: 16px;
            border: 1px solid #dbe3ef;
            background: #0f172a;
            display: block;
        }

        .camera-preview {
            display: none;
            background: #f8fafc;
        }

        .camera-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .empty-state {
            background: white;
            border-radius: 20px;
            padding: 28px 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.07);
            border: 1px solid #edf2f7;
            text-align: center;
        }

        .empty-state h3 {
            margin: 0 0 8px;
        }

        .empty-state p {
            margin: 0;
            color: #6b7280;
            line-height: 1.7;
        }

        #map {
            height: 320px;
            width: 100%;
            border-radius: 16px;
            margin-top: 12px;
            display: none;
            border: 1px solid #dbe3ef;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    <div class="card">
        <span class="badge">Supir</span>
        <h1 class="page-title">Absen Sekarang</h1>
        <p class="text-muted">
            Ambil lokasi dan selfie langsung dari kamera perangkat untuk melakukan absensi.
        </p>
    </div>

    @if($errors->any())
        <div class="error-box">
            <strong style="display:block; margin-bottom:8px;">Terdapat kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$jadwalAktif)
        <div class="empty-state" style="margin-top: 20px;">
            <h3>Tidak ada jadwal aktif</h3>
            <p>Saat ini Anda tidak memiliki jadwal aktif untuk absensi.</p>

            <div style="margin-top: 16px;">
                <a href="{{ route('supir.jadwal') }}" class="btn-neutral-soft">Lihat Jadwal Saya</a>
            </div>
        </div>
    @else
        <div class="absen-shell">
            <div class="absen-card">
                <div class="absen-head">
                    <h2>Informasi Jadwal Aktif</h2>
                    <p>Periksa detail jadwal berikut sebelum mengirim absensi.</p>
                </div>

                <div class="absen-body">
                    <div class="info-grid">
                        <div class="info-box">
                            <span class="info-label">ID Jadwal</span>
                            <div class="info-value">{{ $jadwalAktif->jadwal_id }}</div>
                        </div>

                        <div class="info-box">
                            <span class="info-label">Supir</span>
                            <div class="info-value">{{ $supir->nama_supir ?? '-' }}</div>
                        </div>

                        <div class="info-box">
                            <span class="info-label">Rute</span>
                            <div class="info-value">{{ $jadwalAktif->kota_asal }} → {{ $jadwalAktif->kota_tujuan }}</div>
                        </div>

                        <div class="info-box">
                            <span class="info-label">Periode Jadwal</span>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($jadwalAktif->tanggal_mulai)->format('d M Y') }}
                                s/d
                                {{ \Carbon\Carbon::parse($jadwalAktif->tanggal_selesai)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="info-box">
                            <span class="info-label">Progres Absensi</span>
                            <div class="info-value">{{ $totalAbsensiPadaJadwal }}/5 kali</div>
                        </div>

                        <div class="info-box">
                            <span class="info-label">Minimal Kehadiran</span>
                            <div class="info-value">3 kali</div>
                        </div>
                    </div>

                    <div class="notice-box">
                        Aturan sistem:
                        <br>• Absensi hanya boleh <strong>1 kali per hari</strong>
                        <br>• Target absensi per jadwal maksimal <strong>5 kali</strong>
                        <br>• Minimal absensi yang dianggap memenuhi adalah <strong>3 kali</strong>
                        <br>• Status absensi ditentukan otomatis oleh sistem
                        <br>• Alasan wajib diisi jika absensi masuk status <strong>perlu konfirmasi</strong>
                    </div>

                    <form action="{{ route('supir.absen.store') }}" method="POST" onsubmit="return validateAbsenForm()">
                        @csrf

                        <input type="hidden" name="jadwal_id" value="{{ $jadwalAktif->jadwal_id }}">
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                        <input type="hidden" name="foto_base64" id="foto_base64">

                        <div class="form-grid">
                            <div class="field-box">
                                <label>Lokasi</label>
                                <div class="camera-actions">
                                    <button type="button" class="btn-soft" onclick="ambilLokasi()">Ambil Lokasi</button>
                                </div>
                                <small class="field-help" id="lokasiText">Lokasi belum diambil.</small>

                                <div id="map"></div>
                            </div>

                            <div class="field-box">
                                <label>Selfie Kamera</label>
                                <div class="camera-wrap">
                                    <video id="video" class="camera-video" autoplay playsinline></video>
                                    <canvas id="canvas" style="display:none;"></canvas>
                                    <img id="preview" class="camera-preview" alt="Preview Selfie">

                                    <div class="camera-actions">
                                        <button type="button" class="btn-soft" onclick="startCamera()">Aktifkan Kamera</button>
                                        <button type="button" class="btn-soft" onclick="takePhoto()">Ambil Selfie</button>
                                    </div>
                                </div>
                                <small class="field-help">
                                    Kamera depan digunakan untuk selfie langsung dari browser. Tidak ada opsi unggah dari galeri di form ini.
                                </small>
                            </div>

                            <div class="field-box">
                                <label for="alasan">Alasan / Keterangan</label>
                                <textarea
                                    name="alasan"
                                    id="alasan"
                                    rows="4"
                                    placeholder="Isi keterangan absensi. Wajib jika absensi di luar jadwal."
                                >{{ old('alasan') }}</textarea>
                                <small class="field-help">
                                    Keterangan tetap tersedia untuk status normal maupun perlu konfirmasi.
                                </small>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-soft">Kirim Absensi</button>
                            <a href="{{ route('supir.jadwal') }}" class="btn-neutral-soft">Kembali ke Jadwal Saya</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let stream = null;
            let map = null;
            let marker = null;

            async function startCamera() {
                const video = document.getElementById('video');

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user' },
                        audio: false
                    });

                    video.srcObject = stream;
                } catch (error) {
                    alert('Gagal mengakses kamera. Pastikan izin kamera diaktifkan.');
                }
            }

            function takePhoto() {
                const video = document.getElementById('video');
                const canvas = document.getElementById('canvas');
                const preview = document.getElementById('preview');
                const fotoBase64 = document.getElementById('foto_base64');

                if (!video.srcObject) {
                    alert('Aktifkan kamera terlebih dahulu.');
                    return;
                }

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = canvas.toDataURL('image/jpeg', 0.9);

                fotoBase64.value = imageData;
                preview.src = imageData;
                preview.style.display = 'block';
            }

            function ambilLokasi() {
                const lokasiText = document.getElementById('lokasiText');
                const latitude = document.getElementById('latitude');
                const longitude = document.getElementById('longitude');
                const mapElement = document.getElementById('map');

                if (!navigator.geolocation) {
                    lokasiText.textContent = 'Browser tidak mendukung geolocation.';
                    return;
                }

                lokasiText.textContent = 'Mengambil lokasi...';

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        latitude.value = lat;
                        longitude.value = lng;

                        lokasiText.textContent = 'Lokasi berhasil diambil: ' + lat + ', ' + lng;
                        mapElement.style.display = 'block';

                        if (!map) {
                            map = L.map('map').setView([lat, lng], 16);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; OpenStreetMap contributors'
                            }).addTo(map);

                            marker = L.marker([lat, lng]).addTo(map)
                                .bindPopup('Lokasi Anda saat absensi')
                                .openPopup();
                        } else {
                            map.setView([lat, lng], 16);

                            if (marker) {
                                marker.setLatLng([lat, lng])
                                    .bindPopup('Lokasi Anda saat absensi')
                                    .openPopup();
                            } else {
                                marker = L.marker([lat, lng]).addTo(map)
                                    .bindPopup('Lokasi Anda saat absensi')
                                    .openPopup();
                            }
                        }

                        setTimeout(() => {
                            map.invalidateSize();
                        }, 200);
                    },
                    function() {
                        lokasiText.textContent = 'Gagal mengambil lokasi. Pastikan izin lokasi diaktifkan.';
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            }

            function validateAbsenForm() {
                const latitude = document.getElementById('latitude').value;
                const longitude = document.getElementById('longitude').value;
                const fotoBase64 = document.getElementById('foto_base64').value;

                if (!latitude || !longitude) {
                    alert('Silakan ambil lokasi terlebih dahulu.');
                    return false;
                }

                if (!fotoBase64) {
                    alert('Silakan ambil selfie terlebih dahulu.');
                    return false;
                }

                return true;
            }
        </script>
    @endif
@endsection
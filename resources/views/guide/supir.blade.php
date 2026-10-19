@extends('layouts.app')

@section('content')
<style>
    .guide-shell {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .guide-card {
        background: white;
        border-radius: 22px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.07);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .guide-head {
        padding: 22px 22px 0;
    }

    .guide-head h2 {
        margin: 8px 0 6px;
        font-size: 24px;
        color: #111827;
    }

    .guide-head p {
        margin: 0;
        color: #6b7280;
        line-height: 1.7;
        font-size: 14px;
    }

    .guide-body {
        padding: 22px;
    }

    .step-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        margin-top: 14px;
    }

    .step-card {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 16px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .step-number {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 12px;
        background: linear-gradient(135deg, #60a5fa, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(37,99,235,0.18);
    }

    .step-content h3 {
        margin: 0 0 6px;
        font-size: 16px;
        color: #111827;
    }

    .step-content p {
        margin: 0;
        color: #6b7280;
        line-height: 1.7;
        font-size: 14px;
    }

    .info-box {
        margin-top: 16px;
        border-radius: 16px;
        padding: 14px 16px;
        font-size: 14px;
        line-height: 1.8;
    }

    .info-blue {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .info-yellow {
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .guide-list {
        margin: 14px 0 0;
        padding-left: 18px;
        color: #374151;
        line-height: 1.9;
    }

    .guide-list li + li {
        margin-top: 4px;
    }

    .accordion {
        margin-top: 14px;
        display: grid;
        gap: 12px;
    }

    .accordion-item {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
    }

    .accordion-button {
        width: 100%;
        border: none;
        background: #f8fafc;
        padding: 16px 18px;
        font-weight: 700;
        font-size: 14px;
        text-align: left;
        color: #111827;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-button:hover {
        background: #f1f5f9;
    }

    .accordion-icon {
        transition: transform 0.2s ease;
        color: #6b7280;
    }

    .accordion-item.active .accordion-icon {
        transform: rotate(180deg);
    }

    .accordion-content {
        display: none;
        padding: 16px 18px;
        color: #6b7280;
        line-height: 1.8;
        font-size: 14px;
        border-top: 1px solid #e5e7eb;
    }

    .accordion-item.active .accordion-content {
        display: block;
    }

    .guide-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .btn-neutral-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 13px 18px;
        font-weight: 700;
        text-decoration: none;
    }
</style>

<div class="card">
    <span class="badge">Panduan Supir</span>
    <h1 class="page-title">Panduan Penggunaan Supir</h1>
    <p class="text-muted">
        Panduan lengkap untuk memahami menu, alur absensi, dan ketentuan penggunaan sistem.
    </p>
</div>
<br>
<div class="guide-shell">

    <div class="guide-card">
        <div class="guide-head">
            <h2>Gambaran Sistem</h2>
        </div>
        <div class="guide-body">
            <p>
                Supir menggunakan sistem untuk melihat jadwal, melakukan absensi harian,
                dan memantau riwayat absensi beserta status validasinya.
            </p>

            <div class="info-box info-blue">
                Data absensi yang dikirim supir akan diperiksa dan diverifikasi oleh admin sebelum masuk ke laporan.
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Alur Penggunaan Supir</h2>
        </div>
        <div class="guide-body">
            <div class="step-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Lihat Jadwal</h3>
                        <p>Periksa jadwal yang telah dibuat admin melalui menu <strong>Jadwal Saya</strong>.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Lakukan Absensi</h3>
                        <p>Buka menu <strong>Absen Sekarang</strong>, aktifkan GPS, lalu ambil foto selfie sebelum mengirim absensi.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Cek Riwayat</h3>
                        <p>Lihat riwayat absensi dan progres per jadwal pada menu <strong>Riwayat Absensi</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Detail Menu Supir</h2>
        </div>

        <div class="guide-body">
            <div class="accordion">

                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Jadwal Saya
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Menampilkan daftar jadwal yang sudah dibuat admin.</li>
                            <li>Setiap jadwal memiliki periode mulai dan selesai.</li>
                            <li>Status jadwal akan menyesuaikan kondisi tanggal berjalan.</li>
                        </ul>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Absen Sekarang
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Absensi dilakukan dengan lokasi real-time (GPS).</li>
                            <li>Foto selfie wajib diambil langsung saat absensi.</li>
                            <li>Sistem hanya mengizinkan absensi <strong>1 kali per hari</strong>.</li>
                            <li>Maksimal absensi untuk 1 jadwal adalah <strong>5 kali</strong>.</li>
                        </ul>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Riwayat Absensi
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Menampilkan absensi yang pernah dikirim.</li>
                            <li>Status absensi dapat berupa normal, perlu konfirmasi, disetujui, atau ditolak.</li>
                            <li>Progress ditampilkan berdasarkan masing-masing jadwal, misalnya 1/5, 2/5, dan seterusnya.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Kondisi Khusus</h2>
        </div>
        <div class="guide-body">
            <ul class="guide-list">
                <li>Jika absensi dilakukan di luar rentang jadwal, sistem akan memberi status <strong>Perlu Konfirmasi</strong>.</li>
                <li>Jika jadwal sudah selesai tetapi total absensi belum mencapai 5 kali, supir masih bisa absen.</li>
                <li>Dalam kondisi di luar jadwal, <strong>keterangan/alasan wajib diisi</strong>.</li>
                <li>Jika lupa password atau data profil salah, silakan hubungi admin.</li>
            </ul>

            <div class="info-box info-yellow">
                Supir tidak dapat mengubah password atau data profil sendiri melalui sistem. Perubahan dilakukan oleh admin.
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Tips Penggunaan</h2>
        </div>
        <div class="guide-body">
            <ul class="guide-list">
                <li>Pastikan kamera dan GPS aktif sebelum membuka menu absen.</li>
                <li>Periksa jadwal terlebih dahulu agar absensi sesuai periode.</li>
                <li>Isi alasan dengan jelas jika absensi dilakukan di luar jadwal.</li>
            </ul>

            <div class="guide-actions">
                <a href="{{ route('supir.dashboard') }}" class="btn-neutral-soft">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleAccordion(button) {
        const item = button.closest('.accordion-item');
        item.classList.toggle('active');
    }
</script>
@endsection
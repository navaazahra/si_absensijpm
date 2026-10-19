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

    .btn-primary-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        border-radius: 14px;
        padding: 13px 18px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 20px rgba(37,99,235,0.18);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .btn-primary-soft:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(37,99,235,0.22);
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

    @media (min-width: 768px) {
        .step-grid.two-col {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div class="card">
    <span class="badge">Panduan Admin</span>
    <h1 class="page-title">Panduan Sistem Admin</h1>
    <p class="text-muted">
        Panduan lengkap untuk mengelola sistem absensi, jadwal, dan laporan operasional.
    </p>
</div>
<br>
<div class="guide-shell">

    <!-- 🔹 OVERVIEW -->
    <div class="guide-card">
        <div class="guide-head">
            <h2>Gambaran Sistem</h2>
        </div>
        <div class="guide-body">
            <p>
                Admin bertanggung jawab dalam mengelola seluruh aktivitas sistem mulai dari
                data supir, jadwal, validasi absensi, hingga pembuatan laporan akhir.
            </p>

            <div class="info-box info-blue">
                Semua data yang dikelola admin akan menjadi dasar laporan final yang dilihat oleh petinggi.
            </div>
        </div>
    </div>

    <!-- 🔹 FLOW -->
    <div class="guide-card">
        <div class="guide-head">
            <h2>Alur Kerja Admin</h2>
        </div>
        <div class="guide-body">
            <div class="step-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Kelola Supir</h3>
                        <p>Menambah atau mengatur akun supir yang akan digunakan dalam sistem.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Buat Jadwal</h3>
                        <p>Menyusun jadwal absensi untuk setiap supir.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Verifikasi Absensi</h3>
                        <p>Memeriksa dan menyetujui atau menolak absensi yang masuk.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Reset Password</h3>
                        <p>Mengatur ulang kata sandi untuk akun supir.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Buat Laporan</h3>
                        <p>Menghasilkan laporan dan mengunggah dokumen final.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 DETAIL MENU -->
    <div class="guide-card">
        <div class="guide-head">
            <h2>Detail Menu Admin</h2>
        </div>

        <div class="guide-body">
            <div class="accordion">

                <!-- SUPIR -->
                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Kelola Supir
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Tambah supir baru</li>
                            <li>Edit data supir (nama, no HP, kendaraan)</li>
                            <li>Nonaktifkan akun supir</li>
                            <li>Reset password supir</li>
                        </ul>
                    </div>
                </div>

                <!-- JADWAL -->
                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Jadwal
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Membuat jadwal baru untuk supir</li>
                            <li>Menentukan periode mulai dan selesai</li>
                            <li>Menghindari jadwal bentrok</li>
                        </ul>
                    </div>
                </div>

                <!-- ABSENSI -->
                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Verifikasi Absensi
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Melihat daftar absensi</li>
                            <li>Melihat foto dan lokasi</li>
                            <li>Menyetujui absensi</li>
                            <li>Menolak absensi</li>
                        </ul>
                    </div>
                </div>

                <!-- RESET PASSWORD -->
                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Reset Password User
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Memilih user yang akan direset passwordnya</li>
                            <li>Konfirmasi reset password</li>
                            <li>Password default setelah reset adalah "password123"</li>
                        </ul>
                    </div>
                </div>

                <!-- LAPORAN -->
                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Laporan Absensi
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Filter berdasarkan tanggal</li>
                            <li>Generate laporan</li>
                            <li>Export ke Excel</li>
                            <li>Upload scan laporan final</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 🔹 EDGE CASE -->
    <div class="guide-card">
        <div class="guide-head">
            <h2>Kondisi Khusus (Edge Case)</h2>
        </div>

        <div class="guide-body">
            <ul class="guide-list">
                <li>Supir tetap bisa absen walau jadwal selesai jika belum 5 kali</li>
                <li>Absensi di luar jadwal akan masuk "Perlu Konfirmasi"</li>
                <li>Progress absensi dihitung per jadwal (bukan global)</li>
                <li>Absensi hanya dihitung jika status disetujui</li>
                <li>Jadwal tidak boleh overlap untuk supir yang sama</li>
            </ul>

            <div class="info-box info-yellow">
                Kesalahan verifikasi akan mempengaruhi laporan akhir, pastikan pengecekan dilakukan dengan teliti.
            </div>
        </div>
    </div>

    <!-- 🔹 TIPS -->
    <div class="guide-card">
        <div class="guide-head">
            <h2>Tips Penggunaan</h2>
        </div>

        <div class="guide-body">
            <ul class="guide-list">
                <li>Lakukan verifikasi absensi setiap hari</li>
                <li>Gunakan filter laporan untuk mempermudah analisis</li>
                <li>Pastikan semua absensi sudah diverifikasi sebelum membuat laporan</li>
                <li>Simpan file laporan dengan nama yang jelas</li>
            </ul>

            <div class="guide-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-neutral-soft">Kembali ke Dashboard</a>
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
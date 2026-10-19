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

    .role-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        margin-top: 14px;
    }

    .role-card {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 18px;
    }

    .role-card h3 {
        margin: 0 0 8px;
        font-size: 18px;
        color: #111827;
    }

    .role-card p {
        margin: 0;
        color: #6b7280;
        line-height: 1.8;
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
        .role-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>

<div class="card">
    <span class="badge">Panduan Umum</span>
    <h1 class="page-title">Panduan Sistem Absensi Supir</h1>
    <p class="text-muted">
        Pelajari cara kerja sistem, jenis pengguna, dan langkah awal sebelum menggunakan aplikasi.
    </p>
</div>
<br>
<div class="guide-shell">

    <div class="guide-card">
        <div class="guide-head">
            <h2>Tentang Sistem</h2>
        </div>
        <div class="guide-body">
            <p>
                Sistem Informasi Absensi Supir PT Djanjikita Putra Mandiri digunakan untuk membantu proses
                absensi, verifikasi, dan pelaporan operasional supir secara lebih terstruktur dan terdokumentasi.
            </p>

            <div class="info-box info-blue">
                Sistem ini menghubungkan proses kerja antara <strong>supir</strong>, <strong>admin</strong>, dan <strong>petinggi</strong>.
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Jenis Pengguna</h2>
        </div>
        <div class="guide-body">
            <div class="role-grid">
                <div class="role-card">
                    <h3>Supir</h3>
                    <p>Melihat jadwal, melakukan absensi harian, dan memantau riwayat absensi.</p>
                </div>

                <div class="role-card">
                    <h3>Admin</h3>
                    <p>Mengelola data supir, jadwal, verifikasi absensi, laporan, dan reset password user.</p>
                </div>

                <div class="role-card">
                    <h3>Petinggi</h3>
                    <p>Melihat laporan final dan dokumentasi operasional sebagai bahan monitoring.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Alur Singkat Sistem</h2>
        </div>
        <div class="guide-body">
            <div class="step-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Admin Menyiapkan Data</h3>
                        <p>Admin membuat data supir dan menyusun jadwal absensi sesuai kebutuhan operasional.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Supir Melakukan Absensi</h3>
                        <p>Supir melakukan absensi dengan lokasi GPS dan foto selfie langsung dari sistem.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Admin Melakukan Verifikasi</h3>
                        <p>Admin memeriksa absensi yang masuk lalu menyetujui atau menolak sesuai hasil pemeriksaan.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Laporan Final Dibuat</h3>
                        <p>Admin menyusun dan mengunggah laporan akhir yang siap ditinjau oleh petinggi.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Petinggi Meninjau Data</h3>
                        <p>Petinggi melihat laporan final serta dokumentasi operasional dalam bentuk statistik dan grafik.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Fitur Utama</h2>
        </div>
        <div class="guide-body">
            <ul class="guide-list">
                <li>Absensi supir dengan GPS dan foto selfie.</li>
                <li>Validasi absensi oleh admin.</li>
                <li>Jadwal absensi berdasarkan periode operasional.</li>
                <li>Laporan final dan arsip dokumen.</li>
                <li>Dokumentasi operasional lengkap dengan statistik dan chart.</li>
                <li>Reset password user oleh admin.</li>
            </ul>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Pertanyaan Umum</h2>
        </div>
        <div class="guide-body">
            <div class="accordion">

                <div class="accordion-item">
                    <button type="button" class="accordion-button" onclick="toggleAccordion(this)">
                        Bagaimana cara masuk ke sistem?
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        Gunakan username dan password pada halaman login. Setelah berhasil, sistem akan mengarahkan pengguna ke dashboard sesuai role.
                    </div>
                </div>

                <div class="accordion-item">
                    <button type="button" class="accordion-button" onclick="toggleAccordion(this)">
                        Siapa yang bisa registrasi?
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        Registrasi admin dan petinggi memerlukan kode akses khusus. Supir dikelola langsung oleh admin melalui sistem.
                    </div>
                </div>

                <div class="accordion-item">
                    <button type="button" class="accordion-button" onclick="toggleAccordion(this)">
                        Bagaimana jika lupa password?
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        Silakan hubungi admin atau pengelola sistem untuk bantuan reset password. Reset tidak dilakukan otomatis melalui email atau OTP.
                    </div>
                </div>

            </div>

            <div class="info-box info-yellow">
                Untuk panduan yang lebih rinci, gunakan menu panduan sesuai role setelah login.
            </div>

            <div class="guide-actions">
                <a href="{{ route('home') }}" class="btn-neutral-soft"><< Kembali</a>
                <a href="{{ route('login') }}" class="btn-primary-soft">Login</a>
                <a href="{{ route('admin.register') }}" class="btn-neutral-soft">Registrasi Admin</a>
                <a href="{{ route('petinggi.register') }}" class="btn-neutral-soft">Registrasi Petinggi</a>
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
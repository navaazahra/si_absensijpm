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

    @media (min-width: 768px) {
        .step-grid.two-col {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div class="card">
    <span class="badge">Panduan Petinggi</span>
    <h1 class="page-title">Panduan Penggunaan Petinggi</h1>
    <p class="text-muted">
        Panduan lengkap untuk melihat laporan final dan membaca dokumentasi operasional.
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
                Petinggi menggunakan sistem untuk melihat laporan final yang sudah diunggah admin
                serta memantau dokumentasi operasional dalam bentuk statistik dan grafik.
            </p>

            <div class="info-box info-blue">
                Semua laporan yang tampil di menu petinggi merupakan laporan akhir yang telah disusun admin dan diunggah sebagai dokumen final.
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Alur Penggunaan Petinggi</h2>
        </div>
        <div class="guide-body">
            <div class="step-grid two-col">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Lihat Laporan Final</h3>
                        <p>Masuk ke menu <strong>Laporan Final</strong> untuk melihat daftar laporan yang telah diunggah admin.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Analisis Dokumentasi</h3>
                        <p>Buka menu <strong>Dokumentasi Operasional</strong> untuk melihat statistik absensi dan grafik operasional.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Detail Menu Petinggi</h2>
        </div>

        <div class="guide-body">
            <div class="accordion">

                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Laporan Final
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Menampilkan daftar laporan absensi final.</li>
                            <li>Dapat difilter berdasarkan periode.</li>
                            <li>Setiap laporan bisa dilihat langsung atau diunduh.</li>
                            <li>Laporan yang tampil merupakan hasil unggahan final admin.</li>
                        </ul>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-button" onclick="toggleAccordion(this)">
                        Menu: Dokumentasi Operasional
                        <span class="accordion-icon">⌄</span>
                    </button>
                    <div class="accordion-content">
                        <ul class="guide-list">
                            <li>Menampilkan total absensi pada periode tertentu.</li>
                            <li>Menampilkan distribusi status absensi: normal, perlu konfirmasi, disetujui, dan ditolak.</li>
                            <li>Menampilkan chart untuk mempermudah evaluasi operasional.</li>
                            <li>Menampilkan daftar supir paling aktif berdasarkan absensi yang disetujui.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Interpretasi Data</h2>
        </div>
        <div class="guide-body">
            <ul class="guide-list">
                <li><strong>Total Absensi</strong> menunjukkan jumlah absensi yang tercatat pada periode yang dipilih.</li>
                <li><strong>Normal</strong> menunjukkan absensi yang terjadi sesuai jadwal.</li>
                <li><strong>Perlu Konfirmasi</strong> menunjukkan absensi di luar jadwal yang memerlukan perhatian admin.</li>
                <li><strong>Disetujui</strong> menunjukkan absensi yang telah lolos verifikasi admin.</li>
                <li><strong>Ditolak</strong> menunjukkan absensi yang tidak diterima admin setelah proses verifikasi.</li>
                <li><strong>Supir Paling Aktif</strong> menunjukkan ranking aktivitas berdasarkan absensi berstatus disetujui.</li>
            </ul>

            <div class="info-box info-yellow">
                Data dokumentasi operasional digunakan sebagai bahan monitoring dan evaluasi, sedangkan dokumen resmi tetap mengacu pada laporan final yang diunggah admin.
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-head">
            <h2>Tips Penggunaan</h2>
        </div>
        <div class="guide-body">
            <ul class="guide-list">
                <li>Gunakan filter periode untuk fokus pada bulan atau rentang operasional tertentu.</li>
                <li>Bandingkan laporan final dengan dokumentasi operasional untuk melihat gambaran umum dan detail pendukung.</li>
                <li>Gunakan grafik sebagai bahan evaluasi aktivitas operasional supir.</li>
            </ul>

            <div class="guide-actions">
                <a href="{{ route('petinggi.dashboard') }}" class="btn-neutral-soft">Kembali ke Dashboard</a>
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
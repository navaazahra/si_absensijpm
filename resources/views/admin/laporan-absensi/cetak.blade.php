@php
    \Carbon\Carbon::setLocale('id');

    $tanggalCetak = \Carbon\Carbon::now()->translatedFormat('d F Y');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Absensi</title>
    <style>
        @page {
            margin: 22px;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            color: #000;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
        }

        .no-print {
            margin-bottom: 16px;
        }

        .no-print button {
            padding: 8px 14px;
            border: 1px solid #000;
            background: #fff;
            cursor: pointer;
            font-family: inherit;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px solid #000;
            margin-bottom: 6px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 4px;
        }

        .logo-box {
            width: 95px;
            text-align: center;
        }

        .logo-box img {
            width: 78px;
            height: 78px;
            object-fit: contain;
        }

        .company-box {
            text-align: center;
        }

        .company-box h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .company-box h2 {
            margin: 2px 0 0;
            font-size: 13px;
            font-weight: bold;
        }

        .company-box p {
            margin: 3px 0 0;
            font-size: 12px;
        }

        .top-meta {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            margin-bottom: 18px;
        }

        .top-meta td {
            vertical-align: top;
            padding: 2px 0;
        }

        .tanggal-box {
            text-align: right;
            font-size: 12px;
        }

        .judul {
            text-align: center;
            margin: 12px 0 14px;
        }

        .judul h3 {
            margin: 0;
            font-size: 15px;
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: bold;
        }

        .judul p {
            margin: 5px 0 0;
            font-size: 12px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 12px;
        }

        .section-title {
            margin: 14px 0 8px;
            font-size: 12.5px;
            font-weight: bold;
        }

        .summary-table,
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .summary-table th,
        .summary-table td,
        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 11.5px;
        }

        .summary-table th,
        .main-table th {
            text-align: center;
            font-weight: bold;
            background: #efefef;
        }

        .summary-table td {
            text-align: center;
            vertical-align: middle;
        }

        .main-table td {
            text-align: center;
            vertical-align: middle;
        }

        .main-table td.text-left {
            text-align: left;
        }

        .paragraph {
            text-align: justify;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 28px;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 12px;
        }

        .ttd-space {
            height: 70px;
        }

        .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
        }

        .footer-note {
            margin-top: 18px;
            font-size: 11px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page">
        <div class="no-print">
            <button onclick="window.print()">Print</button>
        </div>

        {{-- KOP SURAT --}}
        <table class="header-table">
            <tr>
                <td class="logo-box">
                    <img src="{{ asset('images/logo_dpm.png') }}" alt="Logo PT">
                </td>
                <td class="company-box">
                    <h1>PT Djanjikita Putra Mandiri</h1>
                    <h2>Laporan Resmi Rekapitulasi Absensi</h2>
                    <p>Jalan Raya Kudus - Colo, Karangdowo, Bae, Kecamatan Bae, Kabupaten Kudus, Jawa Tengah 59327</p>
                </td>
            </tr>
        </table>

        {{-- TANGGAL KANAN ATAS --}}
        <table class="top-meta">
            <tr>
                <td></td>
                <td class="tanggal-box">
                    Kudus, {{ $tanggalCetak }}
                </td>
            </tr>
        </table>

        {{-- JUDUL --}}
        <div class="judul">
            <h3>Laporan Absensi</h3>
            <p>
                Periode {{ \Carbon\Carbon::parse($periodeMulai)->translatedFormat('d F Y') }}
                s/d
                {{ \Carbon\Carbon::parse($periodeSelesai)->translatedFormat('d F Y') }}
            </p>
        </div>

        {{-- KETERANGAN --}}
        <table class="meta-table">
            <tr>
                <td width="160">Dibuat oleh</td>
                <td width="12">:</td>
                <td>{{ $admin->nama_admin ?? '-' }}</td>
            </tr>
            <tr>
                <td>Direktur / Pimpinan</td>
                <td>:</td>
                <td>{{ $direktur->nama_petinggi ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal dibuat</td>
                <td>:</td>
                <td>{{ $tanggalCetak }}</td>
            </tr>
        </table>

        <div class="paragraph">
            Dengan ini disampaikan laporan rekapitulasi absensi untuk periode tersebut di atas. Laporan ini dibuat sebagai dokumen administrasi resmi perusahaan dan dapat digunakan sebagai bahan verifikasi, evaluasi, serta arsip internal perusahaan.
        </div>

        {{-- RINGKASAN --}}
        <div class="section-title">A. Ringkasan Data Absensi</div>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Total Data</th>
                    <th>Normal</th>
                    <th>Perlu Konfirmasi</th>
                    <th>Disetujui</th>
                    <th>Ditolak</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $ringkasan['total'] }}</strong></td>
                    <td>{{ $ringkasan['normal'] }}</td>
                    <td>{{ $ringkasan['perlu_konfirmasi'] }}</td>
                    <td>{{ $ringkasan['disetujui'] }}</td>
                    <td>{{ $ringkasan['ditolak'] }}</td>
                </tr>
            </tbody>
        </table>

        {{-- DETAIL --}}
        <div class="section-title">B. Rincian Data Absensi</div>
        <table class="main-table">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th width="125">Waktu Absensi</th>
                    <th width="120">Supir</th>
                    <th width="90">ID Jadwal</th>
                    <th width="40">Progress</th>
                    <th width="140">Rute</th>
                    <th width="90">Status</th>
                    <th width="110">Validator</th>
                    <th>Keterangan Supir</th>
                    <th>Alasan Penolakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $index => $absensi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $absensi->waktu_absensi?->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</td>
                        <td>{{ $absensi->supir->nama_supir ?? '-' }}</td>
                        <td>{{ $absensi->jadwal_id }}</td>
                        <td>{{ $index + 1 }}/{{ $absensis->count() }}</td>
                        <td>{{ $absensi->jadwal->kota_asal ?? '-' }} - {{ $absensi->jadwal->kota_tujuan ?? '-' }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $absensi->status_absensi)) }}</td>
                        <td>{{ $absensi->validator->nama_admin ?? '-' }}</td>
                        <td class="text-left">{{ $absensi->alasan ?? '-' }}</td>
                        <td class="text-left">{{ $absensi->alasan_penolakan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">Tidak ada data absensi pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="paragraph">
            Demikian laporan ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.
        </div>

        {{-- TANDA TANGAN --}}
        <table class="ttd-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    Direktur / Pimpinan
                    <div class="ttd-space"></div>
                    <div class="nama-ttd">{{ $direktur->nama_petinggi ?? '(............................)' }}</div>
                </td>
                <td>
                    Dibuat oleh,<br>
                    Staf Operasional
                    <div class="ttd-space"></div>
                    <div class="nama-ttd">{{ $admin->nama_admin ?? '(............................)' }}</div>
                </td>
            </tr>
        </table>

        <div class="footer-note">
            <br>
            *Dokumen ini dicetak melalui sistem informasi absensi PT Djanjikita Putra Mandiri.
        </div>
    </div>
</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Admin;
use App\Models\LaporanAbsensi;
use App\Models\Petinggi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $periodeMulai = $request->periode_mulai ?? now()->startOfMonth()->toDateString();
        $periodeSelesai = $request->periode_selesai ?? now()->endOfMonth()->toDateString();

        $absensis = Absensi::with(['supir', 'jadwal', 'validator'])
            ->whereBetween('waktu_absensi', [
                $periodeMulai . ' 00:00:00',
                $periodeSelesai . ' 23:59:59'
            ])
            ->orderBy('jadwal_id', 'asc')
            ->orderBy('waktu_absensi', 'asc')
            ->get();

        $counterPerJadwal = [];

        foreach ($absensis as $absensi) {
            $jadwalId = (string) $absensi->jadwal_id;

            if (!array_key_exists($jadwalId, $counterPerJadwal)) {
                $counterPerJadwal[$jadwalId] = 0;
            }

            $counterPerJadwal[$jadwalId]++;

            $absensi->progress_absensi = $counterPerJadwal[$jadwalId] . '/5';
        }

        $ringkasan = [
            'total' => $absensis->count(),
            'normal' => $absensis->where('status_absensi', 'normal')->count(),
            'perlu_konfirmasi' => $absensis->where('status_absensi', 'perlu_konfirmasi')->count(),
            'disetujui' => $absensis->where('status_absensi', 'disetujui')->count(),
            'ditolak' => $absensis->where('status_absensi', 'ditolak')->count(),
        ];

        $arsipPeriodeMulai = $request->arsip_periode_mulai;
        $arsipPeriodeSelesai = $request->arsip_periode_selesai;

        $queryArsip = LaporanAbsensi::with(['admin', 'petinggi']);

        if ($arsipPeriodeMulai && $arsipPeriodeSelesai) {
            $queryArsip->whereDate('periode_awal', '>=', $arsipPeriodeMulai)
                    ->whereDate('periode_akhir', '<=', $arsipPeriodeSelesai);
        } elseif ($arsipPeriodeMulai) {
            $queryArsip->whereDate('periode_awal', '>=', $arsipPeriodeMulai);
        } elseif ($arsipPeriodeSelesai) {
            $queryArsip->whereDate('periode_akhir', '<=', $arsipPeriodeSelesai);
        }

        $arsipLaporan = $queryArsip
            ->latest('created_at')
            ->paginate(5)
            ->appends($request->query());

        $daftarPetinggi = Petinggi::orderBy('nama_petinggi')->get();

        return view('admin.laporan-absensi.index', compact(
            'absensis',
            'ringkasan',
            'periodeMulai',
            'periodeSelesai',
            'arsipLaporan',
            'daftarPetinggi',
            'arsipPeriodeMulai',
            'arsipPeriodeSelesai'   
        ));
    }

    public function cetak(Request $request)
    {
        $periodeMulai = $request->periode_mulai ?? now()->startOfMonth()->toDateString();
        $periodeSelesai = $request->periode_selesai ?? now()->endOfMonth()->toDateString();

        $absensis = Absensi::with(['supir', 'jadwal', 'validator'])
            ->whereBetween('waktu_absensi', [
                $periodeMulai . ' 00:00:00',
                $periodeSelesai . ' 23:59:59'
            ])
            ->orderBy('jadwal_id', 'asc')  
            ->orderBy('waktu_absensi', 'asc')
            ->get();

        $ringkasan = [
            'total' => $absensis->count(),
            'normal' => $absensis->where('status_absensi', 'normal')->count(),
            'perlu_konfirmasi' => $absensis->where('status_absensi', 'perlu_konfirmasi')->count(),
            'disetujui' => $absensis->where('status_absensi', 'disetujui')->count(),
            'ditolak' => $absensis->where('status_absensi', 'ditolak')->count(),
        ];

        $admin = Admin::where('user_id', Auth::user()->user_id)->first();
        $direktur = Petinggi::orderBy('nama_petinggi')->first();

        return view('admin.laporan-absensi.cetak', compact(
            'absensis',
            'ringkasan',
            'periodeMulai',
            'periodeSelesai',
            'admin',
            'direktur'
        ));
    }

    public function uploadScan(Request $request)
    {
        $admin = Admin::where('user_id', Auth::user()->user_id)->firstOrFail();

        $request->validate([
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'petinggi_id' => 'nullable|exists:petinggis,petinggi_id',
            'file_laporan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'periode_mulai.required' => 'Periode mulai wajib diisi.',
            'periode_selesai.required' => 'Periode selesai wajib diisi.',
            'periode_selesai.after_or_equal' => 'Periode selesai tidak boleh sebelum periode mulai.',
            'file_laporan.required' => 'File laporan wajib diunggah.',
            'file_laporan.mimes' => 'File harus berupa pdf, jpg, jpeg, atau png.',
            'file_laporan.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        $laporan = new LaporanAbsensi();
        $laporan->dibuat_oleh = $admin->admin_id;
        $laporan->periode_awal = $request->periode_mulai;
        $laporan->periode_akhir = $request->periode_selesai;
        $laporan->petinggi_id = $request->petinggi_id;
        $laporan->status_laporan = 'final';
        $laporan->save();

        $extension = $request->file('file_laporan')->getClientOriginalExtension();
        $namaFile = $laporan->laporan_id . '.' . $extension;

        $request->file('file_laporan')->storeAs('laporan-final', $namaFile, 'public');

        $laporan->update([
            'file_laporan' => $namaFile,
        ]);

        return redirect()
            ->route('admin.laporan.index', [
                'periode_mulai' => $request->periode_mulai,
                'periode_selesai' => $request->periode_selesai,
            ])
            ->with('success', 'Scan laporan final berhasil diunggah.');
    }

    public function laporanFinalPetinggi(Request $request)
    {
        $periodeMulai = $request->periode_mulai;
        $periodeSelesai = $request->periode_selesai;

        $query = LaporanAbsensi::with(['admin', 'petinggi'])
            ->where('status_laporan', 'final');

        if ($periodeMulai && $periodeSelesai) {
            $query->whereDate('periode_awal', '>=', $periodeMulai)
                ->whereDate('periode_akhir', '<=', $periodeSelesai);
        } elseif ($periodeMulai) {
            $query->whereDate('periode_awal', '>=', $periodeMulai);
        } elseif ($periodeSelesai) {
            $query->whereDate('periode_akhir', '<=', $periodeSelesai);
        }

        $laporans = $query
            ->latest('created_at')
            ->paginate(5)
            ->appends($request->query());

        return view('petinggi.laporan-final', compact(
            'laporans',
            'periodeMulai',
            'periodeSelesai'
        ));
    }

    public function download($laporanId)
    {
        $laporan = LaporanAbsensi::findOrFail($laporanId);

        if (!$laporan->file_laporan) {
            return redirect()
                ->route('admin.laporan.index')
                ->withErrors(['file' => 'File laporan tidak ditemukan.']);
        }

        $path = storage_path('app/public/laporan-final/' . $laporan->file_laporan);

        if (!file_exists($path)) {
            return redirect()
                ->route('admin.laporan.index')
                ->withErrors(['file' => 'File laporan tidak ada di penyimpanan.']);
        }

        return response()->download($path, $laporan->file_laporan);
    }

    public function destroy($laporanId)
    {
        $laporan = LaporanAbsensi::findOrFail($laporanId);

        if ($laporan->file_laporan) {
            $path = 'laporan-final/' . $laporan->file_laporan;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $laporan->delete();

        return redirect()
            ->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function edit($laporanId)
    {
        $laporan = LaporanAbsensi::with(['admin', 'petinggi'])->findOrFail($laporanId);
        $daftarPetinggi = Petinggi::orderBy('nama_petinggi')->get();

        return view('admin.laporan-absensi.edit', compact('laporan', 'daftarPetinggi'));
    }

    public function update(Request $request, $laporanId)
    {
        $laporan = LaporanAbsensi::findOrFail($laporanId);

        $request->validate([
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'petinggi_id' => 'nullable|exists:petinggis,petinggi_id',
            'file_laporan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'periode_mulai.required' => 'Periode mulai wajib diisi.',
            'periode_selesai.required' => 'Periode selesai wajib diisi.',
            'periode_selesai.after_or_equal' => 'Periode selesai tidak boleh sebelum periode mulai.',
            'file_laporan.mimes' => 'File harus berupa pdf, jpg, jpeg, atau png.',
            'file_laporan.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        $laporan->update([
            'periode_awal' => $request->periode_mulai,
            'periode_akhir' => $request->periode_selesai,
            'petinggi_id' => $request->petinggi_id,
        ]);

        if ($request->hasFile('file_laporan')) {
            if ($laporan->file_laporan) {
                $oldPath = 'laporan-final/' . $laporan->file_laporan;

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $extension = $request->file('file_laporan')->getClientOriginalExtension();
            $namaFile = $laporan->laporan_id . '.' . $extension;

            $request->file('file_laporan')->storeAs('laporan-final', $namaFile, 'public');

            $laporan->update([
                'file_laporan' => $namaFile,
            ]);
        }

        return redirect()
            ->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function dokumentasiOperasional(Request $request)
    {
        $periodeMulai = $request->periode_mulai ?? now()->startOfMonth()->toDateString();
        $periodeSelesai = $request->periode_selesai ?? now()->endOfMonth()->toDateString();

        // 📄 laporan
        $laporans = LaporanAbsensi::with('admin')
            ->where('status_laporan', 'final')
            ->where(function ($q) use ($periodeMulai, $periodeSelesai) {
                $q->whereDate('periode_awal', '<=', $periodeSelesai)
                ->whereDate('periode_akhir', '>=', $periodeMulai);
            })
            ->get();

        // 📊 ambil data absensi
        $absensis = Absensi::with('supir')
            ->whereBetween('waktu_absensi', [
                $periodeMulai . ' 00:00:00',
                $periodeSelesai . ' 23:59:59'
            ])
            ->get();

        // 📊 statistik
        $ringkasan = [
            'total' => $absensis->count(),
            'normal' => $absensis->where('status_absensi', 'normal')->count(),
            'perlu_konfirmasi' => $absensis->where('status_absensi', 'perlu_konfirmasi')->count(),
            'disetujui' => $absensis->where('status_absensi', 'disetujui')->count(),
            'ditolak' => $absensis->where('status_absensi', 'ditolak')->count(),
        ];

        // 🧑‍✈️ supir paling aktif
        $supirTeraktif = $absensis
            ->where('status_absensi', 'disetujui')
            ->groupBy('supir_id')
            ->map(function ($items) {
                return [
                    'nama' => $items->first()->supir->nama_supir ?? '-',
                    'total' => $items->count()
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values();

        // 📊 Chart Status Absensi
        $statusChartLabels = ['Normal', 'Perlu Konfirmasi', 'Disetujui', 'Ditolak'];
        $statusChartData = [
            $ringkasan['normal'],
            $ringkasan['perlu_konfirmasi'],
            $ringkasan['disetujui'],
            $ringkasan['ditolak'],
        ];

        // 📊 Chart Supir Teraktif (Top 5)
        $supirChartLabels = $supirTeraktif->pluck('nama')->values();
        $supirChartData = $supirTeraktif->pluck('total')->values();

        return view('petinggi.dokumentasi-operasional', compact(
            'laporans',
            'ringkasan',
            'supirTeraktif',
            'periodeMulai',
            'periodeSelesai',
            'statusChartLabels',
            'statusChartData',
            'supirChartLabels',
            'supirChartData'
        ));
    }

    public function exportExcel(Request $request)
    {
        $periodeMulai = $request->periode_mulai ?? now()->startOfMonth()->toDateString();
        $periodeSelesai = $request->periode_selesai ?? now()->endOfMonth()->toDateString();

        $absensis = Absensi::with(['supir', 'jadwal', 'validator'])
            ->whereBetween('waktu_absensi', [
                $periodeMulai . ' 00:00:00',
                $periodeSelesai . ' 23:59:59'
            ])
            ->orderBy('jadwal_id', 'asc')
            ->orderBy('waktu_absensi', 'asc')
            ->get();

        $filename = 'laporan-absensi-' . $periodeMulai . '-sampai-' . $periodeSelesai . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($absensis) {
            $file = fopen('php://output', 'w');

            // BOM biar Excel baca UTF-8 dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'Waktu Absensi',
                'Supir',
                'ID Jadwal',
                'Rute',
                'Status',
                'Validator',
                'Keterangan Supir',
                'Alasan Penolakan',
            ]);

            foreach ($absensis as $index => $absensi) {
                fputcsv($file, [
                    $index + 1,
                    $absensi->waktu_absensi?->timezone('Asia/Jakarta')->format('d-m-Y H:i') . ' WIB',
                    $absensi->supir->nama_supir ?? '-',
                    $absensi->jadwal_id,
                    ($absensi->jadwal->kota_asal ?? '-') . ' -> ' . ($absensi->jadwal->kota_tujuan ?? '-'),
                    str_replace('_', ' ', $absensi->status_absensi),
                    $absensi->validator->nama_admin ?? '-',
                    $absensi->alasan ?? '-',
                    $absensi->alasan_penolakan ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
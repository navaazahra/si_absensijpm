<?php

namespace App\Http\Controllers;

use App\Models\JadwalAbsensi;
use App\Models\Supir;
use Illuminate\Http\Request;

class JadwalAbsensiController extends Controller
{
    public function index()
    {
        $jadwals = JadwalAbsensi::with('supir')
            ->latest()
            ->get();

        foreach ($jadwals as $jadwal) {
            $statusBaru = $this->tentukanStatusJadwal($jadwal->tanggal_mulai, $jadwal->tanggal_selesai);

            if ($jadwal->status_jadwal !== $statusBaru) {
                $jadwal->update(['status_jadwal' => $statusBaru]);
            }
        }

        $jadwals = JadwalAbsensi::with('supir')->latest()->get();
        return view('admin.jadwal-absensi.index', compact('jadwals'));
    }

    public function create()
    {
        $supirs = Supir::orderBy('nama_supir')->get();

        return view('admin.jadwal-absensi.create', compact('supirs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supir_id' => 'required|exists:supirs,supir_id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kota_asal' => 'required|string|max:100',
            'kota_tujuan' => 'required|string|max:100',
        ], [
            'supir_id.required' => 'Supir wajib dipilih.',
            'supir_id.exists' => 'Supir tidak ditemukan.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'kota_asal.required' => 'Kota asal wajib diisi.',
            'kota_tujuan.required' => 'Kota tujuan wajib diisi.',
        ]);

        if ($this->adaJadwalBentrok(
            $validated['supir_id'],
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai']
        )) {
            return back()
                ->withErrors([
                    'jadwal_bentrok' => 'Jadwal bentrok. Supir ini sudah memiliki jadwal pada rentang tanggal tersebut.',
                ])
                ->withInput();
        }

        $validated['jam_absen_mulai'] = '00:00';
        $validated['jam_absen_selesai'] = '23:59';
        $validated['status_jadwal'] = $this->tentukanStatusJadwal(
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai']
        );

        $jadwal = \App\Models\JadwalAbsensi::create($validated);

        $warningTruk = $this->cekPeringatanTrukLama($validated['supir_id']);

        return redirect()
            ->route('jadwal-absensi.index')
            ->with('success', 'Jadwal absensi berhasil ditambahkan.')
            ->with('warning', $warningTruk);
    }

    public function show(string $id)
    {
        $jadwalAbsensi = JadwalAbsensi::with('supir')->findOrFail($id);

        return view('admin.jadwal-absensi.show', compact('jadwalAbsensi'));
    }

    public function edit(string $id)
    {
        $jadwalAbsensi = JadwalAbsensi::findOrFail($id);
        $supirs = Supir::orderBy('nama_supir')->get();

        return view('admin.jadwal-absensi.edit', compact('jadwalAbsensi', 'supirs'));
    }

    public function update(Request $request, string $id)
    {
        $jadwalAbsensi = \App\Models\JadwalAbsensi::findOrFail($id);

        $validated = $request->validate([
            'supir_id' => 'required|exists:supirs,supir_id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kota_asal' => 'required|string|max:100',
            'kota_tujuan' => 'required|string|max:100',
        ], [
            'supir_id.required' => 'Supir wajib dipilih.',
            'supir_id.exists' => 'Supir tidak ditemukan.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'kota_asal.required' => 'Kota asal wajib diisi.',
            'kota_tujuan.required' => 'Kota tujuan wajib diisi.',
        ]);

        if ($this->adaJadwalBentrok(
            $validated['supir_id'],
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai'],
            $jadwalAbsensi->jadwal_id
        )) {
            return back()
                ->withErrors([
                    'jadwal_bentrok' => 'Jadwal bentrok. Supir ini sudah memiliki jadwal pada rentang tanggal tersebut.',
                ])
                ->withInput();
        }

        $validated['jam_absen_mulai'] = '00:00';
        $validated['jam_absen_selesai'] = '23:59';
        $validated['status_jadwal'] = $this->tentukanStatusJadwal(
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai']
        );

        $jadwalAbsensi->update($validated);

        $warningTruk = $this->cekPeringatanTrukLama($validated['supir_id']);

        return redirect()
            ->route('jadwal-absensi.index')
            ->with('success', 'Jadwal absensi berhasil diperbarui.')
            ->with('warning', $warningTruk);
    }

    public function destroy(string $id)
    {
        $jadwalAbsensi = JadwalAbsensi::findOrFail($id);
        $jadwalAbsensi->delete();

        return redirect()
            ->route('jadwal-absensi.index')
            ->with('success', 'Jadwal absensi berhasil dihapus.');
    }

    private function tentukanStatusJadwal($tanggalMulai, $tanggalSelesai)
    {
        $hariIni = now()->toDateString();

        if ($hariIni < $tanggalMulai) {
            return 'nonaktif';
        }

        if ($hariIni > $tanggalSelesai) {
            return 'selesai';
        }

        return 'aktif';
    }

    private function adaJadwalBentrok($supirId, $tanggalMulai, $tanggalSelesai, $ignoreId = null)
    {
        $query = \App\Models\JadwalAbsensi::where('supir_id', $supirId)
            ->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->where('tanggal_mulai', '<=', $tanggalSelesai)
                ->where('tanggal_selesai', '>=', $tanggalMulai);
            });

        if ($ignoreId) {
            $query->where('jadwal_id', '!=', $ignoreId);
        }

        return $query->exists();
    }

    private function cekPeringatanTrukLama($supirId)
    {
        $supir = \App\Models\Supir::find($supirId);

        if (!$supir || !$supir->tahun_truk) {
            return null;
        }

        $batasTahun = now()->year - 20;

        if ((int) $supir->tahun_truk <= $batasTahun) {
            return "Perhatian: truk milik supir {$supir->nama_supir} termasuk keluaran lama (tahun {$supir->tahun_truk}).";
        }

        return null;
    }
}
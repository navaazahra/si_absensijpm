<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\JadwalAbsensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupirController extends Controller
{
    public function jadwalSaya()
    {
        $user = User::with('supir')
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        $supir = $user->supir;

        $jadwals = collect();

        if ($supir) {
            $jadwals = JadwalAbsensi::where('supir_id', $supir->supir_id)
                ->orderByDesc('tanggal_mulai')
                ->get();

            foreach ($jadwals as $jadwal) {
                $statusBaru = $this->tentukanStatusJadwal(
                    $jadwal->tanggal_mulai,
                    $jadwal->tanggal_selesai
                );

                if ($jadwal->status_jadwal !== $statusBaru) {
                    $jadwal->update([
                        'status_jadwal' => $statusBaru,
                    ]);

                    $jadwal->status_jadwal = $statusBaru;
                }
            }
        }

        return view('supir.jadwal', compact('supir', 'jadwals'));
    }

    public function absenSekarang()
    {
        $user = User::with('supir')
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        $supir = $user->supir;

        if (!$supir) {
            abort(404, 'Data supir tidak ditemukan.');
        }

        $hariIni = now()->toDateString();

        $jadwals = JadwalAbsensi::where('supir_id', $supir->supir_id)
            ->orderByDesc('tanggal_mulai')
            ->get();

        $jadwalAktif = null;

        foreach ($jadwals as $jadwal) {
            $totalAbsensiPadaJadwal = Absensi::where('supir_id', $supir->supir_id)
                ->where('jadwal_id', $jadwal->jadwal_id)
                ->count();

            if ($totalAbsensiPadaJadwal >= 5) {
                continue;
            }

            if (
                $hariIni >= $jadwal->tanggal_mulai &&
                $hariIni <= $jadwal->tanggal_selesai
            ) {
                $jadwalAktif = $jadwal;
                break;
            }

            if (!$jadwalAktif) {
                $jadwalAktif = $jadwal;
            }
        }

        $totalAbsensiHariIni = Absensi::where('supir_id', $supir->supir_id)
            ->whereDate('waktu_absensi', $hariIni)
            ->count();

        $totalAbsensiPadaJadwal = 0;

        if ($jadwalAktif) {
            $totalAbsensiPadaJadwal = Absensi::where('supir_id', $supir->supir_id)
                ->where('jadwal_id', $jadwalAktif->jadwal_id)
                ->count();
        }

        return view('supir.absen', compact(
            'supir',
            'jadwalAktif',
            'totalAbsensiHariIni',
            'totalAbsensiPadaJadwal'
        ));
    }

    public function storeAbsen(Request $request)
    {
        $user = User::with('supir')
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        $supir = $user->supir;

        if (!$supir) {
            return back()->withErrors([
                'absen' => 'Data supir tidak ditemukan.',
            ]);
        }

        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_absensis,jadwal_id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_base64' => 'required|string',
            'alasan' => 'nullable|string',
        ], [
            'jadwal_id.required' => 'Jadwal wajib tersedia.',
            'latitude.required' => 'Lokasi wajib diambil.',
            'longitude.required' => 'Lokasi wajib diambil.',
            'foto_base64.required' => 'Foto selfie wajib diambil dari kamera.',
        ]);

        $jadwal = JadwalAbsensi::where('jadwal_id', $request->jadwal_id)
            ->where('supir_id', $supir->supir_id)
            ->firstOrFail();

        $hariIni = now()->toDateString();

        $sudahAbsenHariIni = Absensi::where('supir_id', $supir->supir_id)
            ->whereDate('waktu_absensi', $hariIni)
            ->exists();

        if ($sudahAbsenHariIni) {
            return back()
                ->withErrors([
                    'absen' => 'Anda sudah melakukan absensi hari ini. Absensi hanya boleh 1 kali per hari.',
                ])
                ->withInput();
        }

        $totalAbsensiPadaJadwal = Absensi::where('supir_id', $supir->supir_id)
            ->where('jadwal_id', $jadwal->jadwal_id)
            ->count();

        if ($totalAbsensiPadaJadwal >= 5) {
            return back()
                ->withErrors([
                    'absen' => 'Target absensi untuk jadwal ini sudah mencapai 5 kali.',
                ])
                ->withInput();
        }

        $statusAbsensi = (
            $hariIni >= $jadwal->tanggal_mulai &&
            $hariIni <= $jadwal->tanggal_selesai
        ) ? 'normal' : 'perlu_konfirmasi';

        if ($statusAbsensi === 'perlu_konfirmasi' && !$request->filled('alasan')) {
            return back()
                ->withErrors([
                    'alasan' => 'Alasan wajib diisi jika absensi dilakukan di luar jadwal.',
                ])
                ->withInput();
        }

        $fotoPath = $this->simpanFotoBase64($request->foto_base64);

        Absensi::create([
            'supir_id' => $supir->supir_id,
            'jadwal_id' => $jadwal->jadwal_id,
            'waktu_absensi' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto' => $fotoPath,
            'status_absensi' => $statusAbsensi,
            'alasan' => $request->alasan,
        ]);

        return redirect()
            ->route('supir.riwayat')
            ->with('success', 'Absensi berhasil dikirim.');
    }

    public function riwayatAbsensi()
    {
        $user = User::with('supir')
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        $supir = $user->supir;

        $absensis = collect();

        if ($supir) {
            $absensis = Absensi::with('jadwal')
                ->where('supir_id', $supir->supir_id)
                ->orderBy('jadwal_id')
                ->orderBy('waktu_absensi')
                ->get();

            $counterPerJadwal = [];

            $absensis = $absensis->map(function ($absensi) use (&$counterPerJadwal) {
                $jadwalId = $absensi->jadwal_id;

                if (!isset($counterPerJadwal[$jadwalId])) {
                    $counterPerJadwal[$jadwalId] = 0;
                }

                $counterPerJadwal[$jadwalId]++;

                $absensi->absensi_ke = $counterPerJadwal[$jadwalId];
                $absensi->target_absensi = 5;

                return $absensi;
            })->sortByDesc('waktu_absensi')->values();
        }

        return view('supir.riwayat', compact('supir', 'absensis'));
    }

    private function simpanFotoBase64(string $fotoBase64): string
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $fotoBase64, $type)) {
            throw new \Exception('Format foto tidak valid.');
        }

        $fotoBase64 = substr($fotoBase64, strpos($fotoBase64, ',') + 1);
        $fotoBase64 = str_replace(' ', '+', $fotoBase64);
        $imageData = base64_decode($fotoBase64);

        if ($imageData === false) {
            throw new \Exception('Gagal decode foto base64.');
        }

        $extension = strtolower($type[1]);

        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            throw new \Exception('Format foto harus jpg, jpeg, atau png.');
        }

        $fileName = 'absensi/' . uniqid('selfie_', true) . '.' . $extension;

        Storage::disk('public')->put($fileName, $imageData);

        return $fileName;
    }

    public function updateAlasanRiwayat(Request $request, string $absensiId)
    {
        $user = User::with('supir')
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        $supir = $user->supir;

        if (!$supir) {
            return back()->withErrors([
                'riwayat' => 'Data supir tidak ditemukan.',
            ]);
        }

        $absensi = Absensi::where('absensi_id', $absensiId)
            ->where('supir_id', $supir->supir_id)
            ->firstOrFail();

        if ($absensi->waktu_validasi || in_array($absensi->status_absensi, ['disetujui', 'ditolak'])) {
            return back()->withErrors([
                'riwayat' => 'Alasan tidak bisa diubah karena absensi sudah divalidasi admin.',
            ]);
        }

        $request->validate([
            'alasan' => 'nullable|string|max:1000',
        ], [
            'alasan.max' => 'Alasan maksimal 1000 karakter.',
        ]);

        $absensi->update([
            'alasan' => $request->alasan,
        ]);

        return redirect()
            ->route('supir.riwayat')
            ->with('success', 'Keterangan/alasan berhasil diperbarui.');
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
}
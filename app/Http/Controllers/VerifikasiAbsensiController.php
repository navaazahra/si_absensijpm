<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['supir', 'jadwal', 'validator'])
            ->latest('waktu_absensi');

        if ($request->filled('status')) {
            $query->where('status_absensi', $request->status);
        }

        $absensis = $query->get();

        return view('admin.verifikasi-absensi.index', compact('absensis'));
    }

    public function setujui(string $absensiId)
    {
        $admin = $this->getAdminLogin();

        $absensi = Absensi::findOrFail($absensiId);

        $absensi->update([
            'status_absensi' => 'disetujui',
            'divalidasi_oleh' => $admin->admin_id,
            'waktu_validasi' => now(),
            'alasan_penolakan' => null,
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', 'Absensi berhasil disetujui.');
    }

    public function tolak(Request $request, string $absensiId)
    {
        $admin = $this->getAdminLogin();

        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $absensi = Absensi::findOrFail($absensiId);

        $absensi->update([
            'status_absensi' => 'ditolak',
            'divalidasi_oleh' => $admin->admin_id,
            'waktu_validasi' => now(),
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', 'Absensi berhasil ditolak.');
    }

    public function ubahKeDisetujui(string $absensiId)
    {
        $admin = $this->getAdminLogin();

        $absensi = Absensi::findOrFail($absensiId);

        $absensi->update([
            'status_absensi' => 'disetujui',
            'divalidasi_oleh' => $admin->admin_id,
            'waktu_validasi' => now(),
            'alasan_penolakan' => null,
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', 'Keputusan validasi berhasil diubah menjadi disetujui.');
    }

    public function ubahKeDitolak(Request $request, string $absensiId)
    {
        $admin = $this->getAdminLogin();

        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $absensi = Absensi::findOrFail($absensiId);

        $absensi->update([
            'status_absensi' => 'ditolak',
            'divalidasi_oleh' => $admin->admin_id,
            'waktu_validasi' => now(),
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', 'Keputusan validasi berhasil diubah menjadi ditolak.');
    }

    private function getAdminLogin()
    {
        $admin = Admin::where('user_id', Auth::user()->user_id)->first();

        if (!$admin) {
            abort(403, 'Data admin tidak ditemukan.');
        }

        return $admin;
    }
}
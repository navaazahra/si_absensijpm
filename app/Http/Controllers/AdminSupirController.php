<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSupirController extends Controller
{
    public function index()
    {
        $supirs = Supir::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.supir.index', compact('supirs'));
    }

    public function create()
    {
        return view('admin.supir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supir' => 'required|max:100',
            'no_polisi' => 'required|max:15',
            'merk_truk' => 'nullable|max:50',
            'tahun_truk' => 'nullable|digits:4',
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable',

            'username' => 'required|max:50|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ], [
            'nama_supir.required' => 'Nama supir wajib diisi.',
            'no_polisi.required' => 'Nomor polisi wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'supir',
            'status_aktif' => 'aktif',
        ]);

        Supir::create([
            'user_id' => $user->user_id,
            'nama_supir' => $request->nama_supir,
            'no_polisi' => $request->no_polisi,
            'merk_truk' => $request->merk_truk,
            'tahun_truk' => $request->tahun_truk,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('admin.supir.index')
            ->with('success', 'Supir berhasil ditambahkan.');
    }

    public function edit(string $supirId)
    {
        $supir = Supir::with('user')->findOrFail($supirId);

        return view('admin.supir.edit', compact('supir'));
    }

    public function update(Request $request, string $supirId)
    {
        $supir = Supir::with('user')->findOrFail($supirId);

        $request->validate([
            'nama_supir' => 'required|max:100',
            'no_polisi' => 'required|max:15',
            'merk_truk' => 'nullable|max:50',
            'tahun_truk' => 'nullable|digits:4',
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable',
            'username' => 'required|max:50|unique:users,username,' . $supir->user_id . ',user_id',
            'status_aktif' => 'required|in:aktif,nonaktif',
        ], [
            'nama_supir.required' => 'Nama supir wajib diisi.',
            'no_polisi.required' => 'Nomor polisi wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'status_aktif.required' => 'Status aktif wajib dipilih.',
        ]);

        $supir->update([
            'nama_supir' => $request->nama_supir,
            'no_polisi' => $request->no_polisi,
            'merk_truk' => $request->merk_truk,
            'tahun_truk' => $request->tahun_truk,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        $supir->user->update([
            'username' => $request->username,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()
            ->route('admin.supir.index')
            ->with('success', 'Data supir berhasil diperbarui.');
    }

    public function destroy(string $supirId)
    {
        $supir = Supir::with('user')->findOrFail($supirId);

        if ($supir->user) {
            $supir->user->delete();
        } else {
            $supir->delete();
        }

        return redirect()
            ->route('admin.supir.index')
            ->with('success', 'Data supir berhasil dihapus.');
    }

    public function resetPassword(Request $request, string $supirId)
    {
        $supir = Supir::with('user')->findOrFail($supirId);

        $request->validate([
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $supir->user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()
            ->route('admin.supir.edit', $supir->supir_id)
            ->with('success', 'Password supir berhasil direset.');
    }

    public function toggleStatus(string $supirId)
    {
        $supir = Supir::with('user')->findOrFail($supirId);

        if (!$supir->user) {
            return redirect()
                ->route('admin.supir.index')
                ->withErrors(['supir' => 'Akun user untuk supir ini tidak ditemukan.']);
        }

        $statusBaru = $supir->user->status_aktif === 'aktif' ? 'nonaktif' : 'aktif';

        $supir->user->update([
            'status_aktif' => $statusBaru,
        ]);

        return redirect()
            ->route('admin.supir.index')
            ->with('success', 'Status akun supir berhasil diubah menjadi ' . $statusBaru . '.');
    }
}
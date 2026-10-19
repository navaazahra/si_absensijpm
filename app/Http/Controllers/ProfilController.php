<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = User::with(['admin', 'supir', 'petinggi'])
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        return view('profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::with(['admin', 'petinggi'])
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        if ($user->role === 'supir') {
            abort(403);
        }

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->user_id . ',user_id',
            'nama' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jabatan' => 'nullable|in:direktur,pimpinan',
        ]);

        $user->update([
            'username' => $request->username,
        ]);

        if ($user->role === 'admin') {
            $user->admin->update([
                'nama_admin' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }

        if ($user->role === 'petinggi') {
            $user->petinggi->update([
                'nama_petinggi' => $request->nama,
                'jabatan' => $request->jabatan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->firstOrFail();

        if ($user->role === 'supir') {
            abort(403);
        }

        $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama salah.',
            ]);
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
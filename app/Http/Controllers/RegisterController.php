<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Petinggi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showAdminRegister()
    {
        return view('auth.register-admin');
    }

    public function showPetinggiRegister()
    {
        return view('auth.register-petinggi');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'kode_akses' => 'required|string',
        ], [
            'nama.required' => 'Nama admin wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kode_akses.required' => 'Kode akses wajib diisi.',
        ]);

        $kodeInput = strtoupper(trim($request->kode_akses));
        $kodeValid = strtoupper(trim((string) config('register_codes.admin')));

        if ($kodeInput !== $kodeValid) {
            return back()
                ->withErrors(['kode_akses' => 'Kode akses admin tidak valid.'])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'status_aktif' => 'aktif',
            ]);

            Admin::create([
                'user_id' => $user->user_id,
                'nama_admin' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();

            return redirect()
                ->route('login')
                ->with('success', 'Registrasi admin berhasil. Silakan login.');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function registerPetinggi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|in:direktur,pimpinan',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'kode_akses' => 'required|string',
        ], [
            'nama.required' => 'Nama petinggi wajib diisi.',
            'jabatan.required' => 'Jabatan wajib dipilih.',
            'jabatan.in' => 'Jabatan harus direktur atau pimpinan.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kode_akses.required' => 'Kode akses wajib diisi.',
        ]);

        $kodeInput = strtoupper(trim($request->kode_akses));
        $kodeValid = strtoupper(trim((string) config('register_codes.petinggi')));

        if ($kodeInput !== $kodeValid) {
            return back()
                ->withErrors(['kode_akses' => 'Kode akses petinggi tidak valid.'])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'petinggi',
                'status_aktif' => 'aktif',
            ]);

            Petinggi::create([
                'user_id' => $user->user_id,
                'nama_petinggi' => $request->nama,
                'jabatan' => $request->jabatan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();

            return redirect()
                ->route('login')
                ->with('success', 'Registrasi petinggi berhasil. Silakan login.');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
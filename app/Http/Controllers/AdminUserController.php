<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $users = User::with(['admin', 'supir', 'petinggi'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('username', 'like', '%' . $keyword . '%')
                    ->orWhereHas('admin', function ($q) use ($keyword) {
                        $q->where('nama_admin', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('supir', function ($q) use ($keyword) {
                        $q->where('nama_supir', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('petinggi', function ($q) use ($keyword) {
                        $q->where('nama_petinggi', 'like', '%' . $keyword . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.user-reset-password.index', compact('users', 'keyword'));
    }

    public function resetPassword(Request $request, string $userId)
    {
        $user = User::findOrFail($userId);

        $request->validate([
            'password_baru' => 'required|string|min:6|confirmed',
        ], [
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password user berhasil direset.');
    }
}
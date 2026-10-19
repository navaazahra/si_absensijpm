<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalAbsensiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\VerifikasiAbsensiController;
use App\Http\Controllers\LaporanAbsensiController;
use App\Http\Controllers\AdminSupirController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\GuideController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/guide/umum', [GuideController::class, 'umum'])->name('guide.umum');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register/admin', [RegisterController::class, 'showAdminRegister'])->name('admin.register');
    Route::post('/register/admin', [RegisterController::class, 'registerAdmin'])->name('admin.register.store');

    Route::get('/register/petinggi', [RegisterController::class, 'showPetinggiRegister'])->name('petinggi.register');
    Route::post('/register/petinggi', [RegisterController::class, 'registerPetinggi'])->name('petinggi.register.store');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard/admin', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/dashboard/supir', function () {
        return view('supir.dashboard');
    })->middleware('role:supir')->name('supir.dashboard');

    Route::get('/dashboard/petinggi', function () {
        return view('petinggi.dashboard');
    })->middleware('role:petinggi')->name('petinggi.dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::resource('/admin/jadwal-absensi', JadwalAbsensiController::class);
        Route::get('/admin/verifikasi-absensi', [VerifikasiAbsensiController::class, 'index'])->name('admin.verifikasi.index');
        Route::patch('/admin/verifikasi-absensi/{absensi}/setujui', [VerifikasiAbsensiController::class, 'setujui'])->name('admin.verifikasi.setujui');
        Route::patch('/admin/verifikasi-absensi/{absensi}/tolak', [VerifikasiAbsensiController::class, 'tolak'])->name('admin.verifikasi.tolak');
        Route::patch('/admin/verifikasi-absensi/{absensi}/ubah-ke-disetujui', [VerifikasiAbsensiController::class, 'ubahKeDisetujui'])->name('admin.verifikasi.ubah-ke-disetujui');
        Route::patch('/admin/verifikasi-absensi/{absensi}/ubah-ke-ditolak', [VerifikasiAbsensiController::class, 'ubahKeDitolak'])->name('admin.verifikasi.ubah-ke-ditolak');
        Route::get('/admin/laporan-absensi', [LaporanAbsensiController::class, 'index'])->name('admin.laporan.index');
        Route::get('/admin/laporan-absensi/cetak', [LaporanAbsensiController::class, 'cetak'])->name('admin.laporan.cetak');
        Route::post('/admin/laporan-absensi/upload-scan', [LaporanAbsensiController::class, 'uploadScan'])->name('admin.laporan.upload-scan');   
        Route::get('/admin/laporan/{laporan}/download', [LaporanAbsensiController::class, 'download'])
            ->name('admin.laporan.download');
        Route::delete('/admin/laporan/{laporan}', [LaporanAbsensiController::class, 'destroy'])
            ->name('admin.laporan.destroy');
        Route::get('/admin/laporan/{laporan}/edit', [LaporanAbsensiController::class, 'edit'])
            ->name('admin.laporan.edit');

        Route::put('/admin/laporan/{laporan}', [LaporanAbsensiController::class, 'update'])
            ->name('admin.laporan.update');

        Route::get('admin/supir', [AdminSupirController::class, 'index'])->name('admin.supir.index');
        Route::get('admin/supir/create', [AdminSupirController::class, 'create'])->name('admin.supir.create');
        Route::post('admin/supir', [AdminSupirController::class, 'store'])->name('admin.supir.store');
        Route::get('admin/supir/{supir}/edit', [AdminSupirController::class, 'edit'])->name('admin.supir.edit');
        Route::put('admin/supir/{supir}', [AdminSupirController::class, 'update'])->name('admin.supir.update');
        Route::delete('admin/supir/{supir}', [AdminSupirController::class, 'destroy'])->name('admin.supir.destroy');

        Route::put('/admin/supir/{supir}/reset-password', [AdminSupirController::class, 'resetPassword'])->name('admin.supir.reset-password');
        Route::put('/admin/supir/{supir}/toggle-status', [AdminSupirController::class, 'toggleStatus'])
            ->name('admin.supir.toggle-status');
        Route::get('/admin/laporan/export-excel', [LaporanAbsensiController::class, 'exportExcel'])
            ->name('admin.laporan.export-excel');
    });

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    Route::middleware('role:supir')->group(function () {
        Route::get('/supir/jadwal', [SupirController::class, 'jadwalSaya'])->name('supir.jadwal');
        Route::get('/supir/absen', [SupirController::class, 'absenSekarang'])->name('supir.absen');
        Route::get('/supir/riwayat', [SupirController::class, 'riwayatAbsensi'])->name('supir.riwayat');
        Route::post('/supir/absen', [SupirController::class, 'storeAbsen'])->name('supir.absen.store');
        Route::patch('/supir/riwayat/{absensi}', [SupirController::class, 'updateAlasanRiwayat'])->name('supir.riwayat.update-alasan');
    });

    Route::middleware('role:petinggi')->group(function () {
        Route::get('/petinggi/laporan-final', [LaporanAbsensiController::class, 'laporanFinalPetinggi'])->name('petinggi.laporan-final');
        Route::get('/petinggi/dokumentasi-operasional', [LaporanAbsensiController::class, 'dokumentasiOperasional'])
            ->name('petinggi.dokumentasi');
    });

    Route::get('/admin/reset-password-user', [AdminUserController::class, 'index'])->name('admin.user.reset.index');
    Route::put('/admin/reset-password-user/{user}', [AdminUserController::class, 'resetPassword'])->name('admin.user.reset.password');

    Route::get('/guide/supir', [GuideController::class, 'supir'])->name('guide.supir');
    Route::get('/guide/admin', [GuideController::class, 'admin'])->name('guide.admin');
    Route::get('/guide/petinggi', [GuideController::class, 'petinggi'])->name('guide.petinggi');
});
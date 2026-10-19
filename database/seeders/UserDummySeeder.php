<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Supir;
use App\Models\Admin;
use App\Models\Petinggi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDummySeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $userAdmin = User::create([
            'username' => 'admin1',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status_aktif' => 'aktif',
        ]);

        Admin::create([
            'user_id' => $userAdmin->user_id,
            'nama_admin' => 'Admin Operasional',
            'no_hp' => '081234567890',
            'alamat' => 'Kantor Pusat',
        ]);

        // Supir
        $userSupir = User::create([
            'username' => 'supir1',
            'password' => Hash::make('password123'),
            'role' => 'supir',
            'status_aktif' => 'aktif',
        ]);

        Supir::create([
            'user_id' => $userSupir->user_id,
            'nama_supir' => 'Budi Santoso',
            'no_polisi' => 'B1234CD',
            'merk_truk' => 'Hino',
            'tahun_truk' => '2020',
            'no_hp' => '081298765432',
            'alamat' => 'Jakarta',
        ]);

        // Petinggi
        $userPetinggi = User::create([
            'username' => 'direktur1',
            'password' => Hash::make('password123'),
            'role' => 'petinggi',
            'status_aktif' => 'aktif',
        ]);

        Petinggi::create([
            'user_id' => $userPetinggi->user_id,
            'nama_petinggi' => 'Direktur Utama',
            'jabatan' => 'direktur',
            'no_hp' => '081211111111',
            'alamat' => 'Bandung',
        ]);
    }
}
# 🚚 Sistem Informasi Absensi JPM (SI Absensi JPM)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev/)

> **SI Absensi JPM** adalah sistem informasi berbasis web yang dirancang khusus untuk mengelola, mencatat, dan memantau data kehadiran sopir secara terstruktur dan terintegrasi secara *real-time*.

---

## 📸 Antarmuka Sistem (Screenshots)

| Dashboard | Form Presensi Sopir |
| :---: | :---: |
| ![Dashboard](https://github.com/user-attachments/assets/a10a3ac1-710f-4d24-ab6e-e9dc2464c6aa) | ![Form Presensi](https://github.com/user-attachments/assets/f0100b51-3969-4d36-87c8-1ad555a6e1c4) |

| Laporan Pimpinan | Rekap Data Presensi |
| :---: | :---: |
| ![Laporan Pimpinan](https://github.com/user-attachments/assets/a8f4b1aa-07b0-4c16-8313-208075d0d22f) | ![Rekap Data Presensi](https://github.com/user-attachments/assets/97d8ca05-37cb-408b-8367-91f35b13cd47) |

---

## 👥 Hak Akses & Peran Pengguna (User Roles)

Sistem ini menerapkan mekanisme **Multi-Role Authentication** yang membedakan hak akses berdasarkan wewenang:

- **👨‍💼 Admin**
  * Pengelolaan data master pengguna (Admin, Sopir, Pimpinan).
  * Pengaturan jadwal penugasan dan armada operasional.
  * Pemantauan dan koreksi data kehadiran harian.
- **🚚 Sopir**
  * Pencatatan presensi masuk dan keluar harian.
  * Pemantauan riwayat kehadiran pribadi.
- **👨‍💻 Pimpinan**
  * Akses *dashboard* eksekutif ringkasan kehadiran.
  * Monitoring laporan rekapitulasi presensi harian/bulanan.
  * Ekspor laporan data absensi untuk evaluasi operasional.

---

## 🚀 Fitur Utama

- **Multi-Role Authentication & Security**: Pembatasan akses berbasis peran pengguna.
- **Real-Time Attendance Logging**: Pencatatan data waktu presensi secara akurat.
- **Interactive Dashboard**: Visualisasi ringkas statistik kehadiran untuk pimpinan dan admin.
- **Reporting & Data Export**: Kemudahan dalam mencetak serta merekap laporan presensi.
- **Responsive Layout**: Tampilan antarmuka yang optimal diakses lewat *desktop* maupun *mobile*.

---

## 🛠️ Spesifikasi & Teknologi

- **Back-End**: PHP (Laravel Framework)
- **Front-End**: HTML5, CSS3, JavaScript, Blade Templating
- **Build Tool**: Vite
- **Database**: MySQL
- **Version Control**: Git & GitHub

---

## 📁 Struktur Folder Utama

```text
si_absensijpm/
├── app/
│   ├── Http/Controllers/    # Logika bisnis (Admin, Sopir, Pimpinan)
│   └── Models/              # Model data Eloquent (User, Absensi, dll)
├── database/
│   ├── migrations/          # Struktur tabel database
│   └── seeders/             # Data awal / dummy role & user
├── resources/
│   └── views/               # Tampilan antarmuka (Blade Template)
└── routes/
    └── web.php              # Routing & middleware hak akses

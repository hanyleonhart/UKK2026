# Aplikasi Manajemen Perpustakaan Digital (UKK 2026)

Aplikasi manajemen perpustakaan berbasis web yang dibuat menggunakan Laravel 11 dan Filament v3 untuk memenuhi standar Ujian Keahlian Kejuruan (UKK) 2026.

## Hak Akses & Kredensial Login Penguji

Sistem ini mendukung Multi-Role Authentication (Admin dan Siswa). Gunakan akun berikut untuk pengujian:

| Role | Email | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| Admin | admin@gmail.com | password123 | Full Access (Kelola Buku, Transaksi, & Data Pengguna) |
| Siswa | siswa@gmail.com | password123 | Katalog Buku (Read-Only) & Pengajuan Peminjaman Mandiri |

## Fitur Utama Sesuai Alur Kerja UKK

### Role Admin
- Kelola Data Pengguna (Users): Menambah, mengubah, dan menghapus data pengguna (Admin & Siswa).
- Kelola Data Buku (Books): Mengelola katalog buku (Judul, Penulis, Penerbit, Tahun, ISBN, Stok).
- Kelola Transaksi (Loans): Memantau seluruh peminjaman dan mengubah status pengembalian buku.

### Role Siswa
- Registrasi Mandiri: Pendaftaran akun anggota baru langsung dari panel login.
- Katalog Buku: Melihat daftar seluruh buku yang tersedia di perpustakaan.
- Peminjaman Buku: Mengajukan peminjaman buku baru secara mandiri.
- Riwayat Pribadi: Memantau transaksi dan status peminjaman milik sendiri secara otomatis.

## Cara Instalasi & Menjalankan Proyek

1. Clone Repository & Install Dependency:
   git clone <link-repository-github-kamu>
   cd UKK2026
   composer install

2. Pengaturan Environment (.env):
   cp .env.example .env

3. Generate Application Key:
   php artisan key:generate

4. Migrasi Database & Seeder:
   php artisan migrate --seed

5. Jalankan Server Lokal:
   php artisan serve
   
   Akses aplikasi melalui browser pada alamat: http://127.0.0.1:8000/admin

## Tech Stack
- Framework: Laravel 11
- Admin Panel: Filament v3
- Database: MySQL / MariaDB
- Language: PHP 8.2+
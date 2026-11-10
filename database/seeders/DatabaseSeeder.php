<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator UKK',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Siswa
        User::create([
            'name' => 'Siswa Contoh',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        // 3. Buat Data Buku Sample
        Book::create([
            'title' => 'Pemrograman Web dengan Laravel',
            'author' => 'Budi Santoso',
            'publisher' => 'Informatika',
            'publication_year' => '2024',
            'isbn' => '978-602-0001',
            'stock' => 5,
        ]);

        Book::create([
            'title' => 'Panduan Database MySQL untuk Pemula',
            'author' => 'Eko Kurniawan',
            'publisher' => 'Andi Publisher',
            'publication_year' => '2023',
            'isbn' => '978-602-0002',
            'stock' => 3,
        ]);

        Book::create([
            'title' => 'Harry Potter',
            'author' => 'JK. Rowling',
            'publisher' => 'GRAMEDIA',
            'publication_year' => '1997',
            'isbn' => '0098372',
            'stock' => 2,
        ]);
    }
}
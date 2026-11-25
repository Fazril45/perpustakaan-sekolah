<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Petugas
        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@sekolah.test',
            'password' => Hash::make('password123'),
        ]);

        // 2. Minimal 5 Kategori
        $kategoriList = ['Pemrograman', 'Fiksi & Novel', 'Sains & Teknologi', 'Sejarah', 'Ekonomi & Bisnis'];
        foreach ($kategoriList as $nama) {
            Kategori::create(['nama' => $nama]);
        }

        // 3. Minimal 20 Buku (beberapa stok 0)
        $daftarBuku = [
            ['Pemrograman Web Laravel Dasar', 'Budi Raharjo', 'Informatika'],
            ['Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka'],
            ['Fisika Dasar untuk SMK', 'Marthen Kanginan', 'Erlangga'],
            ['Sejarah Nusantara Lengkap', 'M.C. Ricklefs', 'Serambi'],
            ['Pengantar Ekonomi Mikro', 'Sadono Sukirno', 'Rajawali Pers'],
            ['Belajar Cepat Kotlin & Android', 'Nazruddin Safaat', 'Informatika'],
            ['Bumi Manusia', 'Pramoedya Ananta Toer', 'Lentera Dipantara'],
            ['Algoritma dan Struktur Data', 'Rinaldi Munir', 'Informatika'],
            ['Revolusi Industri 4.0', 'Klaus Schwab', 'Gramedia'],
            ['Manajemen Keuangan Modern', 'Suad Husnan', 'UPP STIM YKPN'],
            ['Mastering PHP 8 & MySQL', 'Abdul Kadir', 'Andi Offset'],
            ['Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia'],
            ['Jaringan Komputer & Mikrotik', 'Iwan Sofana', 'Informatika'],
            ['Jejak Langkah Perjuangan', 'Sartono Kartodirdjo', 'Ombak'],
            ['Kewirausahaan Era Digital', 'Rhenald Kasali', 'Gramedia'],
            ['Basis Data Relasional', 'Fathansyah', 'Informatika'],
            ['Pulang', 'Tere Liye', 'Republika'],
            ['Kecerdasan Buatan Praktis', 'Suyanto', 'Informatika'],
            ['Arsitektur Komputer Modern', 'Andrew S. Tanenbaum', 'Andi Offset'],
            ['Akuntansi Dasar Perusahaan', 'Hery', 'Grasindo'],
        ];

        foreach ($daftarBuku as $index => $item) {
            $i = $index + 1;
            Buku::create([
                'kategori_id' => ($index % 5) + 1,
                'kode_buku' => 'BK-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'judul' => $item[0],
                'penulis' => $item[1],
                'penerbit' => $item[2],
                'tahun_terbit' => 2019 + ($i % 7),
                'stok' => in_array($i, [3, 10, 17]) ? 0 : rand(2, 8),
            ]);
        }

        // 4. Minimal 10 Anggota (nama orang asli, urutan ke-10 nonaktif)
        $namaAnggota = [
            'Bimo Prakoso',
            'Satria Nugraha',
            'Dimas Saputra',
            'Edo Kurniawan',
            'Fajar Ramadhan',
            'Gani Setiawan',
            'Tiara Maharani',
            'Dafa Alfarizi',
            'Jelita Putri',
            'Syahrul Gunawan', // indeks ke-10 (nonaktif)
        ];

        foreach ($namaAnggota as $index => $nama) {
            $i = $index + 1;
            Anggota::create([
                'nis' => '202600' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nama' => $nama,
                'kelas' => $i <= 5 ? 'XI RPL 1' : 'XI RPL 2',
                'no_hp' => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'status' => $i === 10 ? 'nonaktif' : 'aktif',
            ]);
        }

        // 5. Minimal 8 Peminjaman (kondisi campuran)
        $today = Carbon::today();

        // Sedang dipinjam (normal)
        Peminjaman::create(['anggota_id' => 1, 'buku_id' => 1, 'tgl_pinjam' => $today->copy()->subDays(2), 'tgl_jatuh_tempo' => $today->copy()->addDays(5), 'status' => 'dipinjam', 'denda' => 0]);
        Peminjaman::create(['anggota_id' => 2, 'buku_id' => 2, 'tgl_pinjam' => $today->copy()->subDays(1), 'tgl_jatuh_tempo' => $today->copy()->addDays(6), 'status' => 'dipinjam', 'denda' => 0]);

        // Dikembalikan tepat waktu
        Peminjaman::create(['anggota_id' => 3, 'buku_id' => 4, 'tgl_pinjam' => $today->copy()->subDays(10), 'tgl_jatuh_tempo' => $today->copy()->subDays(3), 'tgl_kembali' => $today->copy()->subDays(4), 'status' => 'dikembalikan', 'denda' => 0]);
        Peminjaman::create(['anggota_id' => 4, 'buku_id' => 5, 'tgl_pinjam' => $today->copy()->subDays(8), 'tgl_jatuh_tempo' => $today->copy()->subDays(1), 'tgl_kembali' => $today->copy()->subDays(1), 'status' => 'dikembalikan', 'denda' => 0]);

        // Dikembalikan terlambat (denda > 0)
        Peminjaman::create(['anggota_id' => 5, 'buku_id' => 6, 'tgl_pinjam' => $today->copy()->subDays(15), 'tgl_jatuh_tempo' => $today->copy()->subDays(8), 'tgl_kembali' => $today->copy()->subDays(5), 'status' => 'dikembalikan', 'denda' => 3000]);
        Peminjaman::create(['anggota_id' => 6, 'buku_id' => 7, 'tgl_pinjam' => $today->copy()->subDays(12), 'tgl_jatuh_tempo' => $today->copy()->subDays(5), 'tgl_kembali' => $today->copy()->subDays(3), 'status' => 'dikembalikan', 'denda' => 2000]);

        // Sedang dipinjam & sudah lewat jatuh tempo (terlambat)
        Peminjaman::create(['anggota_id' => 7, 'buku_id' => 8, 'tgl_pinjam' => $today->copy()->subDays(10), 'tgl_jatuh_tempo' => $today->copy()->subDays(3), 'status' => 'dipinjam', 'denda' => 0]);
        Peminjaman::create(['anggota_id' => 8, 'buku_id' => 9, 'tgl_pinjam' => $today->copy()->subDays(9), 'tgl_jatuh_tempo' => $today->copy()->subDays(2), 'status' => 'dipinjam', 'denda' => 0]);
    }
}
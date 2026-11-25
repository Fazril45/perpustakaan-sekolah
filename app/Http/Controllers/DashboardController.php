<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalBuku = Buku::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tgl_jatuh_tempo', '<', $today)
            ->count();

        // Hitung total denda bulan ini
        $totalDendaBulanIni = Peminjaman::where('status', 'dikembalikan')
            ->whereMonth('tgl_kembali', $today->month)
            ->whereYear('tgl_kembali', $today->year)
            ->sum('denda');

        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        $bukuTerlaris = Buku::with('kategori')
            ->withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'anggotaAktif',
            'sedangDipinjam',
            'terlambat',
            'totalDendaBulanIni',
            'peminjamanTerbaru',
            'bukuTerlaris'
        ));
    }
}
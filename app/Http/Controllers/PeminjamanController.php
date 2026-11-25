<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->q;
                $query->whereHas('anggota', function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request, $today) {
                if ($request->status === 'terlambat') {
                    $query->where('status', 'dipinjam')
                        ->whereDate('tgl_jatuh_tempo', '<', $today);
                } else {
                    $query->where('status', $request->status);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggotaList = Anggota::orderBy('nama')->get();
        $bukuList = Buku::orderBy('judul')->get();

        return view('admin.peminjaman.create', compact('anggotaList', 'bukuList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => ['required', 'exists:anggota,id'],
            'buku_id'    => ['required', 'exists:buku,id'],
        ], [
            'anggota_id.required' => 'Anggota wajib dipilih.',
            'buku_id.required'    => 'Buku wajib dipilih.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $anggota = Anggota::lockForUpdate()->findOrFail($request->anggota_id);
                $buku = Buku::lockForUpdate()->findOrFail($request->buku_id);

                // 1. Cek status anggota aktif
                if ($anggota->status !== 'aktif') {
                    throw new \RuntimeException("Anggota \"{$anggota->nama}\" berstatus nonaktif dan tidak dapat meminjam buku.");
                }

                // 2. Cek stok buku > 0
                if ($buku->stok <= 0) {
                    throw new \RuntimeException("Stok buku \"{$buku->judul}\" habis (0).");
                }

                // 3. Cek maksimal 3 pinjaman aktif per anggota
                $pinjamanAktif = Peminjaman::where('anggota_id', $anggota->id)
                    ->where('status', 'dipinjam')
                    ->count();

                if ($pinjamanAktif >= 3) {
                    throw new \RuntimeException("Anggota \"{$anggota->nama}\" sudah mencapai batas maksimal 3 pinjaman aktif.");
                }

                // 4. Cek tidak boleh meminjam judul buku yang sama yang belum dikembalikan
                $sudahPinjamBukuSama = Peminjaman::where('anggota_id', $anggota->id)
                    ->where('buku_id', $buku->id)
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($sudahPinjamBukuSama) {
                    throw new \RuntimeException("Anggota \"{$anggota->nama}\" masih meminjam buku \"{$buku->judul}\" yang belum dikembalikan.");
                }

                // Simpan transaksi & kurangi stok
                $today = Carbon::today();
                Peminjaman::create([
                    'anggota_id'      => $anggota->id,
                    'buku_id'         => $buku->id,
                    'tgl_pinjam'      => $today,
                    'tgl_jatuh_tempo' => $today->copy()->addDays(7),
                    'status'          => 'dipinjam',
                    'denda'           => 0,
                ]);

                $buku->decrement('stok', 1);
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('galat', $e->getMessage());
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('sukses', 'Transaksi peminjaman berhasil dicatat.');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('galat', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($peminjaman) {
            $today = Carbon::today();
            $jatuhTempo = Carbon::parse($peminjaman->tgl_jatuh_tempo)->startOfDay();

            $hariTerlambat = $today->gt($jatuhTempo) ? $jatuhTempo->diffInDays($today) : 0;
            $denda = $hariTerlambat * 1000;

            $peminjaman->update([
                'tgl_kembali' => $today,
                'status'      => 'dikembalikan',
                'denda'       => $denda,
            ]);

            $peminjaman->buku()->lockForUpdate()->first()->increment('stok', 1);
        });

        return redirect()->route('admin.peminjaman.index')
            ->with('sukses', 'Buku berhasil dikembalikan.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = Kategori::orderBy('nama')->get();

        $buku = Buku::with('kategori')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->q;
                $query->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('penulis', 'like', "%{$q}%")
                        ->orWhere('kode_buku', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori);
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('katalog.index', compact('buku', 'kategoriList'));
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('katalog.show', compact('buku'));
    }
}
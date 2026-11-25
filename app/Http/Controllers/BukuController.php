<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->paginate(10);
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        $kategoriList = Kategori::orderBy('nama')->get();
        return view('admin.buku.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id'  => ['required', 'exists:kategori,id'],
            'kode_buku'    => ['required', 'string', 'max:20', 'unique:buku,kode_buku'],
            'judul'        => ['required', 'string', 'max:200'],
            'penulis'      => ['required', 'string', 'max:255'],
            'penerbit'     => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'digits:4', 'integer', 'lte:' . date('Y')],
            'stok'         => ['required', 'integer', 'min:0'],
            'sampul'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'kode_buku.required'    => 'Kode buku wajib diisi.',
            'kode_buku.unique'      => 'Kode buku sudah digunakan.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'penulis.required'      => 'Penulis wajib diisi.',
            'penerbit.required'     => 'Penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits'   => 'Tahun terbit harus 4 digit.',
            'tahun_terbit.lte'      => 'Tahun terbit tidak boleh melebihi tahun ' . date('Y') . '.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.min'              => 'Stok minimal 0.',
            'sampul.image'          => 'File sampul harus berupa gambar.',
            'sampul.mimes'          => 'Format sampul harus JPG atau PNG.',
            'sampul.max'            => 'Ukuran sampul maksimal 2 MB.',
        ]);

        if ($request->hasFile('sampul')) {
            $data['sampul'] = $request->file('sampul')->store('sampul', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
            ->with('sukses', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoriList = Kategori::orderBy('nama')->get();
        return view('admin.buku.edit', compact('buku', 'kategoriList'));
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'kategori_id'  => ['required', 'exists:kategori,id'],
            'kode_buku'    => ['required', 'string', 'max:20', Rule::unique('buku', 'kode_buku')->ignore($buku->id)],
            'judul'        => ['required', 'string', 'max:200'],
            'penulis'      => ['required', 'string', 'max:255'],
            'penerbit'     => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'digits:4', 'integer', 'lte:' . date('Y')],
            'stok'         => ['required', 'integer', 'min:0'],
            'sampul'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'kode_buku.required'    => 'Kode buku wajib diisi.',
            'kode_buku.unique'      => 'Kode buku sudah digunakan buku lain.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'penulis.required'      => 'Penulis wajib diisi.',
            'penerbit.required'     => 'Penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits'   => 'Tahun terbit harus 4 digit.',
            'tahun_terbit.lte'      => 'Tahun terbit tidak boleh melebihi tahun ' . date('Y') . '.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.min'              => 'Stok minimal 0.',
            'sampul.image'          => 'File sampul harus berupa gambar.',
            'sampul.mimes'          => 'Format sampul harus JPG atau PNG.',
            'sampul.max'            => 'Ukuran sampul maksimal 2 MB.',
        ]);

        if ($request->hasFile('sampul')) {
            if ($buku->sampul) {
                Storage::disk('public')->delete($buku->sampul);
            }
            $data['sampul'] = $request->file('sampul')->store('sampul', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
            ->with('sukses', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjaman()->exists()) {
            return back()->with('galat', "Buku \"{$buku->judul}\" tidak dapat dihapus karena memiliki riwayat peminjaman.");
        }

        if ($buku->sampul) {
            Storage::disk('public')->delete($buku->sampul);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('sukses', 'Buku berhasil dihapus.');
    }
}
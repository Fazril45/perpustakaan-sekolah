<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::latest()->paginate(10);
        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis'    => ['required', 'string', 'max:20', 'unique:anggota,nis'],
            'nama'   => ['required', 'string', 'max:255'],
            'kelas'  => ['required', 'string', 'max:50'],
            'no_hp'  => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], [
            'nis.required'    => 'NIS wajib diisi.',
            'nis.unique'      => 'NIS sudah terdaftar.',
            'nama.required'   => 'Nama anggota wajib diisi.',
            'kelas.required'  => 'Kelas wajib diisi.',
            'no_hp.required'  => 'Nomor HP wajib diisi.',
            'no_hp.regex'     => 'Format nomor HP harus diawali 08 dan terdiri dari 10–13 digit angka.',
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status harus aktif atau nonaktif.',
        ]);

        Anggota::create($data);

        return redirect()->route('admin.anggota.index')
            ->with('sukses', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Anggota $anggota)
    {
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $data = $request->validate([
            'nis'    => ['required', 'string', 'max:20', Rule::unique('anggota', 'nis')->ignore($anggota->id)],
            'nama'   => ['required', 'string', 'max:255'],
            'kelas'  => ['required', 'string', 'max:50'],
            'no_hp'  => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], [
            'nis.required'    => 'NIS wajib diisi.',
            'nis.unique'      => 'NIS sudah digunakan anggota lain.',
            'nama.required'   => 'Nama anggota wajib diisi.',
            'kelas.required'  => 'Kelas wajib diisi.',
            'no_hp.required'  => 'Nomor HP wajib diisi.',
            'no_hp.regex'     => 'Format nomor HP harus diawali 08 dan terdiri dari 10–13 digit angka.',
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status harus aktif atau nonaktif.',
        ]);

        $anggota->update($data);

        return redirect()->route('admin.anggota.index')
            ->with('sukses', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->peminjaman()->exists()) {
            return back()->with('galat', "Anggota \"{$anggota->nama}\" tidak dapat dihapus karena memiliki riwayat peminjaman.");
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')
            ->with('sukses', 'Anggota berhasil dihapus.');
    }
}
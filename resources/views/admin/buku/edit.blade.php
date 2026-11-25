@extends('layouts.app')
@section('judul', 'Edit Buku')

@section('konten')
<a href="{{ route('admin.buku.index') }}" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $buku->kategori_id) == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode_buku" value="{{ old('kode_buku', $buku->kode_buku) }}" class="form-control @error('kode_buku') is-invalid @enderror" required>
                    @error('kode_buku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="form-control @error('judul') is-invalid @enderror" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="form-control @error('penulis') is-invalid @enderror" required>
                    @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-control @error('penerbit') is-invalid @enderror" required>
                    @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="form-control @error('tahun_terbit') is-invalid @enderror" required>
                    @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" min="0" class="form-control @error('stok') is-invalid @enderror" required>
                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ganti Sampul (opsional)</label>
                    @if ($buku->sampul)
                        <div class="mb-2"><img src="{{ asset('storage/' . $buku->sampul) }}" width="70" class="rounded"></div>
                    @endif
                    <input type="file" name="sampul" accept="image/jpeg,image/png" class="form-control @error('sampul') is-invalid @enderror">
                    @error('sampul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4"><i class="bi bi-save me-1"></i>Perbarui</button>
        </form>
    </div>
</div>
@endsection
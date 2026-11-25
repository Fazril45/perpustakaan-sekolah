@extends('layouts.app')
@section('judul', 'Tambah Kategori')

@section('konten')
<a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" required>
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Simpan</button>
        </form>
    </div>
</div>
@endsection
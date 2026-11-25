@extends('layouts.app')
@section('judul', 'Edit Anggota')

@section('konten')
<a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $anggota->nis) }}" class="form-control @error('nis') is-invalid @enderror" required>
                    @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $anggota->kelas) }}" class="form-control @error('kelas') is-invalid @enderror" required>
                    @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nomor HP (08xxxxxxxxxx)</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}" class="form-control @error('no_hp') is-invalid @enderror" required>
                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="aktif" {{ old('status', $anggota->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $anggota->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4"><i class="bi bi-save me-1"></i>Perbarui</button>
        </form>
    </div>
</div>
@endsection
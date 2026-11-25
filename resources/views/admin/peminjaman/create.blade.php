@extends('layouts.app')
@section('judul', 'Catat Peminjaman Baru')

@section('konten')
<a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

<div class="alert alert-info border-0 shadow-sm">
    <i class="bi bi-info-circle me-2"></i>
    Tanggal pinjam otomatis hari ini (<strong>{{ date('d-m-Y') }}</strong>) dan jatuh tempo +7 hari (<strong>{{ date('d-m-Y', strtotime('+7 days')) }}</strong>).
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <form action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih Anggota</label>
                <select name="anggota_id" class="form-select @error('anggota_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach ($anggotaList as $a)
                        <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->nis }} - {{ $a->nama }} ({{ $a->kelas }}) [Status: {{ strtoupper($a->status) }}]
                        </option>
                    @endforeach
                </select>
                @error('anggota_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Pilih Buku</label>
                <select name="buku_id" class="form-select @error('buku_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach ($bukuList as $b)
                        <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                            [{{ $b->kode_buku }}] {{ $b->judul }} (Stok: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
                @error('buku_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Simpan Peminjaman</button>
        </form>
    </div>
</div>
@endsection
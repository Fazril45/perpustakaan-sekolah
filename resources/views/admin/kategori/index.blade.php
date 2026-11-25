@extends('layouts.app')
@section('judul', 'Kelola Kategori')

@section('aksiHeader')
<a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm text-nowrap"><i class="bi bi-plus-lg me-1"></i>Tambah Kategori</a>
@endsection

@section('konten')
<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Buku</th>
                    <th width="160" class="text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->buku_count }} buku</td>
                        <td class="text-nowrap">
                            <div class="d-flex align-items-center gap-1 text-nowrap">
                            <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square me-1"></i>Edit</a>
                            <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Hapus</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
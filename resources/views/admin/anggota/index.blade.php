@extends('layouts.app')
@section('judul', 'Kelola Anggota')

@section('aksiHeader')
<a href="{{ route('admin.anggota.create') }}" class="btn btn-primary btn-sm text-nowrap"><i class="bi bi-person-plus me-1"></i>Tambah Anggota</a>
@endsection

@section('konten')
<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>No. HP</th>
                    <th>Status</th>
                    <th width="160" class="text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $item)
                    <tr>
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>
                            @if ($item->status === 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex align-items-center gap-1 text-nowrap">
                            <a href="{{ route('admin.anggota.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square me-1"></i>Edit</a>
                            <form action="{{ route('admin.anggota.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Hapus</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $anggota->links() }}
@endsection
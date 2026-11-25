@extends('layouts.app')
@section('judul', 'Kelola Buku')

@section('aksiHeader')
<a href="{{ route('admin.buku.create') }}" class="btn btn-primary btn-sm text-nowrap"><i class="bi bi-plus-lg me-1"></i>Tambah Buku</a>
@endsection

@section('konten')
<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Sampul</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th width="190" class="text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $item)
                    <tr>
                        <td>
                            @if ($item->sampul)
                                <img src="{{ asset('storage/' . $item->sampul) }}" alt="Sampul" width="45" class="rounded">
                            @else
                                @php
                                    $coverPalettes = [
                                        'Pemrograman' => ['background' => 'linear-gradient(145deg, #0F294A, #1E4388)', 'accent' => '#38BDF8'],
                                        'Fiksi & Novel' => ['background' => 'linear-gradient(145deg, #5B1A2A, #8B263E)', 'accent' => '#F6AD55'],
                                        'Sains & Teknologi' => ['background' => 'linear-gradient(145deg, #134E4A, #0F766E)', 'accent' => '#5EEAD4'],
                                        'Sejarah' => ['background' => 'linear-gradient(145deg, #442C1E, #78350F)', 'accent' => '#FCD34D'],
                                        'Ekonomi & Bisnis' => ['background' => 'linear-gradient(145deg, #1E293B, #334155)', 'accent' => '#93C5FD'],
                                    ];
                                    $coverPalette = $coverPalettes[$item->kategori->nama] ?? ['background' => 'linear-gradient(145deg, #1E4388, #244B96)', 'accent' => '#93C5FD'];
                                @endphp
                                <div class="position-relative d-flex align-items-center justify-content-center text-white rounded-1 overflow-hidden" style="width: 45px; height: 62px; background: {{ $coverPalette['background'] }}; box-shadow: 0 3px 7px rgba(0,0,0,.16);">
                                    <span aria-hidden="true" style="position: absolute; inset: 0 auto 0 0; width: 4px; background: rgba(0,0,0,.24); box-shadow: 1px 0 3px rgba(0,0,0,.28);"></span>
                                    <span class="position-relative text-center" style="z-index: 1; padding: 2px; font-size: .48rem; line-height: 1.1; overflow-wrap: anywhere;">{{ $item->kode_buku }}</span>
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->kode_buku }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori->nama }}</td>
                        <td>{{ $item->penulis }}</td>
                        <td>{{ $item->tahun_terbit }}</td>
                        <td>{{ $item->stok }}</td>
                        <td class="text-nowrap">
                            <div class="d-flex align-items-center gap-1 text-nowrap">
                            <a href="{{ route('admin.buku.show', $item->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye me-1"></i>Detail</a>
                            <a href="{{ route('admin.buku.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square me-1"></i>Edit</a>
                            <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Hapus</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $buku->links() }}
@endsection
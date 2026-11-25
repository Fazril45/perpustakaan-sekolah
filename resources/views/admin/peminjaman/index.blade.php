@extends('layouts.app')
@section('judul', 'Riwayat & Transaksi Peminjaman')

@section('aksiHeader')
<a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary btn-sm text-nowrap"><i class="bi bi-plus-lg me-1"></i>Catat Peminjaman Baru</a>
@endsection

@section('konten')
<form action="{{ route('admin.peminjaman.index') }}" method="GET" class="row g-2 mb-3">
    <div class="col-md-5">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama anggota...">
    </div>
    <div class="col-md-4">
        <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-funnel me-1"></i>Filter</button>
        @if (request()->hasAny(['q', 'status']))
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th class="text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $index => $item)
                    @php
                        $isTerlambat = $item->status === 'dipinjam' && $item->tgl_jatuh_tempo->isPast() && !$item->tgl_jatuh_tempo->isToday();
                    @endphp
                    <tr>
                        <td>{{ $peminjaman->firstItem() + $index }}</td>
                        <td>{{ $item->anggota->nama }} <small class="text-muted">({{ $item->anggota->kelas }})</small></td>
                        <td>[{{ $item->buku->kode_buku }}] {{ $item->buku->judul }}</td>
                        <td>{{ $item->tgl_pinjam->format('d-m-Y') }}</td>
                        <td>{{ $item->tgl_jatuh_tempo->format('d-m-Y') }}</td>
                        <td>{{ $item->tgl_kembali ? $item->tgl_kembali->format('d-m-Y') : '-' }}</td>
                        <td>
                            @if ($item->status === 'dikembalikan')
                                <span class="badge bg-success">Dikembalikan</span>
                            @elseif ($isTerlambat)
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @endif
                        </td>
                        <td>Rp{{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td class="text-nowrap">
                            <div class="d-flex align-items-center gap-1 text-nowrap">
                            @if ($item->status === 'dipinjam')
                                <form action="{{ route('admin.peminjaman.kembalikan', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check2 me-1"></i>Kembalikan</button>
                                </form>
                            @else
                                <span class="text-muted small">Selesai</span>
                            @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $peminjaman->links() }}
@endsection
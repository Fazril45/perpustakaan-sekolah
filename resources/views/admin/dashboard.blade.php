@extends('layouts.app')
@section('judul', 'Dashboard Petugas')

@section('konten')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg">
        <div class="card bg-white border-0 shadow-sm rounded-3 border-start border-4 border-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-secondary">Total Judul Buku</div>
                        <h3 class="text-dark mb-0 mt-1">{{ $totalBuku }}</h3>
                    </div>
                    <span class="rounded-3 bg-primary-subtle text-primary p-3"><i class="bi bi-journal-bookmark fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg">
        <div class="card bg-white border-0 shadow-sm rounded-3 border-start border-4 border-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-secondary">Anggota Aktif</div>
                        <h3 class="text-dark mb-0 mt-1">{{ $anggotaAktif }}</h3>
                    </div>
                    <span class="rounded-3 bg-success-subtle text-success p-3"><i class="bi bi-people fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg">
        <div class="card bg-white border-0 shadow-sm rounded-3 border-start border-4 border-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-secondary">Sedang Dipinjam</div>
                        <h3 class="text-dark mb-0 mt-1">{{ $sedangDipinjam }}</h3>
                    </div>
                    <span class="rounded-3 bg-warning-subtle text-warning p-3"><i class="bi bi-arrow-left-right fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-lg">
        <div class="card bg-white border-0 shadow-sm rounded-3 border-start border-4 border-danger h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-secondary">Peminjaman Terlambat</div>
                        <h3 class="text-dark mb-0 mt-1">{{ $terlambat }}</h3>
                    </div>
                    <span class="rounded-3 bg-danger-subtle text-danger p-3"><i class="bi bi-clock-history fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg">
        <div class="card bg-white border-0 shadow-sm rounded-3 border-start border-4 border-info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-secondary">Total Denda Bulan Ini</div>
                        <h4 class="text-dark fw-bold mb-0 mt-1">Rp{{ number_format($totalDendaBulanIni, 0, ',', '.') }}</h4>
                    </div>
                    <span class="rounded-3 bg-info-subtle text-info p-3"><i class="bi bi-cash-coin fs-4"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
    <div class="card-header fw-bold"><i class="bi bi-clock-history me-2"></i>5 Peminjaman Terbaru</div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>Tanggal Pinjam</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamanTerbaru as $p)
                    <tr>
                        <td>{{ $p->tgl_pinjam->format('d-m-Y') }}</td>
                        <td>{{ $p->anggota->nama }}</td>
                        <td>{{ $p->buku->judul }}</td>
                        <td>{{ $p->tgl_jatuh_tempo->format('d-m-Y') }}</td>
                        <td>
                            @if ($p->status === 'dikembalikan')
                                <span class="badge bg-success">Dikembalikan</span>
                            @elseif ($p->tgl_jatuh_tempo->isPast() && !$p->tgl_jatuh_tempo->isToday())
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-header fw-bold"><i class="bi bi-stars me-2"></i>5 Buku Paling Sering Dipinjam</div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Total Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukuTerlaris as $b)
                    <tr>
                        <td>{{ $b->kode_buku }}</td>
                        <td>{{ $b->judul }}</td>
                        <td>{{ $b->kategori->nama }}</td>
                        <td><span class="badge bg-secondary">{{ $b->peminjaman_count }} kali</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
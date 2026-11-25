@extends('layouts.app')
@section('judul', 'Detail Buku')

@section('konten')
<a href="{{ route('katalog') }}" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Kembali ke Katalog</a>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center mb-3 mb-md-0">
                @if ($buku->sampul)
                    <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="img-fluid rounded" style="max-height: 320px;">
                @else
                    @php
                        $coverPalettes = [
                            'Pemrograman' => ['background' => 'linear-gradient(145deg, #0F294A, #1E4388)', 'accent' => '#38BDF8'],
                            'Fiksi & Novel' => ['background' => 'linear-gradient(145deg, #5B1A2A, #8B263E)', 'accent' => '#F6AD55'],
                            'Sains & Teknologi' => ['background' => 'linear-gradient(145deg, #134E4A, #0F766E)', 'accent' => '#5EEAD4'],
                            'Sejarah' => ['background' => 'linear-gradient(145deg, #442C1E, #78350F)', 'accent' => '#FCD34D'],
                            'Ekonomi & Bisnis' => ['background' => 'linear-gradient(145deg, #1E293B, #334155)', 'accent' => '#93C5FD'],
                        ];
                        $coverPalette = $coverPalettes[$buku->kategori->nama] ?? ['background' => 'linear-gradient(145deg, #1E4388, #244B96)', 'accent' => '#93C5FD'];
                    @endphp
                    <div class="position-relative text-white text-start rounded-2 overflow-hidden" style="height: 320px; max-width: 230px; width: 100%; margin: 0 auto; padding: 24px 20px 18px 30px; display: flex; flex-direction: column; background: {{ $coverPalette['background'] }}; box-shadow: 0 10px 20px rgba(0,0,0,0.15);">
                        <span aria-hidden="true" style="position: absolute; inset: 0 auto 0 0; width: 10px; background: rgba(0,0,0,.2); box-shadow: 2px 0 5px rgba(0,0,0,.28);"></span>
                        <span aria-hidden="true" style="position: absolute; inset: 10px; border: 1px solid rgba(255,255,255,.28); pointer-events: none;"></span>
                        <div class="position-relative h-100 d-flex flex-column" style="z-index: 1;">
                            <div class="d-flex justify-content-between gap-2 text-uppercase" style="font-size: .62rem; letter-spacing: 1px;">
                                <span class="text-truncate">{{ $buku->kategori->nama }}</span>
                                <span class="text-nowrap">{{ $buku->kode_buku }}</span>
                            </div>
                            <span aria-hidden="true" style="width: 42px; height: 2px; margin-top: 18px; background: {{ $coverPalette['accent'] }};"></span>
                            <h2 class="text-white my-auto" style="font-family: Georgia, 'Times New Roman', serif; font-weight: 700; font-size: 1.55rem; line-height: 1.2; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ $buku->judul }}</h2>
                            <span aria-hidden="true" style="width: 56px; height: 1px; margin-bottom: 10px; background: {{ $coverPalette['accent'] }};"></span>
                            <div class="text-truncate" style="border-top: 1px solid rgba(255,255,255,.28); padding-top: 10px; font-size: .78rem;">{{ $buku->penulis }}</div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <span class="badge bg-primary mb-2">{{ $buku->kategori->nama }}</span>
                <h3 class="fw-bold text-primary">{{ $buku->judul }}</h3>
                <table class="table table-bordered table-hover mt-3">
                    <tr><th width="30%">Kode Buku</th><td>{{ $buku->kode_buku }}</td></tr>
                    <tr><th>Penulis</th><td>{{ $buku->penulis }}</td></tr>
                    <tr><th>Penerbit</th><td>{{ $buku->penerbit }}</td></tr>
                    <tr><th>Tahun Terbit</th><td>{{ $buku->tahun_terbit }}</td></tr>
                    <tr>
                        <th>Status Stok</th>
                        <td>
                            @if ($buku->stok > 0)
                                <span class="badge bg-success">Tersedia ({{ $buku->stok }} eksemplar)</span>
                            @else
                                <span class="badge bg-danger">Sedang dipinjam semua</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('judul', 'Katalog Buku Perpustakaan')

@section('konten')
<section class="catalog-hero d-flex align-items-center">
    <div class="container text-white py-5">
        <span class="text-uppercase fw-bold small" style="letter-spacing: .18em;">Portal Literasi Sekolah</span>
        <h1 class="display-5 fw-bold mt-2 mb-3">Temukan Pengetahuan,<br>Mulai dari Perpustakaan.</h1>
        <p class="mb-0 text-white-50">Jelajahi koleksi buku pilihan untuk mendukung perjalanan belajar Anda.</p>
    </div>
</section>

<div class="container">
    <div class="card catalog-search rounded-3 mb-5">
        <div class="card-body p-4 p-lg-5">
            <div class="small text-primary fw-bold text-uppercase mb-3" style="letter-spacing: .12em;">Cari Daftar Buku</div>
            <form action="{{ route('katalog') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-lg-5">
                    <label class="form-label small fw-semibold">Judul, penulis, atau kode buku</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-primary"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Contoh: Sejarah Indonesia">
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label small fw-semibold">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-search me-2"></i>Telusuri</button>
                    @if (request()->hasAny(['q', 'kategori']))
                        <a href="{{ route('katalog') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <section class="pb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 border-bottom pb-3 mb-4">
            <div>
                <h2 class="catalog-section-title fw-bold mb-1">KOLEKSI PUSTAKA <span class="fw-normal">UNTUK ANDA</span></h2>
                <p class="text-secondary mb-0">Bacaan bermakna untuk menambah wawasan dan menginspirasi.</p>
            </div>
            <span class="small text-secondary"><i class="bi bi-journals me-1"></i>Koleksi perpustakaan</span>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-4">
            @forelse ($buku as $item)
                <div class="col">
                    <div class="card catalog-book-card h-100 shadow-sm">
                        @if ($item->sampul)
                            <img src="{{ asset('storage/' . $item->sampul) }}" class="card-img-top catalog-cover" alt="{{ $item->judul }}">
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
                            <div class="position-relative text-white rounded-2 overflow-hidden" style="height: 230px; max-width: 230px; width: 100%; margin: 0 auto; padding: 18px 16px 14px 24px; display: flex; flex-direction: column; background: {{ $coverPalette['background'] }}; box-shadow: 0 10px 20px rgba(0,0,0,0.15);">
                                <span aria-hidden="true" style="position: absolute; inset: 0 auto 0 0; width: 10px; background: rgba(0,0,0,.2); box-shadow: 2px 0 5px rgba(0,0,0,.28);"></span>
                                <span aria-hidden="true" style="position: absolute; inset: 8px; border: 1px solid rgba(255,255,255,.28); pointer-events: none;"></span>
                                <div class="position-relative h-100 d-flex flex-column" style="z-index: 1;">
                                    <div class="d-flex justify-content-between gap-2 text-uppercase" style="font-size: .52rem; letter-spacing: 1px;">
                                        <span class="text-truncate">{{ $item->kategori->nama }}</span>
                                        <span class="text-nowrap">{{ $item->kode_buku }}</span>
                                    </div>
                                    <span aria-hidden="true" style="width: 34px; height: 2px; margin-top: 12px; background: {{ $coverPalette['accent'] }};"></span>
                                    <h5 class="text-white my-auto" style="font-family: Georgia, 'Times New Roman', serif; font-weight: 700; font-size: 1.15rem; line-height: 1.2; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ $item->judul }}</h5>
                                    <span aria-hidden="true" style="width: 44px; height: 1px; margin-bottom: 8px; background: {{ $coverPalette['accent'] }};"></span>
                                    <div class="text-truncate" style="border-top: 1px solid rgba(255,255,255,.28); padding-top: 8px; font-size: .68rem;">{{ $item->penulis }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column p-3">
                            <span class="badge bg-primary align-self-start mb-2">{{ $item->kategori->nama }}</span>
                            <h6 class="card-title fw-bold mb-1">{{ $item->judul }}</h6>
                            <p class="text-secondary small mb-3"><i class="bi bi-person me-1"></i>{{ $item->penulis }} <span class="text-muted">({{ $item->kode_buku }})</span></p>

                            <div class="mt-auto">
                                @if ($item->stok > 0)
                                    <span class="badge bg-success mb-2"><i class="bi bi-check-circle me-1"></i>Stok: {{ $item->stok }}</span>
                                @else
                                    <span class="badge bg-danger mb-2"><i class="bi bi-x-circle me-1"></i>Sedang dipinjam semua</span>
                                @endif
                                <a href="{{ route('katalog.show', $item->id) }}" class="btn btn-outline-primary btn-sm w-100"><i class="bi bi-arrow-right-circle me-1"></i>Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center"><i class="bi bi-info-circle me-2"></i>Belum ada data</div>
                </div>
            @endforelse
        </div>

        <div>{{ $buku->links() }}</div>
    </section>
</div>

<section class="service-ribbon py-5">
    <div class="container">
        <div class="text-center text-white mb-4">
            <span class="small text-uppercase fw-bold" style="letter-spacing: .15em;">Data Perpustakaan</span>
            <h2 class="fw-bold mt-2">Melayani Kebutuhan Literasi Anda</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4 service-item">
                <i class="bi bi-bookmark-star"></i>
                <h5 class="fw-bold mt-3">Koleksi Terkurasi</h5>
                <p class="small mb-0 text-white-50">Pilihan bacaan untuk berbagai bidang pengetahuan.</p>
            </div>
            <div class="col-md-4 service-item">
                <i class="bi bi-globe2"></i>
                <h5 class="fw-bold mt-3">Akses Katalog Online</h5>
                <p class="small mb-0 text-white-50">Temukan buku favorit kapan saja dan di mana saja.</p>
            </div>
            <div class="col-md-4 service-item">
                <i class="bi bi-arrow-left-right"></i>
                <h5 class="fw-bold mt-3">Sirkulasi Cepat</h5>
                <p class="small mb-0 text-white-50">Layanan peminjaman dan pengembalian yang mudah.</p>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
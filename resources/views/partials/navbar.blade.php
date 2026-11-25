<nav class="navbar navbar-expand-lg navbar-dark navbar-academic">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('katalog') }}">
            <i class="bi bi-book-half fs-4"></i>
            <span>PERPUSTAKAAN SEKOLAH</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('katalog*') ? 'active' : '' }}" href="{{ route('katalog') }}">Katalog</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}" href="{{ route('admin.buku.index') }}">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}" href="{{ route('admin.anggota.index') }}">Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}" href="{{ route('admin.peminjaman.index') }}">Peminjaman</a>
                    </li>
                @endauth
            </ul>

            <div class="d-flex align-items-center text-white ms-lg-3 mt-3 mt-lg-0">
                @auth
                    <span class="me-3 small"><i class="bi bi-person-circle me-1"></i>Halo, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm"><i class="bi bi-person-lock me-1"></i>Login Petugas</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
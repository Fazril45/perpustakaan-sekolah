<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul') - Perpustakaan Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --academic-navy: #1E4388;
            --academic-blue: #2B6CB0;
            --academic-royal: #244B96;
            --academic-ink: #2D3748;
            --academic-muted: #718096;
            --academic-paper: #F4F6F9;
        }

        body {
            color: var(--academic-ink);
            background: var(--academic-paper);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .app-main { flex: 1; }
        .navbar-academic { background: var(--academic-navy); }
        .navbar-academic .navbar-brand { letter-spacing: .04em; }
        .navbar-academic .nav-link {
            color: rgba(255,255,255,.82);
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .055em;
            text-transform: uppercase;
        }
        .navbar-academic .nav-link:hover,
        .navbar-academic .nav-link.active { color: #fff; }
        .page-heading { color: var(--academic-navy); font-weight: 800; }
        .card {
            border: 1px solid #E2E8F0;
            border-radius: .85rem;
        }
        .card-header { background: #EDF2F7; color: var(--academic-navy); }
        .table thead th {
            color: #40516A;
            background: #EDF2F7;
            border-bottom-color: #D9E2EF;
            font-size: .8rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .table > :not(caption) > * > * { padding: .75rem 1rem; }
        .table-striped { --bs-table-striped-bg: rgba(30,67,136,.025); }
        .table-hover { --bs-table-hover-bg: rgba(30,67,136,.045); }
        .btn-primary {
            border-color: var(--academic-blue);
            background-color: var(--academic-blue);
        }
        .btn-primary:hover, .btn-primary:focus {
            border-color: var(--academic-navy);
            background-color: var(--academic-navy);
        }
        .form-control, .form-select { border-color: #CBD5E0; }
        .form-control:focus, .form-select:focus {
            border-color: #63A0DC;
            box-shadow: 0 0 0 .2rem rgba(49,130,206,.16);
        }
        .btn, .form-control, .form-select { border-radius: .55rem; }
        .academic-footer { background: #18356B; color: rgba(255,255,255,.82); }
        .academic-footer h5, .academic-footer a { color: #fff; }
        .academic-footer a { text-decoration: none; }
        .academic-footer a:hover { text-decoration: underline; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.16); }
        .catalog-hero {
            min-height: 360px;
            background:
                linear-gradient(90deg, rgba(15,35,69,.65), rgba(15,35,69,.22)),
                url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=2000&q=85') center 48% / cover;
        }
        .catalog-search {
            position: relative;
            z-index: 1;
            margin-top: -52px;
            border: 0;
            box-shadow: 0 16px 42px rgba(20,40,70,.15);
        }
        .catalog-section-title { color: var(--academic-navy); }
        .catalog-book-card {
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .catalog-book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(30,67,136,.13) !important;
        }
        .catalog-cover { height: 220px; object-fit: cover; }
        .cover-placeholder { height: 220px; background: #E2E8F0; color: #718096; }
        .service-ribbon { background: linear-gradient(135deg, #1A365D, #2B6CB0); }
        .service-ribbon .service-item { color: #fff; }
        .service-ribbon i { font-size: 2rem; }
        .login-panel { border-top: 4px solid var(--academic-blue); }
        @media (max-width: 767.98px) {
            .catalog-hero { min-height: 300px; }
            .catalog-search { margin-top: -36px; }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="app-main flex-grow-1">
        @if (request()->routeIs('katalog') && !request()->routeIs('katalog.show'))
            @include('partials.flash')
            @yield('konten')
        @else
            <div class="container py-4">
                @include('partials.flash')
                @if (View::hasSection('aksiHeader'))
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="page-heading mb-0">@yield('judul')</h2>
                        @yield('aksiHeader')
                    </div>
                @else
                    <h2 class="page-heading mb-4">@yield('judul')</h2>
                @endif
                @yield('konten')
            </div>
        @endif
    </main>

    <footer class="academic-footer mt-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-5">
                    <h5 class="fw-bold"><i class="bi bi-book-half me-2"></i>PERPUSTAKAAN SEKOLAH</h5>
                    <p class="mb-0 small">Ruang belajar, literasi, dan inspirasi bagi seluruh warga sekolah.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold">Jam Operasional</h6>
                    <p class="small mb-0">Senin–Jumat<br>07.00–15.00 WIB</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold">Navigasi Cepat</h6>
                    <div class="d-flex flex-column align-items-start gap-1 small">
                        <a href="{{ route('katalog') }}">Katalog Buku</a>
                        <a href="{{ route('login') }}">Login Petugas</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container py-3 small">© {{ date('Y') }} Perpustakaan Sekolah. Mendukung budaya membaca.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
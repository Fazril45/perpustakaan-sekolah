@extends('layouts.app')
@section('judul', 'Login Petugas')

@section('konten')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm login-panel">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="text-primary display-5"><i class="bi bi-person-lock"></i></div>
                    <h5 class="fw-bold text-primary mt-2">Portal Petugas</h5>
                    <p class="text-secondary small mb-0">Masuk untuk mengelola layanan perpustakaan.</p>
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="ingat" id="ingat" class="form-check-input">
                        <label class="form-check-label" for="ingat">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
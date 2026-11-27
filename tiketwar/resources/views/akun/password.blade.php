@extends('layouts.main')

@section('title', 'Ganti Kata Sandi')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">

            <div class="card-header">
                <h4 class="mb-0">Ganti Kata Sandi Admin</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('akun.password.update') }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Kata sandi saat ini --}}
                    <div class="mb-3">

                        <label for="current_password"
                               class="form-label">
                            Kata Sandi Saat Ini
                        </label>

                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            autocomplete="current-password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            required
                        >

                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Kata sandi baru --}}
                    <div class="mb-3">

                        <label for="password"
                               class="form-label">
                            Kata Sandi Baru
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="new-password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >

                        <div class="form-text">
                            Minimal 8 karakter.
                        </div>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Konfirmasi kata sandi baru --}}
                    <div class="mb-3">

                        <label for="password_confirmation"
                               class="form-label">
                            Konfirmasi Kata Sandi Baru
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            autocomplete="new-password"
                            class="form-control"
                            required
                        >

                    </div>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Kata Sandi
                    </button>

                    <a href="{{ route('pesanan.index') }}"
                       class="btn btn-secondary">
                        Batal
                    </a>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection
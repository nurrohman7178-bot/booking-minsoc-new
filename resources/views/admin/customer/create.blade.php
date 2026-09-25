@extends('layouts.admin.app')

@section('content')

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="mb-4">
            <h1 class="page-title mb-1">Create New Customer</h1>
            <span class="text-muted">
                Tambahkan data customer baru
            </span>
        </div>

        {{-- Form Customer --}}
        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <form action="{{ route('customer.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                {{-- Nama --}}
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="font-weight-bold">
                                        Nama Lengkap
                                    </label>

                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="font-weight-bold">
                                        Email
                                    </label>

                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Masukkan email" required>
                                </div>

                                {{-- No Telepon --}}
                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon" class="font-weight-bold">
                                        No. Telepon
                                    </label>

                                    <input type="tel" class="form-control" id="no_telepon" name="no_telepon"
                                        value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx" required>
                                </div>

                                {{-- Alamat --}}
                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="font-weight-bold">
                                        Alamat
                                    </label>

                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        value="{{ old('alamat') }}" placeholder="Masukkan alamat lengkap" required>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="font-weight-bold">
                                        Password
                                    </label>

                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Masukkan password" required>
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="font-weight-bold">
                                        Konfirmasi Password
                                    </label>

                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Ulangi password" required>
                                </div>

                            </div>

                            {{-- Error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger mt-2">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Tombol --}}
                            <div class="mt-3">
                                <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i>
                                    Tambah Customer
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

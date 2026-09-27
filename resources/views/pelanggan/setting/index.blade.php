@extends('layouts.pelanggan.app')

@section('content')
    <div class="container-fluid">

        <div class="mb-4">
            <h1 class="page-title mb-1">Setting Page</h1>
            <p class="text-muted mb-0">Kelola informasi akun dan data pribadi kamu.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user-cog mr-1"></i> Informasi Akun
                        </h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('setting.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="no_telepon">No. Telepon</label>
                                <input type="text" name="no_telepon" id="no_telepon"
                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                    value="{{ old('no_telepon', $pelanggan?->no_telepon) }}" required>
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3"
                                    class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $pelanggan?->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-user-circle fa-4x text-gray-300 mb-3"></i>
                        <h5 class="font-weight-bold text-gray-800 mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                        <span class="badge badge-primary mt-3">Pelanggan</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

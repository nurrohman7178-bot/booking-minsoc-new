@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <h1 class="page-title mb-1">Edit Customer</h1>
        <span class="text-muted d-block mb-4">Perbarui informasi customer sesuai kebutuhan.</span>


        <div class="card shadow">
            <div class="card-body">

                <form action="{{ route('customer.update', $customer->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $customer->user->name }}">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $customer->user->email }}">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="{{ $customer->no_telepon }}">
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ $customer->alamat }}</textarea>
                    </div>

                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>

                </form>

            </div>
        </div>

    </div>
@endsection

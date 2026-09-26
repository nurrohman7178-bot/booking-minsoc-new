@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Edit Customer</h1>
        <p class="text-muted mb-0">Perbarui informasi customer.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label>Nama Lengkap</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $customer->user->name) }}"
                               required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $customer->user->email) }}"
                               required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>No. Telepon</label>
                        <input type="text"
                               name="no_telepon"
                               class="form-control"
                               value="{{ old('no_telepon', $customer->no_telepon) }}"
                               required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Alamat</label>
                        <textarea name="alamat"
                                  class="form-control"
                                  rows="3"
                                  required>{{ old('alamat', $customer->alamat) }}</textarea>
                    </div>

                </div>

                <div class="mt-3">
                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

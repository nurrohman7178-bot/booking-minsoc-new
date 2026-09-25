@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <h1 class="page-title mb-1">Customer Detail</h1>
        <span class="text-muted d-block mb-4">Menampilkan informasi lengkap customer.</span>

        <div class="card shadow">
            <div class="card-body">

                <div class="mb-3">
                    <strong>Nama</strong>
                    <p>{{ $customer->user->name }}</p>
                </div>

                <div class="mb-3">
                    <strong>Email</strong>
                    <p>{{ $customer->user->email }}</p>
                </div>

                <div class="mb-3">
                    <strong>No. Telepon</strong>
                    <p>{{ $customer->no_telepon }}</p>
                </div>

                <div class="mb-3">
                    <strong>Alamat</strong>
                    <p>{{ $customer->alamat }}</p>
                </div>

                <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-primary">
                    Edit
                </a>

            </div>
        </div>

    </div>
@endsection

@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Detail Customer</h1>
        <p class="text-muted mb-0">Informasi customer yang dipilih.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">Nama</small>
                    <strong>{{ $customer->user?->name ?? '-' }}</strong>
                </div>

                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">Email</small>
                    <strong>{{ $customer->user?->email ?? '-' }}</strong>
                </div>

                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">No. Telepon</small>
                    <strong>{{ $customer->no_telepon ?: '-' }}</strong>
                </div>

                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">Alamat</small>
                    <strong>{{ $customer->alamat ?: '-' }}</strong>
                </div>
            </div>

            <div class="mt-2">
                <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit mr-1"></i>
                    Edit
                </a>
            </div>

        </div>
    </div>

</div>
@endsection

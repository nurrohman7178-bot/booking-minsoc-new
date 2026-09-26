@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Dashboard</h1>
            <p class="text-muted mb-0">Kelola data customer dan booking MiniSoccer.</p>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Customer
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $totalPelanggan }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Data Jadwal
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $totalBooking }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                                Status Sistem
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-success">
                                Aktif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        Ringkasan Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Gunakan menu di sebelah kiri untuk mengelola data aplikasi.
                    </p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('customer.index') }}" class="btn btn-light border btn-block text-left">
                                <i class="fas fa-users text-primary mr-2"></i>
                                Kelola Customer
                            </a>
                        </div>

                        <div class="col-md-6 mb-3">
                            <a href="{{ route('booking.index') }}" class="btn btn-light border btn-block text-left">
                                <i class="fas fa-calendar-check text-success mr-2"></i>
                                Kelola Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted mb-2">Login sebagai</div>
                    <div class="font-weight-bold mb-3">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="small text-muted mb-2">Email</div>
                    <div class="font-weight-bold">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

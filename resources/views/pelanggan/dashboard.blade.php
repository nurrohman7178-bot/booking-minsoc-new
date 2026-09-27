@extends('layouts.pelanggan.app')

@section('content')
    <div class="container-fluid">

        <div class="mb-4">
            <h1 class="page-title mb-1">Dashboard Page</h1>
            <p class="text-muted mb-0">Kelola booking lapangan kamu dengan mudah.</p>
        </div>

        <div class="row">
            {{-- Total Booking --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Booking Saya
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalBooking }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking Menunggu --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Booking Menunggu
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $bookingMenunggu }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jadwal Tersedia --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jadwal Tersedia
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $jadwalTersedia }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Booking</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Pilih jadwal lapangan yang masih tersedia untuk melakukan booking.</p>
                        <a href="{{ route('booking.index') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus mr-1"></i> Booking Lapangan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Menu Cepat</h6>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-outline-primary btn-block mb-2">
                            <i class="fas fa-history mr-1"></i> Lihat History
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-cog mr-1"></i> Pengaturan Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

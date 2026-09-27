@extends('layouts.pelanggan.app')

@section('content')
    <div class="container-fluid">

        <div class="mb-4">
            <h1 class="page-title mb-1">Dashboard Page</h1>
            <p class="text-muted mb-0">Kelola booking lapangan kamu dengan mudah.</p>
        </div>

        {{-- Card --}}
        <div class="row">

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">

                        <div class="row no-gutters align-items-center">

                            <div class="col mr-2">

                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Booking saya
                                </div>

                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalHistory }}
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
                                    Jadwal Tersedia
                                </div>

                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $jadwalTersedia }}
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
                                <i class="fas fa-check-circle fa-2x text-success"></i>
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
                        <a href="{{ route('pelanggan.booking') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus mr-1"></i> Booking Lapangan
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
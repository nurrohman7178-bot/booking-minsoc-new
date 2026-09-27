@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid dashboard-content">

        {{-- Judul --}}
        <div class="mb-4">
            <h1 class="page-title mb-0">Dashboard Page</h1>
            <p class="text-muted">
                Manage customers, bookings, and schedules.
            </p>
        </div>


        {{-- Card --}}
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
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{-- Grafik --}}
        <div class="row">

            {{-- Area Chart --}}
            <div class="col-xl-8 col-lg-7">

                <div class="card shadow mb-4">

                    <div class="card-header py-3">

                        <h6 class="m-0 font-weight-bold text-primary">
                            Grafik Booking Data
                        </h6>

                    </div>

                    <div class="card-body">

                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Informasi Akun --}}
            <div class="col-xl-4 col-lg-5">

                <div class="card shadow mb-4">

                    <div class="card-header py-3">

                        <h6 class="m-0 font-weight-bold text-primary">
                            Informasi Akun
                        </h6>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Nama
                            </small>

                            <strong>
                                {{ auth()->user()->name }}
                            </strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Email
                            </small>

                            <strong>
                                {{ auth()->user()->email }}
                            </strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Role
                            </small>

                            <span class="badge badge-primary">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <style>
        .dashboard-content {
            padding-left: 30px;
            padding-right: 30px;
        }
    </style>
@endsection

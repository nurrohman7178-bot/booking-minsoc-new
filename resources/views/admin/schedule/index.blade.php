@extends('layouts.admin.app')

@section('content')

    <div class="container-fluid">

        <div class="mb-4">

            <h1 class="page-title mb-1">
                Schedule Data
            </h1>

            <p class="text-muted mb-3">
                Kelola hari operasional lapangan minggu ini.
            </p>

            <form action="{{ route('schedule.generate') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-success" onclick="return confirm('Buat jadwal untuk minggu ini?')">

                    <i class="fas fa-calendar-plus mr-1"></i>
                    Generate Jadwal Mingguan

                </button>

            </form>

        </div>


        {{-- SUCCESS --}}
        @if (session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR --}}
        @if (session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        {{-- DAFTAR HARI --}}
        <div class="row">

            @foreach ($days as $day)
                @php
                    $tanggal = $day->format('Y-m-d');

                    $jadwalHariIni = $schedule->filter(function ($item) use ($tanggal) {
                        return $item->tanggal->format('Y-m-d') == $tanggal;
                    });

                    $hariLibur = $jadwalHariIni->contains(function ($item) {
                        return $item->status == 'libur';
                    });
                @endphp


                <div class="col-md-6 col-lg-4 mb-4">

                    <div class="card shadow-sm border-0 h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start">

                                <div>

                                    <h5 class="font-weight-bold mb-1">
                                        {{ $day->translatedFormat('l') }}
                                    </h5>

                                    <small class="text-muted">
                                        {{ $day->format('d-m-Y') }}
                                    </small>

                                </div>


                                {{-- STATUS HARI --}}
                                @if ($hariLibur)

                                    <span class="badge badge-secondary">
                                        Libur
                                    </span>

                                @else

                                    <span class="badge badge-success">
                                        Operasional
                                    </span>

                                @endif

                            </div>


                            <hr>


                            {{-- JIKA LIBUR --}}
                            @if ($hariLibur)

                                <p class="text-muted mb-3">
                                    Lapangan tidak dapat digunakan pada tanggal ini.
                                </p>

                                <form action="{{ route('schedule.buka') }}" method="POST">

                                    @csrf

                                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                                    <button type="submit" class="btn btn-success btn-sm">

                                        <i class="fas fa-check mr-1"></i>
                                        Buka Kembali

                                    </button>

                                </form>


                                {{-- JIKA OPERASIONAL --}}
                            @else

                                <p class="text-muted mb-3">
                                    Lapangan dapat dibooking oleh customer.
                                </p>

                                <form action="{{ route('schedule.libur') }}" method="POST">

                                    @csrf

                                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                                    <button type="submit" class="btn btn-warning btn-sm"
                                        onclick="return confirm('Yakin ingin meliburkan tanggal ini?')">

                                        <i class="fas fa-calendar-times mr-1"></i>
                                        Liburkan

                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>


    <style>
        .card {
            border-radius: 8px;
        }

        .badge {
            font-size: 12px;
            padding: 7px 10px;
        }
    </style>

@endsection

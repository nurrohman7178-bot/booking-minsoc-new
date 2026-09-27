@extends('layouts.pelanggan.app')
@section('content')
    <div class="container-fluid">
        {{-- JUDUL --}}
        <div class="mb-4">
            <h1 class="page-title mb-1">
                Schedule Data
            </h1>
            <p class="text-muted mb-3">
                Cek jadwal lapangan yang tersedia untuk booking.
            </p>
        </div>
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
                            {{-- TANGGAL --}}
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="font-weight-bold mb-1">
                                        {{ $day->translatedFormat('l') }}
                                    </h5>
                                    <small class="text-muted">
                                        {{ $day->format('d-m-Y') }}
                                    </small>
                                </div>
                                {{-- STATUS --}}
                                @if ($hariLibur)
                                    <span class="badge badge-danger">
                                        Libur
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        Tersedia
                                    </span>
                                @endif
                            </div>
                            <hr>
                            {{-- KETERANGAN --}}
                            @if ($hariLibur)
                                <p class="text-muted mb-3">
                                    Lapangan tidak dapat digunakan pada tanggal ini.
                                </p>
                            @else
                                <p class="text-muted mb-3">
                                    Lapangan tersedia dan dapat dibooking.
                                </p>
                                {{-- TOMBOL BOOKING --}}
                                <a href="{{ route('pelanggan.booking') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-calendar-check"></i>
                                    Booking Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
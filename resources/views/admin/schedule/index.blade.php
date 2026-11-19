@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="page-title mb-1">Jadwal Lapangan</h1>
        <p class="text-muted mb-3">
            Lihat dan kelola jadwal lapangan untuk minggu ini.
        </p>

        <form action="{{ route('schedule.generate') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success"
                onclick="return confirm('Buat jadwal untuk minggu ini?')">
                <i class="fas fa-calendar-plus mr-1"></i>
                Buat Jadwal Mingguan
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach ($days as $day)
            @php
                $tanggal = $day->format('Y-m-d');

                $jadwalHariIni = $schedule->filter(function ($item) use ($tanggal) {
                    return $item->tanggal->format('Y-m-d') === $tanggal;
                });
            @endphp

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-1">
                            {{ $day->translatedFormat('l') }}
                        </h5>

                        <p class="text-muted mb-3">
                            {{ $day->format('d-m-Y') }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Jumlah jadwal</span>
                            <span class="badge badge-success">
                                {{ $jadwalHariIni->count() }} jadwal
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

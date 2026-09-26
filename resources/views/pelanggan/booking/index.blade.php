@extends('layouts.pelanggan.app')

@section('content')
    <div class="container-fluid">

        <div class="mb-4">
            <h1 class="page-title mb-1">Booking Lapangan</h1>
            <p class="text-muted mb-0">Pilih tanggal dan jam yang masih tersedia untuk melakukan booking.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-check mr-1"></i> Pilih Jadwal
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead>
                            <tr>
                                <th width="60px">NO</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Harga</th>
                                <th width="150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedule as $jadwal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->translatedFormat('l') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td>Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('booking.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
                                            <button type="submit" class="btn btn-sm btn-success btn-block">
                                                <i class="fas fa-calendar-plus mr-1"></i> Booking
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <div>Belum ada jadwal yang tersedia.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

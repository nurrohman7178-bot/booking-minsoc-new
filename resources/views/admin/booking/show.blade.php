@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <h1 class="page-title mb-1">
            Detail Booking
        </h1>
        <p class="text-muted mb-4">
            Informasi detail booking.
        </p>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <strong>Customer</strong>
                    <div>
                        {{ $booking->pelanggan->user->name }}
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Email< /strong>
                        <div>
                            {{ $booking->pelanggan->user->email }}
                        </div>
                </div>
                <div class="mb-3">
                    <strong>Nama Tim</strong>
                    <div> {{ $booking->nama_tim }}
                </div>
            </div>
            <div class="mb-3">
                <strong>Tanggal</strong>
                <div>
                    {{ $booking->jadwal->tanggal->format('d-m-Y') }}
                </div>
            </div>
            <div class="mb-3">
                <strong>Jam</strong>
                <div>
                    {{ \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($booking->jadwal->jam_selesai)->format('H:i') }}
                </div>
            </div>
            <div class="mb-3">
                <strong>Total Harga</strong>
                <div>
                    Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                </div>
            </div>
            <div class="mb-3">
                <strong>Status</strong>
                <div>
                    {{ ucfirst($booking->status) }}
                </div>
            </div>
            <a href="{{ route('booking.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <a href=" {{ route('booking.edit', $booking->id) }}" class="btn btn-warning">
                Edit
            </a>
        </div>
    </div>
    </div>
@endsection
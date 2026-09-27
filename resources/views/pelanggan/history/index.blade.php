@extends('layouts.pelanggan.app')
@section('content')
    <div class="container-fluid">
        {{-- JUDUL --}}
        <div class="mb-4">
            <h1 class="page-title mb-1">
                History Booking
            </h1>
            <p class="text-muted">
                lihat data history booking kamu.
            </p>
        </div>
        {{-- PESAN --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        {{-- TABEL BOOKING --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Nama Tim</th>
                                <th>Durasi</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($booking as $data)
                                                    <tr>
                                                        {{-- NO --}}
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        {{-- TANGGAL --}}
                                                        <td>
                                                            {{ $data->jadwal->tanggal->format('d-m-Y') }}
                                                        </td>
                                                        {{-- HARI --}}
                                                        <td>
                                                            {{ $data->jadwal->tanggal->locale('id')->translatedFormat('l') }}
                                                        </td>
                                                        {{-- JAM --}}
                                                        <td>
                                                            @if ($data->details->count() > 0)
                                                                                        {{ \Carbon\Carbon::parse(
                                                                    $data->details->first()->jadwal->jam_mulai
                                                                )->format('H:i') }}
                                                                                        -
                                                                                        {{ \Carbon\Carbon::parse(
                                                                    $data->details->last()->jadwal->jam_selesai
                                                                )->format('H:i') }}
                                                            @else
                                                                                        {{ \Carbon\Carbon::parse(
                                                                    $data->jadwal->jam_mulai
                                                                )->format('H:i') }}
                                                                                        -
                                                                                        {{ \Carbon\Carbon::parse(
                                                                    $data->jadwal->jam_selesai
                                                                )->format('H:i') }}
                                                            @endif
                                                        </td>
                                                        {{-- NAMA TIM --}}
                                                        <td>
                                                            {{ $data->nama_tim }}
                                                        </td>
                                                        {{-- DURASI --}}
                                                        <td>
                                                            {{ $data->details->count() }} Jam
                                                        </td>
                                                        {{-- HARGA --}}
                                                        <td>
                                                            Rp {{ number_format(
                                    $data->total_harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                                                        </td>
                                                        {{-- STATUS --}}
                                                        <td>
                                                            @if ($data->status == 'menunggu')
                                                                <span class="badge badge-warning">
                                                                    Menunggu
                                                                </span>
                                                            @elseif ($data->status == 'dikonfirmasi')
                                                                <span class="badge badge-success">
                                                                    Dikonfirmasi
                                                                </span>
                                                            @elseif ($data->status == 'selesai')
                                                                <span class="badge badge-primary">
                                                                    Selesai
                                                                </span>
                                                            @elseif ($data->status == 'ditolak')
                                                                <span class="badge badge-danger">
                                                                    Ditolak
                                                                </span>
                                                            @elseif ($data->status == 'dibatalkan')
                                                                <span class="badge badge-secondary">
                                                                    Dibatalkan
                                                                </span>
                                                            @else
                                                                <span class="badge badge-secondary">
                                                                    {{ ucfirst($data->status) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Belum ada booking.
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
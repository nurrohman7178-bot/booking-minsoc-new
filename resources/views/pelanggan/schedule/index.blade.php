@extends('layouts.pelanggan.app')

@section('content')

    <div class="container-fluid">

        {{-- Heading --}}
        <div class="mb-4">

            <h1 class="page-title mb-1">
                Jadwal Lapangan
            </h1>

            <p class="text-muted mb-0">
                Lihat jadwal lapangan dan lakukan booking.
            </p>

        </div>


        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- Error --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="alert alert-danger">

                @foreach ($errors->all() as $error)
                    <div>
                        {{ $error }}
                    </div>
                @endforeach

            </div>
        @endif


        {{-- Schedule Table --}}
        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered text-center">

                        <thead>

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Jam
                                </th>

                                <th>
                                    Harga / Jam
                                </th>

                                <th>
                                    Status
                                </th>

                                <th width="180">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($schedule as $data)
                                @php

                                    /*
                                |--------------------------------------------------------------------------
                                | Waktu selesai jadwal
                                |--------------------------------------------------------------------------
                                */

                                    $waktuSelesai = \Carbon\Carbon::parse(
                                        $data->tanggal->format('Y-m-d') . ' ' . $data->jam_selesai,
                                    );

                                    /*
                                |--------------------------------------------------------------------------
                                | Cek apakah jadwal sudah lewat
                                |--------------------------------------------------------------------------
                                */

                                    $sudahLewat = $waktuSelesai->lessThanOrEqualTo(\Carbon\Carbon::now());

                                @endphp


                                <tr>

                                    {{-- No --}}
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- Tanggal --}}
                                    <td>

                                        {{ $data->tanggal->format('d-m-Y') }}

                                    </td>


                                    {{-- Jam --}}
                                    <td>

                                        {{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }}

                                        -

                                        {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}

                                    </td>


                                    {{-- Harga --}}
                                    <td>

                                        Rp{{ number_format($data->harga_per_jam, 0, ',', '.') }}

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if ($data->status == 'libur')
                                            <span class="badge badge-secondary">
                                                Libur
                                            </span>
                                        @elseif ($sudahLewat)
                                            <span class="badge badge-secondary">
                                                Sudah Lewat
                                            </span>
                                        @elseif ($data->status == 'tersedia')
                                            <span class="badge badge-success">
                                                Tersedia
                                            </span>
                                        @elseif ($data->status == 'booked')
                                            <span class="badge badge-danger">
                                                Booked
                                            </span>
                                        @elseif ($data->status == 'maintenance')
                                            <span class="badge badge-warning">
                                                Maintenance
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Aksi --}}
                                    <td>


                                        {{-- SUDAH LEWAT --}}
                                        @if ($sudahLewat)
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>

                                                Sudah Lewat

                                            </button>


                                            {{-- LIBUR --}}
                                        @elseif ($data->status == 'libur')
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>

                                                Libur

                                            </button>


                                            {{-- TERSEDIA --}}
                                        @elseif ($data->status == 'tersedia')
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#bookingModal{{ $data->id }}">

                                                <i class="fas fa-calendar-check mr-1"></i>

                                                Booking

                                            </button>


                                            {{-- Modal Booking --}}
                                            <div class="modal fade" id="bookingModal{{ $data->id }}" tabindex="-1"
                                                role="dialog">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">


                                                        {{-- Modal Header --}}
                                                        <div class="modal-header">

                                                            <h5 class="modal-title">
                                                                Booking Lapangan
                                                            </h5>

                                                            <button type="button" class="close" data-dismiss="modal">

                                                                <span>
                                                                    &times;
                                                                </span>

                                                            </button>

                                                        </div>


                                                        {{-- Form --}}
                                                        <form action="{{ route('pelanggan.schedule.store') }}"
                                                            method="POST">

                                                            @csrf


                                                            <div class="modal-body">


                                                                {{-- ID Jadwal --}}
                                                                <input type="hidden" name="id_jadwal"
                                                                    value="{{ $data->id }}">


                                                                {{-- Tanggal --}}
                                                                <div class="form-group">

                                                                    <label>
                                                                        Tanggal
                                                                    </label>

                                                                    <input type="text" class="form-control"
                                                                        value="{{ $data->tanggal->format('d-m-Y') }}"
                                                                        readonly>

                                                                </div>


                                                                {{-- Jam --}}
                                                                <div class="form-group">

                                                                    <label>
                                                                        Jam
                                                                    </label>

                                                                    <input type="text" class="form-control"
                                                                        value="{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}"
                                                                        readonly>

                                                                </div>


                                                                {{-- Harga --}}
                                                                <div class="form-group">

                                                                    <label>
                                                                        Harga / Jam
                                                                    </label>

                                                                    <input type="text" class="form-control"
                                                                        value="Rp{{ number_format($data->harga_per_jam, 0, ',', '.') }}"
                                                                        readonly>

                                                                </div>


                                                                {{-- Nama Tim --}}
                                                                <div class="form-group">

                                                                    <label>
                                                                        Nama Tim
                                                                    </label>

                                                                    <input type="text" name="nama_tim"
                                                                        class="form-control" placeholder="Masukkan nama tim"
                                                                        maxlength="255" required>

                                                                </div>


                                                            </div>


                                                            {{-- Modal Footer --}}
                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">

                                                                    Batal

                                                                </button>


                                                                <button type="submit" class="btn btn-success">

                                                                    <i class="fas fa-check mr-1"></i>

                                                                    Booking

                                                                </button>

                                                            </div>


                                                        </form>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- BOOKED --}}
                                        @elseif ($data->status == 'booked')
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>

                                                Sudah Dibooking

                                            </button>


                                            {{-- MAINTENANCE --}}
                                        @elseif ($data->status == 'maintenance')
                                            <button type="button" class="btn btn-warning btn-sm" disabled>

                                                Maintenance

                                            </button>
                                        @endif

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="6" class="text-center py-4">

                                        <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>

                                        <br>

                                        Belum ada jadwal tersedia.

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

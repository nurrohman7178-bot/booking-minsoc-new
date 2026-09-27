@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <h1 class="page-title mb-1">
            Edit Booking
        </h1>

        <p class="text-muted mb-4">
            Ubah data booking.
        </p>

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <form action="{{ route('booking.update', $booking->id) }}" method="POST">

                    @csrf
                    @method('PUT')


                    <div class="form-group">

                        <label>
                            Customer
                        </label>

                        <select name="id_pelanggan" class="form-control" required>

                            @foreach ($customer as $data)
                                <option value="{{ $data->id }}"
                                    {{ $booking->id_pelanggan == $data->id ? 'selected' : '' }}>

                                    {{ $data->user->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Jadwal
                        </label>

                        <select name="id_jadwal" class="form-control" required>

                            @foreach ($schedule as $data)
                                <option value="{{ $data->id }}"
                                    {{ $booking->id_jadwal == $data->id ? 'selected' : '' }}>

                                    {{ $data->tanggal->format('d-m-Y') }}

                                    -

                                    {{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }}

                                    -

                                    {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Nama Tim
                        </label>

                        <input type="text" name="nama_tim" class="form-control" value="{{ $booking->nama_tim }}"
                            required>

                    </div>


                    <div class="form-group">

                        <label>
                            Status
                        </label>

                        <select name="status" class="form-control" required>

                            <option value="menunggu" {{ $booking->status == 'menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>

                            <option value="dikonfirmasi" {{ $booking->status == 'dikonfirmasi' ? 'selected' : '' }}>
                                Dikonfirmasi
                            </option>

                            <option value="ditolak" {{ $booking->status == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>

                            <option value="selesai" {{ $booking->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                            <option value="dibatalkan" {{ $booking->status == 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>

                        </select>

                    </div>


                    <div class="text-right">

                        <a href="{{ route('booking.index') }}" class="btn btn-secondary">

                            Kembali

                        </a>

                        <button type="submit" class="btn btn-success">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

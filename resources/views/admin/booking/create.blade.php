@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <h1 class="page-title mb-1">
            Tambah Booking
        </h1>

        <p class="text-muted mb-4">
            Tambahkan booking baru.
        </p>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm">

            <div class="card-body">

                <form action="{{ route('booking.store') }}" method="POST">

                    @csrf

                    <div class="form-group">
                        <label>Customer</label>

                        <select name="id_pelanggan" class="form-control" required>

                            <option value="">
                                -- Pilih Customer --
                            </option>

                            @foreach ($customer as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->user->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <div class="form-group">
                        <label>Jadwal</label>

                        <select name="id_jadwal" class="form-control" required>

                            <option value="">
                                -- Pilih Jadwal --
                            </option>

                            @foreach ($schedule as $data)
                                <option value="{{ $data->id }}">

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
                        <label>Nama Tim</label>

                        <input type="text" name="nama_tim" class="form-control" placeholder="Masukkan nama tim"
                            value="{{ old('nama_tim') }}" required>
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

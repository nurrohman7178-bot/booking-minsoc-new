@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <h1 class="page-title mb-1">
            Edit Jadwal
        </h1>

        <p class="text-muted mb-4">
            Ubah informasi jadwal.
        </p>


        <div class="card shadow-sm border-0">

            <div class="card-body">

                <form action="{{ route('schedule.update', $schedule->id) }}" method="POST">

                    @csrf
                    @method('PUT')


                    <div class="form-group">

                        <label>Tanggal</label>

                        <input type="date" name="tanggal" class="form-control"
                            value="{{ old('tanggal', $schedule->tanggal->format('Y-m-d')) }}" required>

                    </div>


                    <div class="form-group">

                        <label>Jam Mulai</label>

                        <input type="time" name="jam_mulai" class="form-control"
                            value="{{ old('jam_mulai', \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i')) }}"
                            required>

                    </div>


                    <div class="form-group">

                        <label>Jam Selesai</label>

                        <input type="time" name="jam_selesai" class="form-control"
                            value="{{ old('jam_selesai', \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i')) }}"
                            required>

                    </div>


                    <div class="form-group">

                        <label>Harga / Jam</label>

                        <input type="number" name="harga_per_jam" class="form-control"
                            value="{{ old('harga_per_jam', $schedule->harga_per_jam) }}" required>

                    </div>


                    <div class="form-group">

                        <label>Status</label>

                        <select name="status" class="form-control">

                            <option value="tersedia" {{ $schedule->status == 'tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="maintenance" {{ $schedule->status == 'maintenance' ? 'selected' : '' }}>
                                Maintenance
                            </option>

                        </select>

                    </div>


                    <div class="text-right">

                        <a href="{{ route('schedule.index') }}" class="btn btn-secondary">

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

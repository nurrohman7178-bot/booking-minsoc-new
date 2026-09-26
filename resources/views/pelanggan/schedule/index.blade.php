@extends('layouts.pelanggan.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="page-title mb-1">Jadwal Lapangan</h1>
        <p class="text-muted mb-0">
            Lihat jadwal lapangan yang tersedia.
        </p>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($schedule as $data)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $data->tanggal->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}
                                </td>

                                <td>
                                    Rp{{ number_format($data->harga_per_jam, 0, ',', '.') }}
                                </td>

                                <td>

                                    @if ($data->status == 'tersedia')

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

                                <td>

                                    @if ($data->status == 'tersedia')

                                        <a href="{{ route('pelanggan.booking.create', $data->id) }}"
                                           class="btn btn-success btn-sm">
                                            Booking
                                        </a>

                                    @elseif ($data->status == 'booked')

                                        <button class="btn btn-secondary btn-sm" disabled>
                                            Sudah Dibooking
                                        </button>

                                    @else

                                        <button class="btn btn-secondary btn-sm" disabled>
                                            Tidak Tersedia
                                        </button>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada jadwal.
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

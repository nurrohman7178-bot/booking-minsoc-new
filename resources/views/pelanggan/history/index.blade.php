@extends('layouts.pelanggan.app')

@section('content')
    <div class="container-fluid">

        <div class="mb-4">
            <h1 class="page-title mb-1">History Booking</h1>
            <p class="text-muted mb-0">Daftar booking yang pernah kamu lakukan.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead>
                            <tr>
                                <th width="60px">NO</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($history as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $data->jadwal ? \Carbon\Carbon::parse($data->jadwal->tanggal)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($data->jadwal)
                                            {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai)->format('H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        Rp {{ $data->jadwal ? number_format($data->jadwal->harga, 0, ',', '.') : '0' }}
                                    </td>
                                    <td>
                                        @if ($data->status == 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif ($data->status == 'dikonfirmasi')
                                            <span class="badge badge-success">Dikonfirmasi</span>
                                        @elseif ($data->status == 'ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif ($data->status == 'selesai')
                                            <span class="badge badge-primary">Selesai</span>
                                        @else
                                            <span class="badge badge-secondary">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-history fa-2x mb-2"></i>
                                        <div>Belum ada history booking.</div>
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

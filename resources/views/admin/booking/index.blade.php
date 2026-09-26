@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Booking Data</h1>
        <p class="text-muted mb-0">Kelola booking yang masuk dari customer.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="55">No</th>
                            <th>Customer</th>
                            <th>Nama Tim</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($booking as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $data->pelanggan?->user?->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $data->nama_tim ?: '-' }}
                                </td>

                                <td>
                                    {{ $data->jadwal?->tanggal?->format('d-m-Y') ?? '-' }}
                                </td>

                                <td>
                                    @if ($data->jadwal)
                                        {{ CarbonCarbon::parse($data->jadwal->jam_mulai)->format('H:i') }}
                                        -
                                        {{ CarbonCarbon::parse($data->jadwal->jam_selesai)->format('H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    Rp{{ number_format($data->total_harga, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if ($data->status === 'menunggu')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif ($data->status === 'dikonfirmasi')
                                        <span class="badge badge-success">Dikonfirmasi</span>
                                    @elseif ($data->status === 'ditolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif ($data->status === 'selesai')
                                        <span class="badge badge-primary">Selesai</span>
                                    @else
                                        <span class="badge badge-secondary">Dibatalkan</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($data->status === 'menunggu')
                                        <div class="d-flex flex-wrap" style="gap: 5px;">

                                            <form action="{{ route('booking.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="dikonfirmasi">

                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Terima
                                                </button>
                                            </form>

                                            <form action="{{ route('booking.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="ditolak">

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Tolak
                                                </button>
                                            </form>

                                        </div>
                                    @else
                                        <span class="text-muted small">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada data booking.
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

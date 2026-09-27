@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="page-title mb-1">
                Booking Data Page
            </h1>
            <p class="text-muted mb-3">
                Manage data booking customers.
            </p>
            <div class="text-right">
                <a href="{{ route('booking.create') }}" class="btn btn-success">
                    <i class="fas fa-plus mr-1"></i>
                    Add Booking
                </a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer / Team</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($booking as $data)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $data->pelanggan->user->name }}
                                        </strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $data->nama_tim }}
                                        </small>
                                    </td>
                                    <td>
                                        {{ $data->jadwal->tanggal->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        @if ($data->details->count() > 0)
                                            {{ \Carbon\Carbon::parse($data->details->first()->jadwal->jam_mulai)->format('H\:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($data->details->last()->jadwal->jam_selesai)->format('H\:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai)->format('H\:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai)->format('H\:i') }}
                                        @endif
                                    </td>
                                    <td>
                                        Rp{{ number_format($data->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if ($data->status == 'menunggu')
                                            <span class="badge badge-warning">
                                                Menunggu
                                            </span>
                                        @elseif ($data->status == 'dikonfirmasi')
                                            <span class="badge badge-success">
                                                Dikonfirmasi
                                            </span>
                                        @elseif ($data->status == 'ditolak')
                                            <span class="badge badge-danger">
                                                Ditolak
                                            </span>
                                        @elseif ($data->status == 'dibatalkan')
                                            <span class="badge badge-secondary">
                                                Dibatalkan
                                            </span>
                                        @elseif ($data->status == 'selesai')
                                            <span class="badge badge-primary">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="white-space nowrap">
                                        {{-- Detail --}}
                                        <a href="{{ route('booking.show', $data->id) }}" class="mr-2" title="Lihat">
                                            <i class="fas fa-eye text-dark"></i>
                                        </a>
                                        {{-- Edit --}}
                                        @if ($data->status == 'menunggu')
                                            <a href="{{ route('booking.edit', $data->id) }}" class="mr-2" title="Edit">
                                                <i class="fas fa-edit text-primary"></i>
                                            </a>
                                        @endif
                                        {{-- Delete --}}
                                        <a href="javascript:void(0)" title="Hapus"
                                            onclick="actionDestroy('{{ route('booking.destroy', $data->id) }}')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>
                                        {{-- KONFIRMASI --}}
                                        @if ($data->status == 'menunggu')
                                            <form action="{{ route('booking.update', $data->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_pelanggan" value="{{ $data->id_pelanggan }}">
                                                <input type="hidden" name="id_jadwal" value="{{ $data->id_jadwal }}">
                                                <input type="hidden" name="nama_tim" value="{{ $data->nama_tim }}">
                                                <input type="hidden" name="status" value="dikonfirmasi">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                            {{-- TOLAK --}}
                                            <form action="{{ route('booking.update', $data->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_pelanggan" value="{{ $data->id_pelanggan }}">
                                                <input type="hidden" name="id_jadwal" value="{{ $data->id_jadwal }}">
                                                <input type="hidden" name="nama_tim" value="{{ $data->nama_tim }}">
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif
                                        {{-- BATALKAN --}}
                                        @if ($data->status == 'dikonfirmasi')
                                            <form action="{{ route('booking.update', $data->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_pelanggan" value="{{ $data->id_pelanggan }}">
                                                <input type="hidden" name="id_jadwal" value="{{ $data->id_jadwal }}">
                                                <input type="hidden" name="nama_tim" value="{{ $data->nama_tim }}">
                                                <input type="hidden" name="status" value="dibatalkan">
                                                <button type="submit" class="btn btn-secondary btn-sm">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                        {{-- SELESAI --}}
                                        @if ($data->status == 'dikonfirmasi')
                                            <form action="{{ route('booking.update', $data->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_pelanggan" value="{{ $data->id_pelanggan }}">
                                                <input type="hidden" name="id_jadwal" value="{{ $data->id_jadwal }}">
                                                <input type="hidden" name="nama_tim" value="{{ $data->nama_tim }}">
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Selesai
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
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
    <form action="" id="form-destroy" method="POST">
        @csrf
        @method('DELETE')
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function actionDestroy(url, name) {
            Swal.fire({
                title: 'Hapus data Booking?',
                text: 'Data Booking akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-destroy').action = url;
                    document.getElementById('form-destroy').submit();
                }
            });
        }
    </script>
@endsection
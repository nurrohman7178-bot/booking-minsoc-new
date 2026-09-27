@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <div class="mb-4">

            <h1 class="page-title mb-1">
                Booking Data
            </h1>

            <p class="text-muted mb-3">
                Kelola data booking customer.
            </p>

            <div class="text-right">

                <a href="{{ route('booking.create') }}" class="btn btn-success">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah Booking

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

                                        {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai)->format('H:i') }}

                                        -

                                        {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai)->format('H:i') }}

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


                                    <td style="white-space: nowrap;">

                                        {{-- SHOW --}}
                                        <a href="{{ route('booking.show', $data->id) }}" class="btn btn-info btn-sm"
                                            title="Lihat">

                                            <i class="fas fa-eye"></i>

                                        </a>


                                        {{-- EDIT --}}
                                        <a href="{{ route('booking.edit', $data->id) }}" class="btn btn-warning btn-sm"
                                            title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>


                                        {{-- DELETE --}}
                                        <form action="{{ route('booking.destroy', $data->id) }}" method="POST"
                                            style="display:inline;">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus booking ini?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>


                                        {{-- KONFIRMASI --}}
                                        @if ($data->status == 'menunggu')
                                            <form action="{{ route('booking.update', $data->id) }}" method="POST"
                                                style="display:inline;">

                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id_pelanggan"
                                                    value="{{ $data->id_pelanggan }}">

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

                                                <input type="hidden" name="id_pelanggan"
                                                    value="{{ $data->id_pelanggan }}">

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

                                                <input type="hidden" name="id_pelanggan"
                                                    value="{{ $data->id_pelanggan }}">

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

                                                <input type="hidden" name="id_pelanggan"
                                                    value="{{ $data->id_pelanggan }}">

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
@endsection

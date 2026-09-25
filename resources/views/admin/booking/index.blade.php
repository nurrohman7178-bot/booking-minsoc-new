@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    {{-- Page Heading --}}
    <div class="mb-4">
        <h1 class="page-title mb-1">Booking Data Page</h1>
        <p class="text-muted mb-0">
            Data customer yang melakukan booking lapangan
        </p>
    </div>


    {{-- Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">
                &times;
            </button>
        </div>
    @endif


    {{-- Error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">
                &times;
            </button>
        </div>
    @endif


    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-striped table-bordered mb-0">

                    <thead>
                        <tr>
                            <th width="60px">NO</th>

                            <th>Nama Customer / Nama Team</th>

                            <th>Tanggal</th>

                            <th>Jam</th>

                            <th>Harga</th>

                            <th>Status Booking</th>

                            <th width="190px">Aksi</th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse ($booking as $data)

                            <tr>

                                {{-- NO --}}
                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- NAMA --}}
                                <td>
                                    {{ $data->pelanggan?->user?->name ?? '-' }}

                                    @if ($data->nama_tim)
                                        <br>
                                        <small class="text-muted">
                                            Tim: {{ $data->nama_tim }}
                                        </small>
                                    @endif
                                </td>


                                {{-- TANGGAL --}}
                                <td>
                                    @if ($data->jadwal)
                                        {{ $data->jadwal->tanggal->format('d-m-Y') }}
                                    @else
                                        -
                                    @endif
                                </td>


                                {{-- JAM --}}
                                <td>
                                    @if ($data->jadwal)

                                        {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai)->format('H:i') }}

                                        -

                                        {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai)->format('H:i') }}

                                    @else
                                        -
                                    @endif
                                </td>


                                {{-- HARGA --}}
                                <td>
                                    Rp
                                    {{ number_format($data->total_harga, 0, ',', '.') }}
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

                                    @elseif ($data->status == 'ditolak')

                                        <span class="badge badge-danger">
                                            Ditolak
                                        </span>

                                    @elseif ($data->status == 'selesai')

                                        <span class="badge badge-primary">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="badge badge-secondary">
                                            Dibatalkan
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    @if ($data->status == 'menunggu')

                                        <div class="d-flex" style="gap: 5px;">

                                            {{-- TERIMA --}}
                                            <form action="{{ route('booking.update', $data->id) }}"
                                                  method="POST">

                                                @csrf

                                                @method('PUT')

                                                <input type="hidden"
                                                       name="status"
                                                       value="dikonfirmasi">

                                                <button type="submit"
                                                        class="btn btn-sm btn-success">

                                                    <i class="fas fa-check mr-1"></i>

                                                    Terima

                                                </button>

                                            </form>


                                            {{-- TOLAK --}}
                                            <form action="{{ route('booking.update', $data->id) }}"
                                                  method="POST">

                                                @csrf

                                                @method('PUT')

                                                <input type="hidden"
                                                       name="status"
                                                       value="ditolak">

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger">

                                                    <i class="fas fa-times mr-1"></i>

                                                    Tolak

                                                </button>

                                            </form>

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Sudah diproses
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-muted py-4">

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

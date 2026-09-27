@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <h1 class="page-title mb-1">
            Edit Booking
        </h1>
        <p class="text-muted mb-4">
            Ubah data booking.
        </p>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('booking.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- CUSTOMER --}}
                    <div class="form-group">
                        <label>
                            Customer
                        </label>
                        <select name="id_pelanggan" class="form-control" required>
                            @foreach ($customer as $data)
                                <option value="{{ $data->id }}" {{ $booking->id_pelanggan == $data->id ? 'selected' : '' }}>
                                    {{ $data->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- TANGGAL --}}
                    <div class="form-group">
                        <label>
                            Tanggal
                        </label>
                        <select name="tanggal" id="tanggal" class="form-control" required>
                            <option value="">
                                -- Pilih Tanggal --
                            </option>
                            @foreach ($schedule->groupBy(function ($item) {
                                    return $item->tanggal->format('Y-m-d');
                                }) as $tanggal => $jadwals)
                                <option value="{{ $tanggal }}" {{ $booking->jadwal->tanggal->format('Y-m-d') == $tanggal ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- JAM MULAI --}}
                    <div class="form-group">
                        <label>
                            Jam Mulai
                        </label>
                        <select name="jam_mulai" id="jam_mulai" class="form-control" required>
                            <option value="">
                                -- Pilih Jam Mulai --
                            </option>
                        </select>
                    </div>
                    {{-- DURASI --}}
                    <div class="form-group">
                        <label>
                            Durasi
                        </label>
                        <select name="durasi" id="durasi" class="form-control" required>
                            <option value="">
                                -- Pilih Durasi --
                            </option>
                            <option value="1">
                                1 Jam
                            </option>
                            <option value="2">
                                2 Jam
                            </option>
                            <option value="3">
                                3 Jam
                            </option>
                        </select>
                    </div>
                    {{-- NAMA TIM --}}
                    <div class="form-group">
                        <label>
                            Nama Tim
                        </label>
                        <input type="text" name="nama_tim" class="form-control" value="{{ $booking->nama_tim }}" required>
                    </div>
                    {{-- STATUS --}}
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
                    {{-- BUTTON --}}
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
    <script>
        const schedule = @json($schedule);
        const tanggal = document.getElementById('tanggal');
        const jamMulai = document.getElementById('jam_mulai');
        const durasi = document.getElementById('durasi');
        const tanggalLama = "{{ $booking->jadwal->tanggal->format('Y-m-d') }}";
        const jamLama = "{{ \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') }}";
        let durasiLama = {{ $booking->details->count() }};
        if (durasiLama < 1) {
            durasiLama = 1;
        }
        if (durasiLama > 3) {
            durasiLama = 3;
        }
        durasi.value = durasiLama;
        function tampilkanJam() {
            jamMulai.innerHTML = `
                        <option value="">
                            -- Pilih Jam Mulai --
                        </option>
                    `;
            const tanggalDipilih = tanggal.value;
            if (!tanggalDipilih) {
                return;
            }
            schedule.forEach(function (data) {
                const tanggalData = data.tanggal.substring(0, 10);
                if (tanggalData === tanggalDipilih) {
                    const jam = data.jam_mulai.substring(0, 5);
                    jamMulai.innerHTML += `
                                <option value="${jam}:00">
                                    ${jam}
                                </option>
                            `;
                }
            });
            jamMulai.value = jamLama;
        }
        tanggal.addEventListener('change', function () {
            jamMulai.value = "";
            tampilkanJam();
        });
        tampilkanJam();
    </script>
@endsection
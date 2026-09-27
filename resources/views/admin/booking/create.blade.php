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
                    {{-- CUSTOMER --}}
                    <div class="form-group">
                        <label>Customer</label>
                        <select name="id_pelanggan" class="form-control" required>
                            <option value="">
                                -- Pilih Customer --
                            </option>
                            @foreach ($customer as $data)
                                <option value="{{ $data->id }}" {{ old('id_pelanggan') == $data->id ? 'selected' : '' }}>
                                    {{ $data->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- TANGGAL --}}
                    <div class="form-group">
                        <label>Tanggal</label>
                        <select name="tanggal" id="tanggal" class="form-control" required>
                            <option value="">
                                -- Pilih Tanggal --
                            </option>
                            @foreach ($schedule->groupBy(function ($item) {
                                    return $item->tanggal->format('Y-m-d');
                                }) as $tanggal => $jadwals)
                                <option value="{{ $tanggal }}" {{ old('tanggal') == $tanggal ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- JAM MULAI --}}
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <select name="jam_mulai" id="jam_mulai" class="form-control" required>
                            <option value="">
                                -- Pilih Jam Mulai --
                            </option>
                        </select>
                    </div>
                    {{-- DURASI --}}
                    <div class="form-group">
                        <label>Durasi</label>
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
                        <label>Nama Tim</label>
                        <input type="text" name="nama_tim" class="form-control" placeholder="Masukkan nama tim"
                            value="{{ old('nama_tim') }}" required>
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
    {{-- SCRIPT --}}
    <script>
        const schedule = @json($schedule);
        const tanggal = document.getElementById('tanggal');
        const jamMulai = document.getElementById('jam_mulai');
        tanggal.addEventListener('change', function () {
            jamMulai.innerHTML = `
                        <option value="">
                            -- Pilih Jam Mulai --
                        </option>
                    `;
            const tanggalDipilih = this.value;
            if (!tanggalDipilih) {
                return;
            }
            schedule.forEach(function (data) {
                if (data.tanggal.substring(0, 10) === tanggalDipilih) {
                    const jam = data.jam_mulai.substring(0, 5);
                    jamMulai.innerHTML += `
                                <option value="${jam}:00">
                                    ${jam}
                                </option>
                            `;
                }
            });
        });
    </script>
@endsection
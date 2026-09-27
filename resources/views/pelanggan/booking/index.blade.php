@extends('layouts.pelanggan.app')
@section('content')
    <div class="container-fluid">
        {{-- JUDUL --}}
        <div class="mb-4">
            <h1 class="page-title mb-1">
                Booking Lapangan
            </h1>
            <p class="text-muted mb-3">
                Pilih tanggal, jam, dan durasi booking.
            </p>
        </div>
        {{-- PESAN ERROR --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        {{-- VALIDATION ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('pelanggan.schedule.store') }}" method="POST">
                    @csrf
                    {{-- NAMA CUSTOMER --}}
                    <div class="form-group">
                        <label>
                            Nama Customer
                        </label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>
                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label>
                            Email
                        </label>
                        <input type="text" class="form-control" value="{{ auth()->user()->email }}" readonly>
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
                            @foreach (
                                    $schedule->groupBy(function ($item) {
                                        return $item->tanggal->format('Y-m-d');
                                    }) as $tanggal => $jadwals
                                )
                                <option value="{{ $tanggal }}" {{ old('tanggal') == $tanggal ? 'selected' : '' }}>
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
                        <input type="text" name="nama_tim" class="form-control" placeholder="Masukkan nama tim"
                            value="{{ old('nama_tim') }}" required>
                    </div>
                    {{-- TOTAL HARGA --}}
                    <div class="form-group">
                        <label>
                            Total Harga
                        </label>
                        <input type="text" id="total_harga" class="form-control" value="Rp 0" readonly>
                    </div>
                    {{-- BUTTON --}}
                    <div class="text-right">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- SCRIPT --}}
    <script>
        const schedule = @json($schedule);
        const tanggal =
            document.getElementById('tanggal');
        const jamMulai =
            document.getElementById('jam_mulai');
        const durasi =
            document.getElementById('durasi');
        const totalHarga =
            document.getElementById('total_harga');
        function tampilkanJam() {
            jamMulai.innerHTML = `
                    <option value="">
                        -- Pilih Jam Mulai --
                    </option>
                `;
            const tanggalDipilih =
                tanggal.value;
            if (!tanggalDipilih) {
                hitungHarga();
                return;
            }
            schedule.forEach(function (data) {
                const tanggalData =
                    data.tanggal.substring(0, 10);
                if (tanggalData === tanggalDipilih) {
                    const jam =
                        data.jam_mulai.substring(0, 5);
                    jamMulai.innerHTML += `
                            <option value="${jam}:00">
                                ${jam}
                            </option>
                        `;
                }
            });
            hitungHarga();
        }
        function hitungHarga() {
            const tanggalDipilih =
                tanggal.value;
            const jamDipilih =
                jamMulai.value;
            const durasiDipilih =
                parseInt(durasi.value);
            if (
                !tanggalDipilih ||
                !jamDipilih ||
                !durasiDipilih
            ) {
                totalHarga.value = 'Rp 0';
                return;
            }
            const jamAwal =
                jamDipilih.substring(0, 5);
            let hargaPerJam = 0;
            schedule.forEach(function (data) {
                const tanggalData =
                    data.tanggal.substring(0, 10);
                const jamData =
                    data.jam_mulai.substring(0, 5);
                if (
                    tanggalData === tanggalDipilih &&
                    jamData === jamAwal
                ) {
                    hargaPerJam =
                        parseFloat(data.harga_per_jam);
                }
            });
            const total =
                hargaPerJam * durasiDipilih;
            totalHarga.value =
                'Rp ' +
                total.toLocaleString('id-ID');
        }
        tanggal.addEventListener(
            'change',
            function () {
                tampilkanJam();
            }
        );
        jamMulai.addEventListener(
            'change',
            function () {
                hitungHarga();
            }
        );
        durasi.addEventListener(
            'change',
            function () {
                hitungHarga();
            }
        );
        if (tanggal.value) {
            tampilkanJam();
            const jamLama =
                "{{ old('jam_mulai') }}";
            if (jamLama) {
                jamMulai.value =
                    jamLama;
            }
            hitungHarga();
        }
    </script>
@endsection
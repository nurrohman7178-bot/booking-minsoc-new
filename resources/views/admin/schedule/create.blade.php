@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        {{-- Heading --}}
        <div class="mb-4">

            <h1 class="page-title mb-1">
                Tambah Jadwal
            </h1>

            <p class="text-muted mb-0">
                Tambahkan jadwal lapangan MiniSoccer.
            </p>

        </div>


        {{-- Form --}}
        <div class="card shadow-sm border-0">

            <div class="card-body">

                <form action="{{ route('schedule.store') }}" method="POST">

                    @csrf


                    {{-- Tanggal --}}
                    <div class="form-group">

                        <label for="tanggal">
                            Tanggal
                        </label>

                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="{{ old('tanggal', $tanggal ?? '') }}" required>

                        @error('tanggal')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- Jam Mulai --}}
                    <div class="form-group">

                        <label for="jam_mulai">
                            Jam Mulai
                        </label>

                        <select name="jam_mulai" id="jam_mulai" class="form-control" required>

                            <option value="">
                                -- Pilih Jam Mulai --
                            </option>

                            @for ($i = 0; $i < 24; $i++)
                                @php
                                    $jam = sprintf('%02d:00', $i);
                                @endphp

                                <option value="{{ $jam }}"
                                    {{ old('jam_mulai', $jam_mulai ?? '') == $jam ? 'selected' : '' }}>
                                    {{ $jam }}
                                </option>
                            @endfor

                        </select>

                        @error('jam_mulai')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- Jam Selesai --}}
                    <div class="form-group">

                        <label for="jam_selesai">
                            Jam Selesai
                        </label>

                        <select name="jam_selesai" id="jam_selesai" class="form-control" required>

                            <option value="">
                                -- Pilih Jam Selesai --
                            </option>

                            @for ($i = 0; $i < 24; $i++)
                                @php
                                    $jam = sprintf('%02d:00', $i);
                                @endphp

                                <option value="{{ $jam }}" {{ old('jam_selesai') == $jam ? 'selected' : '' }}>
                                    {{ $jam }}
                                </option>
                            @endfor

                            {{-- Khusus selesai jam 00:00 --}}
                            <option value="00:00" {{ old('jam_selesai') == '00:00' ? 'selected' : '' }}>
                                00:00 (Hari Berikutnya)
                            </option>

                        </select>

                        <small class="text-muted">
                            Contoh: 07:00 sampai 08:00 = 1 jam.
                        </small>

                        @error('jam_selesai')
                            <small class="text-danger d-block">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- Harga --}}
                    <div class="form-group">

                        <label for="harga_per_jam">
                            Harga Per Jam
                        </label>

                        <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control"
                            value="{{ old('harga_per_jam', 120000) }}" min="0" required>

                        <small class="text-muted">
                            Tarif default: Rp120.000 per jam.
                        </small>

                        @error('harga_per_jam')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="form-group">

                        <label for="status">
                            Status
                        </label>

                        <select name="status" id="status" class="form-control" required>

                            <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                Maintenance
                            </option>

                        </select>

                        @error('status')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end">

                        <a href="{{ route('schedule.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>
                            Simpan Jadwal
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

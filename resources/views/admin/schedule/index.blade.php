@extends('layouts.admin.app')

@section('content')

    <div class="container-fluid">

        <div class="mb-4">

            <h1 class="page-title mb-1">
                Schedule Data
            </h1>

            <p class="text-muted">
                Kelola jadwal lapangan.
            </p>

            <div class="d-flex align-items-center">

                {{-- Generate --}}
                <form action="{{ route('schedule.generate') }}" method="POST" class="mr-2">
                    @csrf

                    <button type="submit" class="btn btn-success" onclick="return confirm('Buat jadwal minggu ini?')">

                        <i class="fas fa-calendar-plus mr-1"></i>
                        Generate Jadwal
                    </button>
                </form>

            </div>

        </div>


        {{-- Pesan --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        {{-- Jadwal --}}
        <div class="card shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered text-center mb-0">

                        <thead>

                            <tr>

                                <th width="80">
                                    Jam
                                </th>

                                @foreach($days as $day)

                                    @php
                                        $tanggal = $day->format('Y-m-d');

                                        $hariLibur = $schedule
                                            ->where('tanggal', $tanggal)
                                            ->where('status', 'libur')
                                            ->count() > 0;
                                    @endphp

                                    <th>

                                        {{ $day->translatedFormat('D') }}

                                        <br>

                                        <small class="text-muted">
                                            {{ $day->format('d/m') }}
                                        </small>

                                        <br>

                                        @if($hariLibur)

                                            <form action="{{ route('schedule.buka') }}" method="POST" class="mt-2">

                                                @csrf

                                                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                                                <button type="submit" class="btn btn-sm btn-success">

                                                    Buka Kembali

                                                </button>

                                            </form>

                                        @else

                                            <form action="{{ route('schedule.libur') }}" method="POST" class="mt-2">

                                                @csrf

                                                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                                                <button type="submit" class="btn btn-sm btn-warning"
                                                    onclick="return confirm('Liburkan tanggal ini?')">

                                                    Liburkan

                                                </button>

                                            </form>

                                        @endif

                                    </th>

                                @endforeach

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($jamSlots as $jam)

                                <tr>

                                    <td class="font-weight-bold">
                                        {{ $jam }}
                                    </td>


                                    @foreach($days as $day)

                                        @php

                                            $tanggal = $day->format('Y-m-d');

                                            $data = $schedule->first(function ($item) use ($tanggal, $jam) {

                                                return $item->tanggal->format('Y-m-d') == $tanggal
                                                    && Carbon\Carbon::parse($item->jam_mulai)->format('H:i') == $jam;

                                            });

                                        @endphp


                                        @if(!$data)

                                            <td class="schedule-cell">
                                                -
                                            </td>


                                        @elseif($data->status == 'libur')

                                            <td class="schedule-cell libur">
                                                Libur
                                            </td>


                                        @elseif($data->status == 'tersedia')

                                            <td class="schedule-cell tersedia">
                                                Tersedia
                                            </td>


                                        @elseif($data->status == 'booked')

                                            @php
                                                $booking = $data->bookings->first();
                                            @endphp

                                            <td class="schedule-cell booked">

                                                @if($booking)
                                                    {{ $booking->nama_tim }}
                                                @else
                                                    Booked
                                                @endif

                                            </td>


                                        @elseif($data->status == 'maintenance')

                                            <td class="schedule-cell maintenance">
                                                Maintenance
                                            </td>

                                        @endif

                                    @endforeach

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <style>
        .schedule-cell {
            height: 45px;
            min-width: 110px;
            vertical-align: middle !important;
            font-size: 12px;
        }

        .tersedia {
            background: #f0fff7;
            color: #10b981;
            font-weight: bold;
        }

        .booked {
            background: #e4f7ed;
            color: #10b981;
            font-weight: bold;
        }

        .maintenance {
            background: #fff0d9;
            color: #d9822b;
            font-weight: bold;
        }

        .libur {
            background: #eeeeee;
            color: #777;
            font-weight: bold;
        }
    </style>

@endsection

@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        {{-- Heading --}}
        <div class="mb-4">

            <h1 class="page-title mb-1">
                Schedule Data
            </h1>

            <p class="text-muted mb-3">
                Kelola jadwal lapangan.
            </p>

            <div class="d-flex">

                {{-- Generate --}}
                <form action="{{ route('schedule.generate') }}" method="POST" class="mr-2">

                    @csrf

                    <button type="submit" class="btn btn-success" onclick="return confirm('Buat jadwal untuk minggu ini?')">

                        <i class="fas fa-calendar-plus mr-1"></i>
                        Generate Jadwal Mingguan

                    </button>

                </form>

                {{-- Liburkan Hari --}}
                <form action="{{ route('schedule.libur') }}" method="POST">

                    @csrf

                    <input type="date" name="tanggal" class="form-control d-inline-block" style="width: 160px;" required>

                    <button type="submit" class="btn btn-warning"
                        onclick="return confirm('Yakin ingin meliburkan tanggal ini?')">

                        <i class="fas fa-calendar-times mr-1"></i>
                        Liburkan Hari

                    </button>

                </form>

            </div>

        </div>


        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- Error --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        {{-- Schedule --}}
        <div class="card shadow-sm border-0">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered text-center mb-0">

                        <thead>

                            <tr>

                                <th class="time-column">
                                    Jam
                                </th>

                                @foreach ($days as $day)
                                    <th>

                                        {{ $day->translatedFormat('D') }}

                                        <br>

                                        <small class="text-muted">
                                            {{ $day->format('d/m') }}
                                        </small>

                                    </th>
                                @endforeach

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($jamSlots as $jam)
                                <tr>

                                    {{-- Jam --}}
                                    <td class="time-cell">
                                        {{ $jam }}
                                    </td>


                                    @foreach ($days as $day)
                                        @php

                                            $tanggal = $day->format('Y-m-d');

                                            $data = $schedule->first(function ($item) use ($tanggal, $jam) {
                                                return $item->tanggal->format('Y-m-d') == $tanggal &&
                                                    \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') == $jam;
                                            });

                                        @endphp


                                        {{-- Belum dibuat --}}
                                        @if (!$data)
                                            <td class="schedule-cell">
                                                <span class="text-muted">
                                                    -
                                                </span>
                                            </td>


                                            {{-- Tersedia --}}
                                        @elseif ($data->status == 'tersedia')
                                            <td class="schedule-cell tersedia">
                                                Tersedia
                                            </td>


                                            {{-- Booked --}}
                                        @elseif ($data->status == 'booked')
                                            @php
                                                $booking = $data->bookings->first();
                                            @endphp

                                            <td class="schedule-cell booked">

                                                @if ($booking)
                                                    {{ $booking->nama_tim }}
                                                @else
                                                    Booked
                                                @endif

                                            </td>


                                            {{-- Maintenance --}}
                                        @elseif ($data->status == 'maintenance')
                                            <td class="schedule-cell maintenance">
                                                Maintenance
                                            </td>


                                            {{-- Libur --}}
                                        @elseif ($data->status == 'libur')
                                            <td class="schedule-cell libur">
                                                Libur
                                            </td>
                                        @elseif ($data->status == 'maintenance')
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
        .time-column {
            width: 70px;
        }

        .time-cell {
            font-weight: bold;
            vertical-align: middle !important;
        }

        .schedule-cell {
            height: 45px;
            min-width: 110px;
            vertical-align: middle !important;
            font-size: 12px;
        }

        .tersedia {
            background-color: #f0fff7;
            color: #10b981;
            font-weight: bold;
        }

        .booked {
            background-color: #e4f7ed;
            color: #10b981;
            font-weight: bold;
        }

        .maintenance {
            background-color: #fff0d9;
            color: #d9822b;
            font-weight: bold;
        }

        .libur {
            background-color: #eeeeee;
            color: #777777;
            font-weight: bold;
        }
    </style>
@endsection

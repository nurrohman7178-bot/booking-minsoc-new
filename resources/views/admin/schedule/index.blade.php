@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="page-title mb-1">Schedule Data</h1>
        <p class="text-muted mb-3">Kelola jadwal lapangan minggu ini.</p>

        <form action="{{ route('schedule.generate') }}" method="POST">
            @csrf
            <button type="submit"
                    class="btn btn-success"
                    onclick="return confirm('Buat jadwal untuk minggu ini?')">
                <i class="fas fa-calendar-plus mr-1"></i>
                Generate Jadwal Mingguan
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0">

                    <thead>
                        <tr>
                            <th class="time-column">Jam</th>

                            @foreach ($days as $day)
                                @php
                                    $tanggal = $day->format('Y-m-d');

                                    $hariLibur = $schedule
                                        ->where('tanggal', $tanggal)
                                        ->where('status', 'libur')
                                        ->count() > 0;
                                @endphp

                                <th class="day-column">

                                    <div class="font-weight-bold">
                                        {{ $day->translatedFormat('D') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $day->format('d/m') }}
                                    </small>

                                    @if ($hariLibur)
                                        <form action="{{ route('schedule.buka') }}"
                                              method="POST"
                                              class="mt-2">
                                            @csrf
                                            <input type="hidden"
                                                   name="tanggal"
                                                   value="{{ $tanggal }}">

                                            <button type="submit"
                                                    class="btn btn-success btn-sm">
                                                Buka Kembali
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('schedule.libur') }}"
                                              method="POST"
                                              class="mt-2">
                                            @csrf
                                            <input type="hidden"
                                                   name="tanggal"
                                                   value="{{ $tanggal }}">

                                            <button type="submit"
                                                    class="btn btn-warning btn-sm"
                                                    onclick="return confirm('Yakin ingin meliburkan tanggal ini?')">
                                                Liburkan
                                            </button>
                                        </form>
                                    @endif

                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jamSlots as $jam)
                            <tr>

                                <td class="time-cell">
                                    {{ $jam }}
                                </td>

                                @foreach ($days as $day)
                                    @php
                                        $tanggal = $day->format('Y-m-d');

                                        $data = $schedule->first(function ($item) use ($tanggal, $jam) {
                                            return $item->tanggal->format('Y-m-d') == $tanggal
                                                && CarbonCarbon::parse($item->jam_mulai)->format('H:i') == $jam;
                                        });
                                    @endphp

                                    @if (!$data)
                                        <td class="schedule-cell">
                                            -
                                        </td>

                                    @elseif ($data->status == 'tersedia')
                                        <td class="schedule-cell tersedia">
                                            Tersedia
                                        </td>

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

                                    @elseif ($data->status == 'maintenance')
                                        <td class="schedule-cell maintenance">
                                            Maintenance
                                        </td>

                                    @elseif ($data->status == 'libur')
                                        <td class="schedule-cell libur">
                                            Libur
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
    .time-column {
        width: 70px;
        vertical-align: middle !important;
    }

    .day-column {
        min-width: 120px;
        vertical-align: middle !important;
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

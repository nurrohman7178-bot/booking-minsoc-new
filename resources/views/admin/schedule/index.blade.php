@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    {{-- Heading --}}
    <div class="mb-4">

        <h1 class="page-title mb-1">
            Schedule Data
        </h1>

        <p class="text-muted mb-0">
            Atur dan pantau ketersediaan slot bermain di setiap jadwal lapangan.
        </p>

        <div class="d-flex justify-content-end mt-4">

            <a href="{{ route('schedule.create') }}"
               class="btn btn-success">

                <i class="fas fa-plus mr-1"></i>
                Tambah Jadwal

            </a>

        </div>

    </div>


    {{-- Success --}}
    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show">

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

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fas fa-exclamation-circle mr-1"></i>

            {{ session('error') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                &times;

            </button>

        </div>

    @endif


    {{-- Schedule Table --}}

    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive schedule-wrapper">

                <table class="table table-bordered mb-0 schedule-table">

                    <thead>

                        <tr>

                            <th class="time-column">
                                Time
                            </th>

                            @foreach ($days as $day)

                                <th class="day-column">

                                    <div>
                                        {{ $day->translatedFormat('D') }}
                                    </div>

                                    <small>
                                        ({{ $day->format('d/m') }})
                                    </small>

                                </th>

                            @endforeach

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($jamSlots as $jam)

                            <tr>

                                {{-- JAM --}}

                                <td class="time-cell">
                                    {{ $jam }}
                                </td>


                                {{-- HARI --}}

                                @foreach ($days as $day)

                                    @php

                                        $tanggal = $day->format('Y-m-d');

                                        $data = $schedule->first(function ($item) use ($tanggal, $jam) {

                                            return $item->tanggal->format('Y-m-d') === $tanggal
                                                && \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') === $jam;

                                        });

                                    @endphp


                                    {{-- BELUM ADA JADWAL --}}

                                    @if (!$data)

                                        <td class="schedule-cell available">

                                            <a href="{{ route('schedule.create', [
                                                'tanggal' => $tanggal,
                                                'jam_mulai' => $jam
                                            ]) }}"
                                               class="slot-link">

                                                +

                                            </a>

                                        </td>


                                    {{-- MAINTENANCE --}}

                                    @elseif ($data->status === 'maintenance')

                                        <td class="schedule-cell maintenance">

                                            <strong>
                                                Maintenance
                                            </strong>

                                        </td>


                                    {{-- BOOKED --}}

                                    @elseif ($data->status === 'booked')

                                        <td class="schedule-cell booked">

                                            @php
                                                $booking = $data->bookings->first();
                                            @endphp

                                            @if ($booking)

                                                <strong>
                                                    {{ $booking->nama_tim }}
                                                </strong>

                                                <small>
                                                    Booked
                                                </small>

                                            @else

                                                <strong>
                                                    Booked
                                                </strong>

                                            @endif

                                        </td>


                                    {{-- TERSEDIA --}}

                                    @else

                                        <td class="schedule-cell available">

                                            <a href="{{ route('schedule.create', [
                                                'tanggal' => $tanggal,
                                                'jam_mulai' => $jam
                                            ]) }}"
                                               class="slot-link">

                                                +

                                            </a>

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

    .schedule-wrapper {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 650px;
    }

    .schedule-table {
        min-width: 900px;
        margin-bottom: 0;
        font-size: 12px;
    }

    .schedule-table th {
        background-color: #ffffff;
        color: #5a5c69;
        text-align: center;
        vertical-align: middle;
        height: 55px;
        white-space: nowrap;
    }

    .time-column {
        width: 70px;
        min-width: 70px;
    }

    .day-column {
        width: 120px;
        min-width: 120px;
    }

    .day-column small {
        color: #858796;
        font-weight: normal;
    }

    .time-cell {
        width: 70px;
        min-width: 70px;
        text-align: center;
        vertical-align: middle !important;
        font-weight: 600;
        background-color: #ffffff;
        color: #5a5c69;
        white-space: nowrap;
    }

    .schedule-cell {
        height: 55px;
        min-width: 120px;
        padding: 4px !important;
        text-align: center;
        vertical-align: middle !important;
    }

    .schedule-cell.available {
        background-color: #ffffff;
    }

    .slot-link {
        display: flex;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #c5c7d0;
        font-size: 18px;
        font-weight: 600;
    }

    .slot-link:hover {
        color: #10b981;
        background-color: #f0fff7;
        text-decoration: none;
    }

    .schedule-cell.booked {
        background-color: #e4f7ed;
        border-color: #c7ead8;
        color: #10b981;
    }

    .schedule-cell.booked strong {
        display: block;
        font-size: 10px;
    }

    .schedule-cell.booked small {
        display: block;
        font-size: 8px;
        color: #6c9f84;
    }

    .schedule-cell.maintenance {
        background-color: #fff0d9;
        border-color: #ffe0ad;
        color: #d9822b;
    }

    .schedule-cell.maintenance strong {
        font-size: 9px;
    }

</style>

@endsection

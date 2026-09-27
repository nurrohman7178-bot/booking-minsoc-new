<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $mulaiMinggu = Carbon::now()->startOfWeek();
        $akhirMinggu = Carbon::now()->endOfWeek();

        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $days[] = $mulaiMinggu->copy()->addDays($i);
        }

        // Jam 07:00 sampai 22:00
        $jamSlots = [];

        for ($i = 7; $i < 23; $i++) {
            $jamSlots[] = sprintf('%02d:00', $i);
        }

        /*
        |--------------------------------------------------------------------------
        | Booking yang waktunya sudah selesai
        |--------------------------------------------------------------------------
        */

        $bookingSelesai = \App\Models\Booking::with('jadwal')
            ->where('status', 'dikonfirmasi')
            ->get();

        foreach ($bookingSelesai as $booking) {

            if (!$booking->jadwal) {
                continue;
            }

            $waktuSelesai = Carbon::parse(
                $booking->jadwal->tanggal->format('Y-m-d')
                . ' '
                . $booking->jadwal->jam_selesai
            );

            if ($waktuSelesai->lessThanOrEqualTo(Carbon::now())) {

                $booking->update([
                    'status' => 'selesai'
                ]);

                $booking->jadwal->update([
                    'status' => 'tersedia'
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil jadwal minggu ini
        |--------------------------------------------------------------------------
        */

        $schedule = Schedule::with('bookings')
            ->whereBetween('tanggal', [
                $mulaiMinggu->toDateString(),
                $akhirMinggu->toDateString()
            ])
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('admin.schedule.index', compact(
            'days',
            'jamSlots',
            'schedule'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Generate jadwal minggu ini
    |--------------------------------------------------------------------------
    */

    public function generate()
    {
        $mulaiMinggu = Carbon::now()->startOfWeek();

        for ($hari = 0; $hari < 7; $hari++) {

            $tanggal = $mulaiMinggu->copy()->addDays($hari);

            for ($jam = 7; $jam < 23; $jam++) {

                Schedule::firstOrCreate(
                    [
                        'tanggal' => $tanggal->format('Y-m-d'),
                        'jam_mulai' => sprintf('%02d:00', $jam),
                    ],
                    [
                        'jam_selesai' => sprintf('%02d:00', $jam + 1),
                        'harga_per_jam' => 120000,
                        'status' => 'tersedia',
                    ]
                );
            }
        }

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Jadwal minggu ini berhasil dibuat.');
    }


    /*
    |--------------------------------------------------------------------------
    | Liburkan satu hari
    |--------------------------------------------------------------------------
    */

    public function libur(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $adaBooking = \App\Models\Booking::whereHas('jadwal', function ($query) use ($request) {
            $query->where('tanggal', $request->tanggal);
        })
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->exists();

        if ($adaBooking) {
            return redirect()
                ->route('schedule.index')
                ->with('error', 'Tanggal tersebut masih memiliki booking.');
        }

        Schedule::where('tanggal', $request->tanggal)
            ->update([
                'status' => 'libur'
            ]);

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Tanggal berhasil diliburkan.');
    }


    /*
    |--------------------------------------------------------------------------
    | Buka kembali hari yang libur
    |--------------------------------------------------------------------------
    */

    public function buka(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        Schedule::where('tanggal', $request->tanggal)
            ->where('status', 'libur')
            ->update([
                'status' => 'tersedia'
            ]);

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Tanggal berhasil dibuka kembali.');
    }
}

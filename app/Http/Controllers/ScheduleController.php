<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $mulaiMinggu = Carbon::now()->startOfWeek();

        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $days[] = $mulaiMinggu->copy()->addDays($i);
        }

        $jamSlots = [];

        for ($i = 7; $i < 23; $i++) {
            $jamSlots[] = sprintf('%02d:00', $i);
        }

        $schedule = Schedule::with('bookings')
            ->whereBetween('tanggal', [
                $mulaiMinggu->format('Y-m-d'),
                $mulaiMinggu->copy()->addDays(6)->format('Y-m-d')
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

        return back()->with('success', 'Jadwal minggu ini berhasil dibuat.');
    }

    public function libur(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $adaBooking = Booking::whereHas('jadwal', function ($query) use ($request) {
            $query->where('tanggal', $request->tanggal);
        })
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->exists();

        if ($adaBooking) {
            return back()->with(
                'error',
                'Tanggal tersebut masih memiliki booking.'
            );
        }

        Schedule::where('tanggal', $request->tanggal)
            ->update([
                'status' => 'libur'
            ]);

        return back()->with(
            'success',
            'Tanggal berhasil diliburkan.'
        );
    }

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

        return back()->with(
            'success',
            'Tanggal berhasil dibuka kembali.'
        );
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedule.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'harga_per_jam' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,maintenance',
        ]);

        $schedule->update($data);

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}

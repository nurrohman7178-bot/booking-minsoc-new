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
        // Mulai dari tanggal hari ini
        $mulaiTanggal = Carbon::today();
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $days[] = $mulaiTanggal->copy()->addDays($i);
        }
        $jamSlots = [];
        // 07:00 - 23:00
        for ($i = 7; $i < 23; $i++) {
            $jamSlots[] = sprintf('%02d:00', $i);
        }
        // Ambil jadwal mulai hari ini sampai 6 hari ke depan
        $schedule = Schedule::with('bookings')
            ->whereBetween('tanggal', [
                $mulaiTanggal->format('Y-m-d'),
                $mulaiTanggal->copy()->addDays(6)->format('Y-m-d')
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
        $mulaiTanggal = Carbon::today();
        for ($hari = 0; $hari < 7; $hari++) {
            $tanggal = $mulaiTanggal->copy()->addDays($hari);
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
        return back()->with(
            'success',
            'Jadwal 7 hari berhasil dibuat.'
        );
    }
    public function edit(Schedule $schedule)
    {
        return view(
            'admin.schedule.edit',
            compact('schedule')
        );
    }
    public function update(
        Request $request,
        Schedule $schedule
    ) {
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
            ->with(
                'success',
                'Jadwal berhasil diperbarui.'
            );
    }
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()
            ->route('schedule.index')
            ->with(
                'success',
                'Jadwal berhasil dihapus.'
            );
    }
}
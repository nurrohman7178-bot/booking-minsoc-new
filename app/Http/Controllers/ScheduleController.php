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

        $jamSlots = [];

        for ($i = 0; $i < 24; $i++) {
            $jamSlots[] = sprintf('%02d:00', $i);
        }

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

    public function create(Request $request)
    {
        return view('admin.schedule.create', [
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'harga_per_jam' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,maintenance',
        ]);

        $cek = Schedule::where('tanggal', $data['tanggal'])
            ->where('jam_mulai', $data['jam_mulai'])
            ->exists();

        if ($cek) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal pada jam tersebut sudah ada.');
        }

        Schedule::create($data);

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
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
            'status' => 'required|in:tersedia,maintenance,booked',
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

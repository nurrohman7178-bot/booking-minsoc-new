<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedule = Schedule::where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('pelanggan.schedule.index', compact('schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id',
            'nama_tim' => 'required|string|max:255',
        ]);

        $pelanggan = Customer::where('id_user', auth()->id())->first();

        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $jadwal = Schedule::findOrFail($request->id_jadwal);

        if ($jadwal->status !== 'tersedia') {
            return back()->with('error', 'Jadwal sudah tidak tersedia.');
        }

        $mulai = Carbon::parse($jadwal->jam_mulai);
        $selesai = Carbon::parse($jadwal->jam_selesai);

        if ($selesai->lessThanOrEqualTo($mulai)) {
            $selesai->addDay();
        }

        $durasiJam = $mulai->diffInHours($selesai);

        $totalHarga = $durasiJam * $jadwal->harga_per_jam;

        Booking::create([
            'id_pelanggan' => $pelanggan->id,
            'id_jadwal' => $jadwal->id,
            'nama_tim' => $request->nama_tim,
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
        ]);

        $jadwal->update([
            'status' => 'booked'
        ]);

        return redirect()
            ->route('pelanggan.booking')
            ->with('success', 'Booking berhasil dibuat.');
    }
}

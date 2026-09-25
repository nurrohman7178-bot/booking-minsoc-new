<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Schedule;

class BookingController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'pelanggan') {
            $schedule = Schedule::where('status', 'tersedia')
                ->orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->get();

            return view('pelanggan.booking.index', compact('schedule'));
        }

        $booking = Booking::with(['pelanggan.user', 'jadwal'])
            ->latest()
            ->get();

        return view('admin.booking.index', compact('booking'));
    }

    public function create()
    {
        return redirect()->route('booking.index');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'pelanggan') {
            abort(403);
        }

        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id_jadwal',
        ]);

        $pelanggan = auth()->user()->pelanggan;

        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan belum tersedia.');
        }

        $jadwal = Schedule::where('id_jadwal', $request->id_jadwal)
            ->where('status', 'tersedia')
            ->first();

        if (!$jadwal) {
            return back()->with('error', 'Jadwal tersebut sudah tidak tersedia.');
        }

        Booking::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_jadwal' => $jadwal->id_jadwal,
            'status' => 'menunggu',
        ]);

        $jadwal->status = 'booked';
        $jadwal->save();

        return redirect()->route('history.index')
            ->with('success', 'Booking berhasil dibuat dan sedang menunggu konfirmasi.');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        return redirect()->route('booking.index');
    }

    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:dikonfirmasi,ditolak',
        ]);

        $booking = Booking::with('jadwal')->findOrFail($id);

        if ($booking->status !== 'menunggu') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        $booking->status = $request->status;
        $booking->save();

        // Jika booking ditolak, jadwal dikembalikan menjadi tersedia.
        if ($request->status === 'ditolak' && $booking->jadwal) {
            $booking->jadwal->status = 'tersedia';
            $booking->jadwal->save();
        }

        $pesan = $request->status === 'dikonfirmasi'
            ? 'Booking berhasil dikonfirmasi.'
            : 'Booking berhasil ditolak dan jadwal kembali tersedia.';

        return redirect()->route('booking.index')->with('success', $pesan);
    }

    public function destroy(string $id) {}
}

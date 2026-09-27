<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $booking = Booking::with(['pelanggan.user', 'jadwal'])
            ->latest()
            ->get();

        return view('admin.booking.index', compact('booking'));
    }


    public function create()
    {
        $customer = Customer::with('user')->get();

        $schedule = Schedule::where('status', 'tersedia')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('admin.booking.create', compact(
            'customer',
            'schedule'
        ));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'id_jadwal' => 'required|exists:jadwal,id',
            'nama_tim' => 'required|string|max:255',
        ]);

        $jadwal = Schedule::findOrFail($data['id_jadwal']);

        if ($jadwal->status !== 'tersedia') {
            return back()
                ->withInput()
                ->with('error', 'Jadwal sudah tidak tersedia.');
        }

        $mulai = Carbon::parse($jadwal->jam_mulai);
        $selesai = Carbon::parse($jadwal->jam_selesai);

        if ($selesai->lessThanOrEqualTo($mulai)) {
            $selesai->addDay();
        }

        $durasiJam = $mulai->diffInHours($selesai);

        $totalHarga = $durasiJam * $jadwal->harga_per_jam;

        Booking::create([
            'id_pelanggan' => $data['id_pelanggan'],
            'id_jadwal' => $data['id_jadwal'],
            'nama_tim' => $data['nama_tim'],
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
        ]);

        $jadwal->update([
            'status' => 'booked'
        ]);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil ditambahkan.');
    }


    public function show(Booking $booking)
    {
        $booking->load(['pelanggan.user', 'jadwal']);

        return view('admin.booking.show', compact('booking'));
    }


    public function edit(Booking $booking)
    {
        $booking->load(['pelanggan.user', 'jadwal']);

        $customer = Customer::with('user')->get();

        $schedule = Schedule::where('status', 'tersedia')
            ->orWhere('id', $booking->id_jadwal)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('admin.booking.edit', compact(
            'booking',
            'customer',
            'schedule'
        ));
    }


    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'id_jadwal' => 'required|exists:jadwal,id',
            'nama_tim' => 'required|string|max:255',
            'status' => 'required|in:menunggu,dikonfirmasi,ditolak,selesai,dibatalkan',
        ]);

        $booking->update($data);

        // Kalau booking ditolak, dibatalkan, atau selesai
        // maka jadwal kembali tersedia
        if (
            $data['status'] === 'ditolak' ||
            $data['status'] === 'dibatalkan' ||
            $data['status'] === 'selesai'
        ) {
            $booking->jadwal->update([
                'status' => 'tersedia'
            ]);
        }

        // Kalau booking dikonfirmasi
        // maka jadwal tetap booked
        if ($data['status'] === 'dikonfirmasi') {
            $booking->jadwal->update([
                'status' => 'booked'
            ]);
        }

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil diperbarui.');
    }


    public function destroy(Booking $booking)
    {
        $jadwal = $booking->jadwal;

        $booking->delete();

        if ($jadwal) {
            $jadwal->update([
                'status' => 'tersedia'
            ]);
        }

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dihapus.');
    }
}

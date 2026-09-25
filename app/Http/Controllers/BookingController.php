<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Schedule;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Menampilkan booking.
     * Pelanggan melihat jadwal tersedia.
     * Admin melihat semua booking.
     */
    public function index()
    {
        if (auth()->user()->role === 'pelanggan') {

            $schedule = Schedule::where('status', 'tersedia')
                ->orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->get();

            return view('pelanggan.booking.index', compact('schedule'));
        }

        $booking = Booking::with([
                'pelanggan.user',
                'jadwal'
            ])
            ->latest()
            ->get();

        return view('admin.booking.index', compact('booking'));
    }


    /**
     * Halaman create tidak digunakan.
     */
    public function create()
    {
        return redirect()->route('booking.index');
    }


    /**
     * Menyimpan booking dari pelanggan.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'pelanggan') {
            abort(403);
        }

        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id',
            'nama_tim' => 'required|string|max:255',
        ]);


        // Ambil data pelanggan yang sedang login
        $pelanggan = auth()->user()->pelanggan;

        if (!$pelanggan) {
            return back()->with(
                'error',
                'Data pelanggan belum tersedia.'
            );
        }


        // Cari jadwal yang masih tersedia
        $jadwal = Schedule::where('id', $request->id_jadwal)
            ->where('status', 'tersedia')
            ->first();


        if (!$jadwal) {
            return back()->with(
                'error',
                'Jadwal tersebut sudah tidak tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG DURASI
        |--------------------------------------------------------------------------
        */

        $jamMulai = Carbon::parse($jadwal->jam_mulai);

        $jamSelesai = Carbon::parse($jadwal->jam_selesai);

        $durasiJam = $jamMulai->diffInHours($jamSelesai);


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL HARGA
        |--------------------------------------------------------------------------
        */

        $totalHarga = $durasiJam * $jadwal->harga_per_jam;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN BOOKING
        |--------------------------------------------------------------------------
        */

        Booking::create([
            'id_pelanggan' => $pelanggan->id,
            'id_jadwal' => $jadwal->id,
            'nama_tim' => $request->nama_tim,
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
        ]);


        /*
        |--------------------------------------------------------------------------
        | UBAH STATUS JADWAL
        |--------------------------------------------------------------------------
        */

        $jadwal->status = 'booked';

        $jadwal->save();


        return redirect()
            ->route('history.index')
            ->with(
                'success',
                'Booking berhasil dibuat. Total harga: Rp ' .
                number_format($totalHarga, 0, ',', '.')
            );
    }


    /**
     * Menampilkan detail booking.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Edit tidak digunakan.
     */
    public function edit(string $id)
    {
        return redirect()->route('booking.index');
    }


    /**
     * Admin menerima / menolak booking.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:dikonfirmasi,ditolak',
        ]);


        $booking = Booking::with('jadwal')
            ->findOrFail($id);


        if ($booking->status !== 'menunggu') {
            return back()->with(
                'error',
                'Booking ini sudah diproses sebelumnya.'
            );
        }


        // Ubah status booking
        $booking->status = $request->status;

        $booking->save();


        /*
        |--------------------------------------------------------------------------
        | JIKA DITOLAK
        |--------------------------------------------------------------------------
        | Jadwal dikembalikan menjadi tersedia.
        */

        if (
            $request->status === 'ditolak'
            && $booking->jadwal
        ) {
            $booking->jadwal->status = 'tersedia';

            $booking->jadwal->save();
        }


        $pesan = $request->status === 'dikonfirmasi'
            ? 'Booking berhasil dikonfirmasi.'
            : 'Booking berhasil ditolak dan jadwal kembali tersedia.';


        return redirect()
            ->route('booking.index')
            ->with('success', $pesan);
    }


    /**
     * Hapus booking.
     */
    public function destroy(string $id)
    {
        //
    }
}

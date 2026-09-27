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
        /*
        |--------------------------------------------------------------------------
        | Ambil jadwal mulai hari ini
        |--------------------------------------------------------------------------
        */

        $schedule = Schedule::where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('pelanggan.schedule.index', compact('schedule'));
    }


    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id',
            'nama_tim' => 'required|string|max:255',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil data pelanggan yang sedang login
        |--------------------------------------------------------------------------
        */

        $pelanggan = Customer::where('id_user', auth()->id())->first();

        if (!$pelanggan) {

            return back()
                ->with('error', 'Data pelanggan tidak ditemukan.');
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil jadwal
        |--------------------------------------------------------------------------
        */

        $jadwal = Schedule::findOrFail($request->id_jadwal);


        /*
        |--------------------------------------------------------------------------
        | Cek status jadwal
        |--------------------------------------------------------------------------
        */

        if ($jadwal->status !== 'tersedia') {

            return back()
                ->with('error', 'Jadwal sudah tidak tersedia.');
        }


        /*
        |--------------------------------------------------------------------------
        | Cek waktu jadwal
        |--------------------------------------------------------------------------
        */

        $waktuSelesai = Carbon::parse(
            $jadwal->tanggal->format('Y-m-d')
            . ' '
            . $jadwal->jam_selesai
        );


        if ($waktuSelesai->lessThanOrEqualTo(Carbon::now())) {

            return back()
                ->with('error', 'Jadwal tersebut sudah lewat.');
        }


        /*
        |--------------------------------------------------------------------------
        | Hitung durasi
        |--------------------------------------------------------------------------
        */

        $mulai = Carbon::parse($jadwal->jam_mulai);

        $selesai = Carbon::parse($jadwal->jam_selesai);

        if ($selesai->lessThanOrEqualTo($mulai)) {

            $selesai->addDay();
        }


        $durasiJam = $mulai->diffInHours($selesai);


        /*
        |--------------------------------------------------------------------------
        | Hitung total harga
        |--------------------------------------------------------------------------
        */

        $totalHarga = $durasiJam * $jadwal->harga_per_jam;


        /*
        |--------------------------------------------------------------------------
        | Buat booking
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
        | Ubah status jadwal
        |--------------------------------------------------------------------------
        */

        $jadwal->update([

            'status' => 'booked'

        ]);


        /*
        |--------------------------------------------------------------------------
        | Kembali ke halaman jadwal
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('pelanggan.schedule')
            ->with('success', 'Booking berhasil dibuat.');
    }
}

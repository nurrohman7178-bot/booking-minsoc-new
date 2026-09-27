<?php
namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
class ScheduleController extends Controller
{
    public function index()
{
    // Mulai dari hari ini
    $mulaiTanggal = Carbon::today();
    $days = [];
    // Tampilkan 7 hari mulai hari ini
    for ($i = 0; $i < 7; $i++) {
        $days[] = $mulaiTanggal->copy()->addDays($i);
    }
    // Ambil jadwal 7 hari ke depan
    $schedule = Schedule::whereBetween('tanggal', [
        $mulaiTanggal->format('Y-m-d'),
        $mulaiTanggal->copy()->addDays(6)->format('Y-m-d')
    ])
        ->where('status', 'tersedia')
        ->orderBy('tanggal')
        ->orderBy('jam_mulai')
        ->get();
    return view(
        'pelanggan.schedule.index',
        compact('days', 'schedule')
    );
}
    public function store(Request $request)
    {
        $pelanggan = Customer::where(
            'id_user',
            auth()->id()
        )->first();
        if (!$pelanggan) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data pelanggan tidak ditemukan.'
                );
        }
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|in:1,2,3',
            'nama_tim' => 'required|string|max:255',
        ]);
        $jamMulai = Carbon::parse($data['jam_mulai']);
        $jadwalList = [];
        // Cari semua jam yang dibooking
        for ($i = 0; $i < $data['durasi']; $i++) {
            $jam = $jamMulai->copy()->addHours($i);
            $jadwal = Schedule::where(
                'tanggal',
                $data['tanggal']
            )
                ->where(
                    'jam_mulai',
                    $jam->format('H:i:s')
                )
                ->where(
                    'status',
                    'tersedia'
                )
                ->first();
            if (!$jadwal) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Jadwal jam ' .
                        $jam->format('H:i') .
                        ' tidak tersedia.'
                    );
            }
            $jadwalList[] = $jadwal;
        }
        // Hitung total harga
        $totalHarga = 0;
        foreach ($jadwalList as $jadwal) {
            $totalHarga += $jadwal->harga_per_jam;
        }
        // Buat booking
        $booking = Booking::create([
            'id_pelanggan' => $pelanggan->id,
            'id_jadwal' => $jadwalList[0]->id,
            'nama_tim' => $data['nama_tim'],
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
        ]);
        // Simpan detail setiap jam
        foreach ($jadwalList as $jadwal) {
            BookingDetail::create([
                'id_booking' => $booking->id,
                'id_jadwal' => $jadwal->id,
            ]);
            // Tandai jadwal sudah dibooking
            $jadwal->update([
                'status' => 'booked'
            ]);
        }
        return redirect()
            ->route('pelanggan.booking')
            ->with(
                'success',
                'Booking berhasil dibuat.'
            );
    }
    public function booking()
    {
        $pelanggan = Customer::where(
            'id_user',
            auth()->id()
        )->first();
        if (!$pelanggan) {
            return back()->with(
                'error',
                'Data pelanggan tidak ditemukan.'
            );
        }
        // Booking milik customer yang sedang login
        $booking = Booking::with([
            'jadwal',
            'details.jadwal'
        ])
            ->where(
                'id_pelanggan',
                $pelanggan->id
            )
            ->latest()
            ->get();
        // Jadwal yang masih tersedia
        $schedule = Schedule::where(
            'tanggal',
            '>=',
            Carbon::today()
        )
            ->where(
                'status',
                'tersedia'
            )
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();
        return view(
            'pelanggan.booking.index',
            compact(
                'booking',
                'schedule'
            )
        );
    }
    public function history()
    {
        $pelanggan = Customer::where('id_user', auth()->id())->first();
        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan tidak ditemukan.');
        }
        $booking = Booking::with([
            'jadwal',
            'details.jadwal'
        ])
            ->where('id_pelanggan', $pelanggan->id)
            ->whereIn('status', [
                'selesai',
                'ditolak',
                'dibatalkan'
            ])
            ->latest()
            ->get();
        return view('pelanggan.history.index', compact('booking'));
    }
}
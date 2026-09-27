<?php
namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
class BookingController extends Controller
{
    public function index()
    {
        $booking = Booking::with([
            'pelanggan.user',
            'jadwal',
            'details.jadwal'
        ])
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
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|in:1,2,3',
            'nama_tim' => 'required|string|max:255',
        ]);
        $jamMulai = Carbon::parse($data['jam_mulai']);
        $jadwalList = [];
        // Cari semua slot sesuai durasi
        for ($i = 0; $i < $data['durasi']; $i++) {
            $jam = $jamMulai->copy()->addHours($i);
            $jadwal = Schedule::where('tanggal', $data['tanggal'])
                ->where('jam_mulai', $jam->format('H:i:s'))
                ->where('status', 'tersedia')
                ->first();
            // Kalau salah satu slot tidak tersedia
            if (!$jadwal) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Jadwal untuk ' .
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
        // Buat booking utama
        $booking = Booking::create([
            'id_pelanggan' => $data['id_pelanggan'],
            'id_jadwal' => $jadwalList[0]->id,
            'nama_tim' => $data['nama_tim'],
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
        ]);
        // Simpan semua slot yang dipakai
        foreach ($jadwalList as $jadwal) {
            BookingDetail::create([
                'id_booking' => $booking->id,
                'id_jadwal' => $jadwal->id,
            ]);
            // Tandai jadwal sebagai booked
            $jadwal->update([
                'status' => 'booked'
            ]);
        }
        return redirect()
            ->route('booking.index')
            ->with(
                'success',
                'Booking berhasil ditambahkan.'
            );
    }
    public function show(Booking $booking)
    {
        $booking->load([
            'pelanggan.user',
            'jadwal',
            'details.jadwal'
        ]);
        return view('admin.booking.show', compact('booking'));
    }
    public function edit(Booking $booking)
    {
        // Booking selesai tidak boleh diedit
        if ($booking->status === 'selesai') {
            return redirect()
                ->route('booking.index')
                ->with(
                    'error',
                    'Booking yang sudah selesai tidak dapat diedit.'
                );
        }
        $booking->load([
            'pelanggan.user',
            'jadwal',
            'details.jadwal'
        ]);
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
        // Booking selesai tidak boleh diedit lagi
        if ($booking->status === 'selesai') {
            return redirect()
                ->route('booking.index')
                ->with('error', 'Booking yang sudah selesai tidak dapat diubah.');
        }
        $data = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'nama_tim' => 'required|string|max:255',
            'status' => 'required|in:menunggu,dikonfirmasi,ditolak,selesai,dibatalkan',
        ]);
        if (!$request->filled('tanggal')) {
            $booking->update([
                'id_pelanggan' => $data['id_pelanggan'],
                'nama_tim' => $data['nama_tim'],
                'status' => $data['status'],
            ]);
            // Jika ditolak / dibatalkan / selesai
            // semua jadwal booking dikembalikan menjadi tersedia
            if (
                $data['status'] === 'ditolak' ||
                $data['status'] === 'dibatalkan' ||
                $data['status'] === 'selesai'
            ) {
                foreach ($booking->details as $detail) {
                    if ($detail->jadwal) {
                        $detail->jadwal->update([
                            'status' => 'tersedia'
                        ]);
                    }
                }
            }
            // Jika dikonfirmasi
            // semua jadwal booking tetap booked
            if ($data['status'] === 'dikonfirmasi') {
                foreach ($booking->details as $detail) {
                    if ($detail->jadwal) {
                        $detail->jadwal->update([
                            'status' => 'booked'
                        ]);
                    }
                }
            }
            return redirect()
                ->route('booking.index')
                ->with(
                    'success',
                    'Status booking berhasil diperbarui.'
                );
        }
        $data = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|in:1,2,3',
            'nama_tim' => 'required|string|max:255',
            'status' => 'required|in:menunggu,dikonfirmasi,ditolak,selesai,dibatalkan',
        ]);
        $jamMulai = Carbon::parse($data['jam_mulai']);
        $jadwalList = [];
        // Cari semua jadwal sesuai durasi
        for ($i = 0; $i < $data['durasi']; $i++) {
            $jam = $jamMulai->copy()->addHours($i);
            $jadwal = Schedule::where('tanggal', $data['tanggal'])
                ->where('jam_mulai', $jam->format('H:i:s'))
                ->where(function ($query) use ($booking) {
                    $query->where('status', 'tersedia')
                        ->orWhereHas('bookings', function ($q) use ($booking) {
                            $q->where('booking.id', $booking->id);
                        });
                })
                ->first();
            if (!$jadwal) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Jadwal jam ' . $jam->format('H:i') . ' tidak tersedia.'
                    );
            }
            $jadwalList[] = $jadwal;
        }
        // Hitung harga
        $totalHarga = 0;
        foreach ($jadwalList as $jadwal) {
            $totalHarga += $jadwal->harga_per_jam;
        }
        // Kembalikan jadwal lama
        foreach ($booking->details as $detail) {
            if ($detail->jadwal) {
                $detail->jadwal->update([
                    'status' => 'tersedia'
                ]);
            }
        }
        // Hapus detail lama
        $booking->details()->delete();
        // Update booking
        $booking->update([
            'id_pelanggan' => $data['id_pelanggan'],
            'id_jadwal' => $jadwalList[0]->id,
            'nama_tim' => $data['nama_tim'],
            'total_harga' => $totalHarga,
            'status' => $data['status'],
        ]);
        // Simpan detail jadwal baru
        foreach ($jadwalList as $jadwal) {
            BookingDetail::create([
                'id_booking' => $booking->id,
                'id_jadwal' => $jadwal->id,
            ]);
            if (
                $data['status'] === 'menunggu' ||
                $data['status'] === 'dikonfirmasi'
            ) {
                $jadwal->update([
                    'status' => 'booked'
                ]);
            }
        }
        return redirect()
            ->route('booking.index')
            ->with(
                'success',
                'Booking berhasil diperbarui.'
            );
    }
    public function destroy(Booking $booking)
    {
        $jadwal = $booking->jadwal;
        // Hapus detail booking
        $booking->details()->delete();
        // Hapus booking
        $booking->delete();
        // Kembalikan jadwal menjadi tersedia
        if ($jadwal) {
            $jadwal->update([
                'status' => 'tersedia'
            ]);
        }
        return redirect()
            ->route('booking.index')
            ->with(
                'success',
                'Booking berhasil dihapus.'
            );
    }
}

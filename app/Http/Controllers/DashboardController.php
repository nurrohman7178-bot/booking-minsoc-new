<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\Booking;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // =========================
        // ADMIN
        // =========================
        if ($user->role === 'admin') {
            $totalPelanggan = Customer::count();
            $totalBooking = Booking::count();
            $jadwalTersedia = Schedule::where(
                'status',
                'tersedia'
            )->count();
            // Booking minggu ini
            $mulaiMinggu = Carbon::now()->startOfWeek();
            $akhirMinggu = Carbon::now()->endOfWeek();
            $bookingMingguan = Booking::whereBetween(
                'created_at',
                [
                    $mulaiMinggu,
                    $akhirMinggu
                ]
            )
                ->selectRaw(
                    'DAYOFWEEK(created_at) as hari, COUNT(*) as jumlah'
                )
                ->groupBy('hari')
                ->pluck('jumlah', 'hari');
            $dataBooking = [];
            // Senin sampai Sabtu
            for ($i = 2; $i <= 7; $i++) {
                $dataBooking[] =
                    $bookingMingguan[$i] ?? 0;
            }
            // Minggu
            $dataBooking[] =
                $bookingMingguan[1] ?? 0;
            return view(
                'admin.dashboard',
                compact(
                    'totalPelanggan',
                    'totalBooking',
                    'jadwalTersedia',
                    'dataBooking'
                )
            );
        }
        // =========================
// PELANGGAN
// =========================
        if ($user->role === 'pelanggan') {
            $pelanggan = $user->pelanggan;
            // Total semua booking milik pelanggan
            $totalBooking = $pelanggan
                ? Booking::where('id_pelanggan', $pelanggan->id)->count()
                : 0;
            // Total history
            $totalHistory = $pelanggan
                ? Booking::where('id_pelanggan', $pelanggan->id)
                    ->whereIn('status', [
                        'selesai',
                        'ditolak',
                        'dibatalkan'
                    ])
                    ->count()
                : 0;
            // Booking yang masih menunggu
            $bookingMenunggu = $pelanggan
                ? Booking::where('id_pelanggan', $pelanggan->id)
                    ->where('status', 'menunggu')
                    ->count()
                : 0;
            // Jadwal tersedia
            $jadwalTersedia = Schedule::where(
                'status',
                'tersedia'
            )->count();
            return view(
                'pelanggan.dashboard',
                compact(
                    'totalBooking',
                    'totalHistory',
                    'bookingMenunggu',
                    'jadwalTersedia'
                )
            );
        }
        // Role tidak dikenali
        abort(
            403,
            'Role tidak dikenali.'
        );
    }
}
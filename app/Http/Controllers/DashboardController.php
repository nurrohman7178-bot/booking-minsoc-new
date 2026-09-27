<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Schedule;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // DASHBOARD ADMIN
        if ($user->role === 'admin') {

            $totalPelanggan = Customer::count();

            $totalBooking = Booking::count();

            $jadwalTersedia = Schedule::where('status', 'tersedia')->count();

            return view('admin.dashboard', compact(
                'totalPelanggan',
                'totalBooking',
                'jadwalTersedia'
            ));
        }

        // DASHBOARD PELANGGAN
        if ($user->role === 'pelanggan') {

            $pelanggan = $user->pelanggan;

            $totalBooking = $pelanggan
                ? $pelanggan->bookings()->count()
                : 0;

            $bookingMenunggu = $pelanggan
                ? $pelanggan->bookings()
                    ->where('status', 'menunggu')
                    ->count()
                : 0;

            $jadwalTersedia = Schedule::where('status', 'tersedia')->count();

            return view('pelanggan.dashboard', compact(
                'totalBooking',
                'bookingMenunggu',
                'jadwalTersedia'
            ));
        }

        abort(403, 'Role tidak dikenali.');
    }
}

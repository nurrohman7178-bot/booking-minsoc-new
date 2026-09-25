<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $totalPelanggan = Customer::count();
            $totalBooking = Schedule::count();

            return view('admin.dashboard', compact('totalPelanggan', 'totalBooking'));
        }

        if ($user->role === 'pelanggan') {
            $pelanggan = $user->pelanggan;

            $totalBooking = $pelanggan ? $pelanggan->bookings()->count() : 0;
            $bookingMenunggu = $pelanggan
                ? $pelanggan->bookings()->where('status', 'menunggu')->count()
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

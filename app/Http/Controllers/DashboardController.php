<?php

namespace App\Http\Controllers;

use App\Models\Pendataan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggalSekarang = now();

        // Bayi di bawah 12 bulan
        $query = Pendataan::select(DB::raw('COUNT(*) as total_bayi'))
            ->whereRaw("tgl_lahir_bayi + INTERVAL '12 months' >= ?", [$tanggalSekarang])
            ->get();
        $totalBayiUnder12 = $query[0]->total_bayi;

        // Bayi di bawah 24 bulan
        $query = Pendataan::select(DB::raw('COUNT(*) as total_bayi'))
            ->whereRaw("tgl_lahir_bayi + INTERVAL '12 months' < ?", [$tanggalSekarang])
            ->whereRaw("tgl_lahir_bayi + INTERVAL '24 months' >= ?", [$tanggalSekarang])
            ->get();
        $totalBayiUnder24 = $query[0]->total_bayi;

        // Bayi di bawah 36 bulan
        $query = Pendataan::select(DB::raw('COUNT(*) as total_bayi'))
            ->whereRaw("tgl_lahir_bayi + INTERVAL '24 months' < ?", [$tanggalSekarang])
            ->whereRaw("tgl_lahir_bayi + INTERVAL '36 months' >= ?", [$tanggalSekarang])
            ->get();
        $totalBayiUnder36 = $query[0]->total_bayi;

        // Bayi di bawah 48 bulan
        $query = Pendataan::select(DB::raw('COUNT(*) as total_bayi'))
            ->whereRaw("tgl_lahir_bayi + INTERVAL '36 months' < ?", [$tanggalSekarang])
            ->whereRaw("tgl_lahir_bayi + INTERVAL '48 months' >= ?", [$tanggalSekarang])
            ->get();
        $totalBayiUnder48 = $query[0]->total_bayi;

        // Bayi di bawah 60 bulan
        $query = Pendataan::select(DB::raw('COUNT(*) as total_bayi'))
            ->whereRaw("tgl_lahir_bayi + INTERVAL '48 months' < ?", [$tanggalSekarang])
            ->whereRaw("tgl_lahir_bayi + INTERVAL '60 months' >= ?", [$tanggalSekarang])
            ->get();
        $totalBayiUnder60 = $query[0]->total_bayi;

        return view('dashboard', [
            'totalPuskesmas' => User::where('role', 'puskesmas')->count(),
            'totalPosyandu' => User::where('role', 'posyandu')->count(),
            'totalL' => Pendataan::where('jkel', 'Laki-Laki')->count(),
            'totalP' => Pendataan::where('jkel', 'Perempuan')->count(),
            'totalBayiUnder12' => $totalBayiUnder12,
            'totalBayiUnder24' => $totalBayiUnder24,
            'totalBayiUnder36' => $totalBayiUnder36,
            'totalBayiUnder48' => $totalBayiUnder48,
            'totalBayiUnder60' => $totalBayiUnder60,
        ]);
    }
}

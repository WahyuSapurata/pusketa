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
        $totalBayiUnder12 = Pendataan::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) < 12", [$tanggalSekarang])
            ->count();

        // Bayi di bawah 24 bulan
        $totalBayiUnder24 = Pendataan::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) >= 12", [$tanggalSekarang])
            ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) < 24", [$tanggalSekarang])
            ->count();

        // Bayi di bawah 36 bulan
        $totalBayiUnder36 = Pendataan::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) >= 24", [$tanggalSekarang])
            ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) < 36", [$tanggalSekarang])
            ->count();

        // Bayi di bawah 48 bulan
        $totalBayiUnder48 = Pendataan::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) >= 36", [$tanggalSekarang])
            ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) < 48", [$tanggalSekarang])
            ->count();

        // Bayi di bawah 60 bulan
        $totalBayiUnder60 = Pendataan::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) >= 48", [$tanggalSekarang])
            ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir_bayi, ?) < 60", [$tanggalSekarang])
            ->count();

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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Anggota;
use App\Models\Informasi;
use App\Models\Profesi;
use App\Models\Regu;
use App\Models\SlipGaji;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        // Hitung total data dari masing-masing model
        $totalAnggota = Anggota::count();
        $totalAbsensi = Absensi::count();
        $totalInformasi = Informasi::count();
        $totalProfesi = Profesi::count();
        $totalRegu = Regu::count();
        $totalSlipGaji = SlipGaji::count();

        // Kirim data ke view
        return view('admin.dashboard', compact(
            'totalAnggota',
            'totalAbsensi',
            'totalInformasi',
            'totalProfesi',
            'totalRegu',
            'totalSlipGaji'
        ));
    }
}

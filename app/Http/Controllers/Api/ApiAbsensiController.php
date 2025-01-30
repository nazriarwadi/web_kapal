<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAbsensiController extends Controller
{
    // Get data absensi berdasarkan pengguna yang login
    public function getAbsensiByUser(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Jika pengguna tidak ditemukan (tidak login)
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401); // 401 Unauthorized
        }

        // Ambil data absensi berdasarkan anggota_id (ID pengguna yang login)
        $absensi = Absensi::where('anggota_id', $user->id)
            ->with(['anggota', 'profesi', 'regu']) // Eager load relasi
            ->get();

        // Jika data absensi tidak ditemukan
        if ($absensi->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada data absensi untuk pengguna ini',
                'data' => [],
            ], 200); // 200 OK
        }

        // Format data absensi untuk response
        $formattedAbsensi = $absensi->map(function ($item) {
            return [
                'nama_anggota' => $item->anggota->nama, // Nama anggota
                'nama_profesi' => $item->profesi->nama_profesi, // Nama profesi
                'nama_regu' => $item->regu->nama_regu, // Nama regu
                'hadir' => $item->hadir, // Jumlah hadir
                'izin' => $item->izin, // Jumlah izin
                'lembur' => $item->lembur, // Jumlah lembur
            ];
        });

        // Kembalikan data absensi yang sudah diformat
        return response()->json([
            'status' => 'success',
            'message' => 'Data absensi berhasil diambil',
            'data' => $formattedAbsensi,
        ], 200); // 200 OK
    }
}
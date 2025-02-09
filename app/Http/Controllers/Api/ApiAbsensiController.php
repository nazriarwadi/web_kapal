<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

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
                'total_hadir' => 0,
                'total_izin' => 0,
                'total_lembur' => 0,
            ], 200); // 200 OK
        }

        // Format data absensi
        $formattedAbsensi = $absensi->map(function ($item) {
            $tanggalFormat = Carbon::parse($item->tanggal_absensi)->locale('id')->isoFormat('dddd, DD MMMM YYYY');

            // Filter data hanya jika hadir, izin, atau lembur > 0
            $data = [
                'nama_anggota' => $item->anggota->nama,
                'nama_profesi' => $item->profesi->nama_profesi,
                'nama_regu' => $item->regu->nama_regu,
                'tanggal_absensi' => Str::title($tanggalFormat), // Format tanggal dalam bahasa Indonesia
            ];

            if ($item->hadir > 0) $data['hadir'] = $item->hadir;
            if ($item->izin > 0) $data['izin'] = $item->izin;
            if ($item->lembur > 0) $data['lembur'] = $item->lembur;

            return $data;
        });

        // Hitung total hadir, izin, dan lembur
        $totalHadir = $absensi->sum('hadir');
        $totalIzin = $absensi->sum('izin');
        $totalLembur = $absensi->sum('lembur');

        // Kembalikan response JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data absensi berhasil diambil',
            'data' => $formattedAbsensi,
            'total_hadir' => $totalHadir,
            'total_izin' => $totalIzin,
            'total_lembur' => $totalLembur,
        ], 200);
    }

    public function checkNewAbsensi(Request $request)
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

        // Ambil timestamp terakhir dari request (dikirim dari client)
        $lastChecked = $request->input('last_checked'); // Format: Y-m-d H:i:s

        // Jika tidak ada timestamp terakhir, beri respon error
        if (!$lastChecked) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter last_checked diperlukan',
            ], 400); // 400 Bad Request
        }

        // Cari data absensi baru yang dibuat setelah `last_checked`
        $newAbsensi = Absensi::where('anggota_id', $user->id)
            ->where('created_at', '>', $lastChecked)
            ->exists(); // Cek apakah ada data baru

        // Jika ada data baru
        if ($newAbsensi) {
            return response()->json([
                'status' => 'success',
                'message' => 'Ada data absensi baru',
                'has_new_data' => true,
            ], 200); // 200 OK
        }

        // Jika tidak ada data baru
        return response()->json([
            'status' => 'success',
            'message' => 'Tidak ada data absensi baru',
            'has_new_data' => false,
        ], 200); // 200 OK
    }
}

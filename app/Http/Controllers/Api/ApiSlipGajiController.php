<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SlipGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiSlipGajiController extends Controller
{
    // Get data slip gaji berdasarkan pengguna yang login
    public function getSlipGajiByUser(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Jika pengguna tidak ditemukan (tidak login)
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        // Ambil data slip gaji berdasarkan anggota_id (ID pengguna yang login)
        $slipGaji = SlipGaji::where('anggota_id', $user->id)
            ->with(['anggota', 'profesi', 'regu']) // Eager load relasi
            ->get();

        // Jika data slip gaji kosong
        if ($slipGaji->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada data slip gaji untuk pengguna ini',
                'data' => [],
            ], 200);
        }

        // Format respons agar hanya menampilkan nama dan data yang diperlukan
        $formattedData = $slipGaji->map(function ($item) {
            return [
                'nama_anggota' => $item->anggota->nama ?? 'Tidak Diketahui',
                'nama_profesi' => $item->profesi->nama_profesi ?? 'Tidak Diketahui',
                'nama_regu'    => $item->regu->nama_regu ?? 'Tidak Diketahui',
                'hadir'        => $item->hadir,
                'izin'         => $item->izin,
                'lembur'       => $item->lembur,
                'gaji'         => $item->gaji,
            ];
        });

        // Kembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data slip gaji berhasil diambil',
            'data' => $formattedData,
        ], 200);
    }
}

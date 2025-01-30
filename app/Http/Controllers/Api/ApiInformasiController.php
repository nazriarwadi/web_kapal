<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ApiInformasiController extends Controller
{
    // Get semua data informasi (hanya untuk pengguna yang login)
    public function getInformasiList(Request $request)
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu.',
            ], 401); // 401 Unauthorized
        }

        // Ambil semua data informasi dengan relasi regu, diurutkan dari yang terbaru
        $informasi = Informasi::with('regu')
            ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
            ->get();

        // Jika data informasi tidak ditemukan
        if ($informasi->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada data informasi',
                'data' => [],
            ], 200); // 200 OK
        }

        // Format data yang akan dikembalikan
        $formattedData = $informasi->map(function ($item) {
            return [
                'id' => $item->id,
                'gambar' => $item->gambar,
                'created_at' => Carbon::parse($item->created_at)
                    ->locale('id') // Set lokal ke Indonesia
                    ->translatedFormat('l, d F Y'), // Format: Hari, Tanggal Bulan Tahun
            ];
        });

        // Kembalikan data informasi yang diformat
        return response()->json([
            'status' => 'success',
            'message' => 'Data informasi berhasil diambil',
            'data' => $formattedData,
        ], 200); // 200 OK
    }

    // Get detail informasi berdasarkan ID (hanya untuk pengguna yang login)
    public function getInformasiById(Request $request, $id)
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Silakan login terlebih dahulu.',
            ], 401); // 401 Unauthorized
        }

        // Cari data informasi berdasarkan ID dengan relasi regu
        $informasi = Informasi::with('regu')->find($id);

        // Jika data informasi tidak ditemukan
        if (!$informasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data informasi tidak ditemukan',
            ], 404); // 404 Not Found
        }

        // Format data yang akan dikembalikan
        $formattedData = [
            'id' => $informasi->id,
            'gambar' => $informasi->gambar,
            'bawaan' => $informasi->bawaan,
            'kebarangkatan' => $informasi->kebarangkatan,
            'jam_sampai' => Carbon::parse($informasi->jam_sampai)
                ->locale('id') // Set lokal ke Indonesia
                ->translatedFormat('d F Y, \j\a\m H:i'), // Format: 31 Januari 2025, jam 20:00
            'regu' => $informasi->regu->nama_regu, // Langsung ambil nama regu
            'created_at' => Carbon::parse($informasi->created_at)
                ->locale('id') // Set lokal ke Indonesia
                ->translatedFormat('l, d F Y'), // Format: Minggu, 26 Januari 2025
            'updated_at' => $informasi->updated_at, // Biarkan dalam format default
        ];

        // Kembalikan data informasi yang diformat
        return response()->json([
            'status' => 'success',
            'message' => 'Detail informasi berhasil diambil',
            'data' => $formattedData,
        ], 200); // 200 OK
    }
}

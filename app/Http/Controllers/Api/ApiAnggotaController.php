<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAnggotaController extends Controller
{
    // Get data anggota yang sedang login
    public function getCurrentUser(Request $request)
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

        // Kembalikan data pengguna yang sedang login beserta relasinya
        return response()->json([
            'status' => 'success',
            'message' => 'Data anggota berhasil diambil',
            'data' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'nama_regu' => $user->regu->nama_regu, // Langsung tampilkan nama regu
                'nama_profesi' => $user->profesi->nama_profesi, // Langsung tampilkan nama profesi
            ],
        ], 200); // 200 OK
    }

    // Get data semua anggota yang memiliki regu_id yang sama dengan anggota yang sedang login
    public function getAllAnggota(Request $request)
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

        // Ambil regu_id dari pengguna yang sedang login
        $reguId = $user->regu_id;

        // Ambil semua data anggota dengan relasi 'regu' dan 'profesi' yang memiliki regu_id yang sama
        $anggota = Anggota::with(['regu', 'profesi'])
            ->where('regu_id', $reguId)
            ->get();

        // Jika tidak ada data anggota
        if ($anggota->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada data anggota',
                'data' => [],
            ], 200); // 200 OK
        }

        // Format data anggota
        $formattedData = $anggota->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'nama_regu' => $item->regu->nama_regu, // Langsung tampilkan nama regu
                'nama_profesi' => $item->profesi->nama_profesi, // Langsung tampilkan nama profesi
            ];
        });

        // Kembalikan data semua anggota
        return response()->json([
            'status' => 'success',
            'message' => 'Data semua anggota berhasil diambil',
            'data' => $formattedData,
        ], 200); // 200 OK
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }

        // Cari pengguna berdasarkan email
        $anggota = Anggota::where('email', $request->email)->first();

        // Jika email tidak terdaftar
        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak terdaftar',
            ], 401); // 401 Unauthorized
        }

        // Jika password salah
        if (!Hash::check($request->password, $anggota->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah',
            ], 401); // 401 Unauthorized
        }

        // Hapus token yang sudah kedaluwarsa
        $anggota->tokens()->where('created_at', '<', now()->subDays(7))->delete();

        // Buat token baru dengan waktu kedaluwarsa
        $token = $anggota->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;

        // Respons sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'anggota' => $anggota,
            ],
        ], 200); // 200 OK
    }

    // Get Data Pengguna
    public function getUser(Request $request)
    {
        // Ambil data pengguna yang sedang login
        $anggota = $request->user();

        // Respons sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Data pengguna berhasil diambil',
            'data' => [
                'anggota' => $anggota,
            ],
        ], 200); // 200 OK
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'new_password' => 'required|min:6',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }

        // Cari pengguna berdasarkan email
        $anggota = Anggota::where('email', $request->email)->first();

        // Jika pengguna tidak ditemukan
        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan',
            ], 404); // 404 Not Found
        }

        // Update password
        $anggota->password = Hash::make($request->new_password);
        $anggota->save();

        // Respons sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil direset',
        ], 200); // 200 OK
    }

    // Logout
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();

        // Respons sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil',
        ], 200); // 200 OK
    }
}

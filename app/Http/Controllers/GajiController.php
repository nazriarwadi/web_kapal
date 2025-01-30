<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\SlipGaji;
use Illuminate\Support\Facades\Log;
use App\Models\Anggota;
use App\Models\Profesi;
use App\Models\Regu;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter regu_id dari request
        $reguId = $request->query('regu_id');

        // Query data slip gaji
        $slipGaji = SlipGaji::with(['anggota', 'profesi', 'regu'])
            ->when($reguId, function ($query, $reguId) {
                return $query->where('regu_id', $reguId);
            })
            ->get();

        // Ambil data regu untuk dropdown
        $regu = Regu::all();

        return view('gaji.index', compact('slipGaji', 'regu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data anggota, profesi, dan regu untuk dropdown
        $anggota = Anggota::all();
        $profesi = Profesi::all();
        $regu = Regu::all();
        return view('gaji.create', compact('anggota', 'profesi', 'regu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'profesi_id' => 'required|exists:profesi,id',
            'regu_id' => 'required|exists:regu,id',
            'hadir' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'lembur' => 'required|integer|min:0',
            'gaji' => 'required|string',
        ]);

        // Hapus format mata uang dari input `gaji`
        $rawGaji = $request->input('gaji');
        $gaji = floatval(str_replace(['.', ','], ['', '.'], str_replace('Rp.', '', $rawGaji)));

        // Simpan data slip gaji baru
        SlipGaji::create([
            'anggota_id' => $request->anggota_id,
            'profesi_id' => $request->profesi_id,
            'regu_id' => $request->regu_id,
            'hadir' => $request->hadir,
            'izin' => $request->izin,
            'lembur' => $request->lembur,
            'gaji' => $gaji,
        ]);

        return redirect()->route('gaji.index')->with('success', 'Slip Gaji berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SlipGaji $slipGaji)
    {
        // Ambil data anggota, profesi, dan regu untuk dropdown
        $anggota = Anggota::all();
        $profesi = Profesi::all();
        $regu = Regu::all();
        return view('gaji.edit', compact('slipGaji', 'anggota', 'profesi', 'regu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SlipGaji $slipGaji)
    {
        // Log data untuk debugging
        Log::info('Data yang diterima dari form:', $request->all());

        // Validasi input
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'gaji' => 'required|string', // Biarkan string karena format mata uang
            'hadir' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'lembur' => 'required|integer|min:0',
        ]);

        // Hapus format mata uang dari input `gaji`
        $rawGaji = $request->input('gaji');
        $gaji = floatval(str_replace(['.', ','], ['', '.'], str_replace('Rp.', '', $rawGaji)));

        // Log nilai gaji setelah diolah
        Log::info('Nilai gaji setelah diolah:', ['gaji' => $gaji]);

        // Update semua data slip gaji
        $slipGaji->update([
            'anggota_id' => $request->anggota_id,
            'profesi_id' => $request->profesi_id, // Tambahkan profesi_id
            'regu_id' => $request->regu_id,       // Tambahkan regu_id
            'gaji' => $gaji,
            'hadir' => $request->hadir,
            'izin' => $request->izin,
            'lembur' => $request->lembur,
        ]);

        return redirect()->route('gaji.index')
            ->with('success', 'Slip Gaji berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SlipGaji $slipGaji)
    {
        // Hapus data slip gaji
        $slipGaji->delete();

        return redirect()->route('gaji.index')
            ->with('success', 'Slip Gaji berhasil dihapus.');
    }

    /**
     * Ambil data anggota beserta absensi untuk form create/edit.
     */
    public function getAnggotaData($id)
    {
        // Ambil data anggota beserta relasi profesi dan regu
        $anggota = Anggota::with(['profesi', 'regu'])->find($id);

        // Ambil data absensi berdasarkan anggota_id
        $absensi = Absensi::where('anggota_id', $id)->first();

        // Jika data absensi ditemukan, tambahkan ke respons
        if ($absensi) {
            $anggota->hadir = $absensi->hadir;
            $anggota->izin = $absensi->izin;
            $anggota->lembur = $absensi->lembur;
        } else {
            // Jika tidak ada data absensi, set nilai default
            $anggota->hadir = 0;
            $anggota->izin = 0;
            $anggota->lembur = 0;
        }

        return response()->json($anggota);
    }
}

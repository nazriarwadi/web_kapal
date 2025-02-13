<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\SlipGaji;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Anggota;
use App\Models\Profesi;
use App\Models\Regu;
use Carbon\Carbon;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter regu_id dari request
        $reguId = $request->query('regu_id');
        $bulan = $request->query('bulan'); // Ambil parameter bulan

        // Query data slip gaji
        $slipGaji = SlipGaji::with(['anggota', 'profesi', 'regu'])
            ->when($reguId, function ($query, $reguId) {
                return $query->where('regu_id', $reguId);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('created_at', $bulan); // Filter berdasarkan bulan
            })
            ->orderBy('created_at', 'desc') // Default pengurutan descending
            ->get();

        // Ambil data regu untuk dropdown
        $regu = Regu::all();

        return view('gaji.index', compact('slipGaji', 'regu'));
    }

    public function print(Request $request)
    {
        // Ambil parameter regu_id dan bulan dari request
        $reguId = $request->query('regu_id');
        $bulan = $request->query('bulan');

        // Query data slip gaji
        $slipGaji = SlipGaji::with(['anggota', 'profesi', 'regu'])
            ->when($reguId, function ($query, $reguId) {
                return $query->where('regu_id', $reguId);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Generate PDF
        $pdf = Pdf::loadView('gaji.print', compact('slipGaji'));

        // Buat nama file unik berdasarkan timestamp
        $fileName = 'slip-gaji-' . now()->format('YmdHis') . '.pdf';

        // Download PDF dengan nama file unik
        return $pdf->download($fileName);
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
    public function getAnggotaData($id, Request $request)
    {
        // Ambil bulan & tahun dari request, jika tidak ada gunakan bulan & tahun saat ini
        $bulan = $request->bulan ? Carbon::createFromFormat('Y-m', $request->bulan)->month : now()->month;
        $tahun = $request->bulan ? Carbon::createFromFormat('Y-m', $request->bulan)->year : now()->year;

        // Ambil data anggota beserta relasi profesi dan regu
        $anggota = Anggota::with(['profesi', 'regu'])->find($id);

        if (!$anggota) {
            return response()->json(['error' => 'Anggota tidak ditemukan'], 404);
        }

        // Hitung total kehadiran, izin, dan lembur berdasarkan bulan yang dipilih
        $absensi = Absensi::where('anggota_id', $id)
            ->whereMonth('tanggal_absensi', $bulan)
            ->whereYear('tanggal_absensi', $tahun)
            ->selectRaw('SUM(hadir) as total_hadir, SUM(izin) as total_izin, SUM(lembur) as total_lembur')
            ->first();

        // Tambahkan hasil perhitungan ke response
        $anggota->hadir = $absensi->total_hadir ?? 0;
        $anggota->izin = $absensi->total_izin ?? 0;
        $anggota->lembur = $absensi->total_lembur ?? 0;

        return response()->json($anggota);
    }
}

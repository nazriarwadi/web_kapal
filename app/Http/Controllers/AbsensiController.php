<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Anggota;
use App\Models\Profesi;
use App\Models\Regu;
use Illuminate\Support\Facades\DB; // Import facade DB dengan benar

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter bulan dan tahun dari request
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');

        // Query data absensi
        $absensi = Absensi::with(['anggota', 'profesi', 'regu'])
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('created_at', $tahun);
            })
            ->get();

        return view('absensi.index', compact('absensi'));
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
        return view('absensi.create', compact('anggota', 'profesi', 'regu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'hadir' => 'nullable|array',
            'izin' => 'nullable|array',
            'lembur' => 'nullable|array',
            'hadir.*' => 'integer|exists:anggota,id',
            'izin.*' => 'integer|exists:anggota,id',
            'lembur.*' => 'integer|exists:anggota,id',
        ]);

        // Simpan data absensi
        if ($request->hadir) {
            foreach ($request->hadir as $anggotaId) {
                $anggota = Anggota::find($anggotaId); // Ambil data anggota
                Absensi::updateOrCreate(
                    ['anggota_id' => $anggotaId],
                    [
                        'profesi_id' => $anggota->profesi_id, // Ambil profesi_id dari anggota
                        'regu_id' => $anggota->regu_id, // Ambil regu_id dari anggota
                        'hadir' => DB::raw('COALESCE(hadir, 0) + 1'), // Tambahkan 1 ke nilai hadir yang sudah ada
                        'izin' => DB::raw('COALESCE(izin, 0)'), // Pertahankan nilai izin
                        'lembur' => DB::raw('COALESCE(lembur, 0)'), // Pertahankan nilai lembur
                    ]
                );
            }
        }

        if ($request->izin) {
            foreach ($request->izin as $anggotaId) {
                $anggota = Anggota::find($anggotaId); // Ambil data anggota
                Absensi::updateOrCreate(
                    ['anggota_id' => $anggotaId],
                    [
                        'profesi_id' => $anggota->profesi_id, // Ambil profesi_id dari anggota
                        'regu_id' => $anggota->regu_id, // Ambil regu_id dari anggota
                        'hadir' => DB::raw('COALESCE(hadir, 0)'), // Pertahankan nilai hadir
                        'izin' => DB::raw('COALESCE(izin, 0) + 1'), // Tambahkan 1 ke nilai izin yang sudah ada
                        'lembur' => DB::raw('COALESCE(lembur, 0)'), // Pertahankan nilai lembur
                    ]
                );
            }
        }

        if ($request->lembur) {
            foreach ($request->lembur as $anggotaId) {
                $anggota = Anggota::find($anggotaId); // Ambil data anggota
                Absensi::updateOrCreate(
                    ['anggota_id' => $anggotaId],
                    [
                        'profesi_id' => $anggota->profesi_id, // Ambil profesi_id dari anggota
                        'regu_id' => $anggota->regu_id, // Ambil regu_id dari anggota
                        'hadir' => DB::raw('COALESCE(hadir, 0)'), // Pertahankan nilai hadir
                        'izin' => DB::raw('COALESCE(izin, 0)'), // Pertahankan nilai izin
                        'lembur' => DB::raw('COALESCE(lembur, 0) + 1'), // Tambahkan 1 ke nilai lembur yang sudah ada
                    ]
                );
            }
        }

        // Kembalikan respons JSON dengan URL redirect
        return response()->json([
            'success' => true,
            'redirect_url' => route('absensi.index')
        ]);
    }

    /**
     * Get anggota by regu.
     */
    public function getAnggotaByRegu($reguId)
{
    if ($reguId == 'all') {
        $anggota = Anggota::with(['profesi', 'regu'])->get();
    } else {
        $anggota = Anggota::with(['profesi', 'regu'])->where('regu_id', $reguId)->get();
    }
    return response()->json($anggota);
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Anggota;
use App\Models\Profesi;
use App\Models\Regu;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Import facade DB dengan benar

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Atur zona waktu ke Indonesia
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // Ambil bulan & tahun dari request, jika tidak ada gunakan bulan & tahun sekarang di Indonesia
        $bulan = $request->bulan ? Carbon::createFromFormat('Y-m', $request->bulan)->month : now()->month;
        $tahun = $request->bulan ? Carbon::createFromFormat('Y-m', $request->bulan)->year : now()->year;

        // Query dengan filter berdasarkan bulan & tahun
        $query = Absensi::with(['anggota', 'profesi', 'regu'])
            ->whereMonth('tanggal_absensi', $bulan)
            ->whereYear('tanggal_absensi', $tahun)
            ->when($request->anggota, function ($q) use ($request) {
                $q->where('anggota_id', $request->anggota);
            })
            ->when($request->regu, function ($q) use ($request) {
                $q->whereHas('anggota', function ($q) use ($request) {
                    $q->where('regu_id', $request->regu);
                });
            });

        $absensi = $query->paginate(20);

        // Hitung total hadir, izin, lembur berdasarkan bulan yang dipilih
        $totalHadir = $query->clone()->where('hadir', true)->count();
        $totalIzin = $query->clone()->where('izin', true)->count();
        $totalLembur = $query->clone()->sum('lembur');

        return view('absensi.index', [
            'absensi' => $absensi,
            'totalHadir' => $totalHadir,
            'totalIzin' => $totalIzin,
            'totalLembur' => $totalLembur,
            'allAnggota' => Anggota::all(),
            'allRegu' => Regu::all(),
            'selectedBulan' => $request->bulan ?? now()->format('Y-m') // Default ke bulan saat ini di Indonesia
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil tanggal hari ini
        $tanggalHariIni = Carbon::now('Asia/Jakarta')->toDateString();

        // Ambil data anggota yang belum melakukan absensi pada hari ini
        $anggotaBelumAbsen = Anggota::whereDoesntHave('absensi', function ($query) use ($tanggalHariIni) {
            $query->whereDate('tanggal_absensi', $tanggalHariIni);
        })->get();

        // Ambil data profesi dan regu untuk dropdown
        $profesi = Profesi::all();
        $regu = Regu::all();

        return view('absensi.create', compact('anggotaBelumAbsen', 'profesi', 'regu'));
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

        // Ambil tanggal hari ini dengan zona waktu Indonesia
        $tanggalHariIni = Carbon::now('Asia/Jakarta')->toDateString();

        // Simpan data absensi
        if ($request->hadir) {
            foreach ($request->hadir as $anggotaId) {
                // Cek apakah sudah ada absensi untuk anggota ini pada tanggal yang sama
                $existingAbsensi = Absensi::where('anggota_id', $anggotaId)
                    ->whereDate('tanggal_absensi', $tanggalHariIni)
                    ->first();

                if ($existingAbsensi) {
                    continue; // Lewati jika sudah ada absensi pada hari ini
                }

                $anggota = Anggota::find($anggotaId); // Ambil data anggota
                Absensi::create([
                    'anggota_id' => $anggotaId,
                    'profesi_id' => $anggota->profesi_id,
                    'regu_id' => $anggota->regu_id,
                    'hadir' => 1,
                    'izin' => 0,
                    'lembur' => 0,
                    'tanggal_absensi' => $tanggalHariIni,
                ]);
            }
        }

        if ($request->izin) {
            foreach ($request->izin as $anggotaId) {
                // Cek apakah sudah ada absensi untuk anggota ini pada tanggal yang sama
                $existingAbsensi = Absensi::where('anggota_id', $anggotaId)
                    ->whereDate('tanggal_absensi', $tanggalHariIni)
                    ->first();

                if ($existingAbsensi) {
                    continue; // Lewati jika sudah ada absensi pada hari ini
                }

                $anggota = Anggota::find($anggotaId); // Ambil data anggota
                Absensi::create([
                    'anggota_id' => $anggotaId,
                    'profesi_id' => $anggota->profesi_id,
                    'regu_id' => $anggota->regu_id,
                    'hadir' => 0,
                    'izin' => 1,
                    'lembur' => 0,
                    'tanggal_absensi' => $tanggalHariIni,
                ]);
            }
        }

        if ($request->lembur) {
            foreach ($request->lembur as $anggotaId) {
                // Cek apakah sudah ada absensi untuk anggota ini pada tanggal yang sama
                $existingAbsensi = Absensi::where('anggota_id', $anggotaId)
                    ->whereDate('tanggal_absensi', $tanggalHariIni)
                    ->first();

                if ($existingAbsensi) {
                    continue; // Lewati jika sudah ada absensi pada hari ini
                }

                $anggota = Anggota::find($anggotaId); // Ambil data anggota
                Absensi::create([
                    'anggota_id' => $anggotaId,
                    'profesi_id' => $anggota->profesi_id,
                    'regu_id' => $anggota->regu_id,
                    'hadir' => 0,
                    'izin' => 0,
                    'lembur' => 1,
                    'tanggal_absensi' => $tanggalHariIni,
                ]);
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
        // Ambil tanggal hari ini
        $tanggalHariIni = now()->toDateString();

        // Query untuk mengambil anggota berdasarkan regu dan belum absen hari ini
        $anggota = Anggota::whereDoesntHave('absensi', function ($query) use ($tanggalHariIni) {
            $query->whereDate('tanggal_absensi', $tanggalHariIni);
        })
            ->when($reguId !== 'all', function ($query) use ($reguId) {
                return $query->where('regu_id', $reguId);
            })
            ->with(['profesi', 'regu'])
            ->get();

        return response()->json($anggota);
    }
}

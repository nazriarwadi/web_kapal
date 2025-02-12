<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Regu;
use App\Models\Profesi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek anggota yang sudah melewati waktu banned dan otomatis unban
        Anggota::where('is_banned', true)
            ->where('banned_until', '<', now())
            ->update([
                'is_banned' => false,
                'banned_until' => null
            ]);

        // Ambil semua data anggota beserta relasi regu dan profesi
        $anggota = Anggota::with(['regu', 'profesi'])->get();

        return view('anggota.index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regu = Regu::withCount('anggota')->get();
        $profesi = Profesi::all();
        return view('anggota.create', compact('regu', 'profesi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'no_telp' => 'required|string|max:15|min:10|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:anggota,email',
            'password' => 'required|string|min:8|confirmed',
            'regu_id' => 'required|exists:regu,id',
            'profesi_id' => 'required|exists:profesi,id',
        ]);

        // Cek jumlah anggota dalam regu
        $jumlahAnggota = Anggota::where('regu_id', $request->regu_id)->count();

        if ($jumlahAnggota >= 6) {
            return redirect()->back()->withErrors(['regu_id' => 'Regu ini sudah penuh, pilih regu lain.'])->withInput();
        }

        try {
            // Simpan data anggota baru
            Anggota::create([
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Enkripsi password
                'regu_id' => $request->regu_id,
                'profesi_id' => $request->profesi_id,
            ]);

            return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        $regu = Regu::all();
        $profesi = Profesi::all();
        return view('anggota.edit', compact('anggota', 'regu', 'profesi'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'no_telp' => 'required|string|max:15|min:10|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:anggota,email,' . $anggota->id,
            'password' => 'nullable|string|min:8|confirmed',
            'regu_id' => 'required|exists:regu,id',
            'profesi_id' => 'required|exists:profesi,id',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.regex' => 'Nomor telepon hanya boleh mengandung angka.',
            'no_telp.min' => 'Nomor telepon minimal 10 digit.',
            'no_telp.max' => 'Nomor telepon maksimal 15 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'regu_id.required' => 'Regu wajib dipilih.',
            'regu_id.exists' => 'Regu yang dipilih tidak valid.',
            'profesi_id.required' => 'Profesi wajib dipilih.',
            'profesi_id.exists' => 'Profesi yang dipilih tidak valid.',
        ]);

        // Update data anggota
        $data = $request->except('password'); // Exclude password jika tidak diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password); // Enkripsi password baru
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function ban(Request $request, Anggota $anggota)
    {
        Log::info('Request received:', $request->all());
        Log::info('Anggota ID:', ['id' => $anggota->id]);

        $request->validate([
            'ban_duration' => 'required|integer|in:1,3,7,30',
        ]);

        try {
            DB::beginTransaction();
            $banDuration = (int) $request->ban_duration;

            $anggota->update([
                'is_banned' => true,
                'banned_until' => Carbon::now()->addDays($banDuration),
            ]);

            DB::commit();

            return redirect()->route('anggota.index')
                ->with('success', 'Anggota berhasil dibanned selama ' . $banDuration . ' hari.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membanned anggota: ' . $e->getMessage(), [
                'anggota_id' => $anggota->id,
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membanned anggota.');
        }
    }

    public function unban(Anggota $anggota)
    {
        try {
            DB::beginTransaction();

            $anggota->update([
                'is_banned' => false,
                'banned_until' => null
            ]);

            DB::commit();

            return redirect()->route('anggota.index')
                ->with('success', 'Anggota berhasil di-unban.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal melakukan unban: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan unban.');
        }
    }
}

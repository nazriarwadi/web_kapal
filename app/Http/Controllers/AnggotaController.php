<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Regu;
use App\Models\Profesi;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data anggota beserta relasi regu dan profesi
        $anggota = Anggota::with(['regu', 'profesi'])->get();
        return view('anggota.index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data regu dan profesi untuk dropdown
        $regu = Regu::all();
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
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'regu_id.required' => 'Regu wajib dipilih.',
            'regu_id.exists' => 'Regu yang dipilih tidak valid.',
            'profesi_id.required' => 'Profesi wajib dipilih.',
            'profesi_id.exists' => 'Profesi yang dipilih tidak valid.',
        ]);

        // Simpan data anggota baru
        Anggota::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
            'regu_id' => $request->regu_id,
            'profesi_id' => $request->profesi_id,
        ]);

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
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
    public function destroy(Anggota $anggota)
    {
        // Hapus data anggota
        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;
use App\Models\Regu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informasi = Informasi::with('regu')->get();
        return view('informasi.index', compact('informasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regu = Regu::all();
        return view('informasi.create', compact('regu'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Log seluruh request data
        Log::info('Request data untuk store informasi:', $request->all());

        // Validasi input
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bawaan' => 'required|string',
            'kebarangkatan' => 'required|string',
            'jam_sampai' => 'required|date_format:Y-m-d H:i', // Validasi format DATETIME
            'regu_id' => 'required|exists:regu,id',
        ]);

        try {
            // Simpan gambar ke folder public/storage/image_informasi
            $gambarPath = $request->file('gambar')->store('image_informasi', 'public');

            // Log path gambar yang disimpan
            Log::info('File gambar berhasil disimpan:', ['path' => $gambarPath]);

            // Simpan data informasi
            $informasi = Informasi::create([
                'gambar' => $gambarPath,
                'bawaan' => $request->bawaan,
                'kebarangkatan' => $request->kebarangkatan,
                'jam_sampai' => $request->jam_sampai . ':00', // Tambahkan detik untuk format DATETIME
                'regu_id' => $request->regu_id,
            ]);

            // Log data yang berhasil disimpan
            Log::info('Data informasi berhasil disimpan:', $informasi->toArray());

            return redirect()->route('informasi.index')
                ->with('success', 'Informasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Log error jika terjadi kegagalan
            Log::error('Gagal menyimpan data informasi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Redirect kembali dengan pesan error
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan informasi. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Informasi $informasi)
    {
        return view('informasi.show', compact('informasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informasi $informasi)
    {
        $regu = Regu::all();
        return view('informasi.edit', compact('informasi', 'regu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informasi $informasi)
    {
        // Validasi input
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bawaan' => 'required|string',
            'kebarangkatan' => 'required|string',
            'jam_sampai' => 'required|date_format:Y-m-d H:i', // Pastikan format sesuai
            'regu_id' => 'required|exists:regu,id',
        ]);

        // Jika ada gambar baru, hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($informasi->gambar);
            $gambarPath = $request->file('gambar')->store('image_informasi', 'public');
            $informasi->gambar = $gambarPath;
        }

        // Update data informasi
        $informasi->update([
            'bawaan' => $request->bawaan,
            'kebarangkatan' => $request->kebarangkatan,
            'jam_sampai' => $request->jam_sampai . ':00', // Pastikan format dengan detik
            'regu_id' => $request->regu_id,
        ]);

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informasi $informasi)
    {
        // Hapus gambar dari storage
        Storage::disk('public')->delete($informasi->gambar);

        // Hapus data informasi
        $informasi->delete();

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil dihapus.');
    }
}

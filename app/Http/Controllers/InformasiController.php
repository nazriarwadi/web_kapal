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
        // Ambil semua data informasi beserta relasi 'regus', dan urutkan secara descending
        $informasi = Informasi::with('regus')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending
            ->get();

        return view('informasi.index', compact('informasi'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
        $regu = Regu::all();
        $informasi = new Informasi(); // Menghindari error undefined variable

        return view('informasi.create', compact('regu', 'informasi'));
    }

    public function store(Request $request)
    {
        Log::info('Request data untuk store informasi:', $request->all());

        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bawaan' => 'required|string',
            'kebarangkatan' => 'required|string',
            'jam_sampai' => 'required|date_format:Y-m-d H:i',
            'status' => 'required|in:Selesai dikerjakan,Sedang dikerjakan,Belum dikerjakan',
            'regu_id' => 'required|array|min:1',
            'regu_id.*' => 'exists:regu,id',
        ]);

        try {
            $gambarPath = $request->file('gambar')->store('image_informasi', 'public');

            $informasi = Informasi::create([
                'gambar' => $gambarPath,
                'bawaan' => $request->bawaan,
                'kebarangkatan' => $request->kebarangkatan,
                'jam_sampai' => $request->jam_sampai . ':00',
                'status' => $request->status,
            ]);

            $reguIds = $request->input('regu_id', []);
            $informasi->regus()->sync($reguIds);

            return redirect()->route('informasi.index')->with('success', 'Informasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan informasi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Informasi $informasi)
    {
        $informasi->load('regus'); // Memuat relasi regus agar tidak terjadi lazy loading
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
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bawaan' => 'required|string',
            'kebarangkatan' => 'required|string',
            'jam_sampai' => 'required|date_format:Y-m-d H:i',
            'status' => 'required|in:Selesai dikerjakan,Sedang dikerjakan,Belum dikerjakan',
            'regu_id' => 'required|array|min:1',
            'regu_id.*' => 'exists:regu,id',
        ]);

        try {
            if ($request->hasFile('gambar')) {
                Storage::disk('public')->delete($informasi->gambar);
                $gambarPath = $request->file('gambar')->store('image_informasi', 'public');
                $informasi->gambar = $gambarPath;
            }

            $informasi->update([
                'bawaan' => $request->bawaan,
                'kebarangkatan' => $request->kebarangkatan,
                'jam_sampai' => $request->jam_sampai . ':00',
                'status' => $request->status,
            ]);

            $informasi->regus()->sync($request->regu_id);

            return redirect()->route('informasi.index')->with('success', 'Informasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui informasi.');
        }
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

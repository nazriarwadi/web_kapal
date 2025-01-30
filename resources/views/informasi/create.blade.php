@extends('layouts.app')

@section('title', 'Tambah Informasi')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Informasi</h1>
        <a href="{{ route('informasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="gambar">Gambar <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="gambar" name="gambar" required>
                        </div>
                        <div class="form-group">
                            <label for="bawaan">Bawaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bawaan" name="bawaan" required>
                        </div>
                        <div class="form-group">
                            <label for="kebarangkatan">Kebarangkatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="kebarangkatan" name="kebarangkatan" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_sampai">Waktu/Jam Sampai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="jam_sampai" name="jam_sampai" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="regu_id">Regu <span class="text-danger">*</span></label>
                            <select class="form-control" id="regu_id" name="regu_id" required>
                                <option value="" disabled selected>Pilih Regu</option>
                                @foreach ($regu as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_regu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan stylesheet dan script Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Inisialisasi Flatpickr untuk input tanggal dan waktu
            flatpickr("#jam_sampai", {
                enableTime: true,          // Aktifkan mode waktu
                dateFormat: "Y-m-d H:i",   // Format tanggal: Tahun-Bulan-Hari Jam:Menit
                time_24hr: true,           // Format 24 jam
            });
        });
    </script>
@endsection

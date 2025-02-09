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
                            <input type="text" class="form-control" id="bawaan" name="bawaan" required value="{{ old('bawaan') }}">
                        </div>
                        <div class="form-group">
                            <label for="kebarangkatan">Kebarangkatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="kebarangkatan" name="kebarangkatan" required value="{{ old('kebarangkatan') }}">
                        </div>
                        <div class="form-group">
                            <label for="jam_sampai">Waktu/Jam Sampai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="jam_sampai" name="jam_sampai" required value="{{ old('jam_sampai') }}">
                        </div>

                        <!-- Dropdown Status -->
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                @foreach (\App\Models\Informasi::getStatusOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilih Regu -->
                        <div class="form-group">
                            <label for="regu_select">Pilih Regu <span class="text-danger">*</span></label>
                            <select class="form-control" id="regu_select">
                                <option value="">-- Pilih Regu --</option>
                                @foreach ($regu as $item)
                                    <option value="{{ $item->id }}" data-name="{{ $item->nama_regu }}">
                                        {{ $item->nama_regu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- List Regu yang Dipilih -->
                        <div class="form-group">
                            <label>Regu yang Dipilih:</label>
                            <ul id="selected-regu-list" class="list-group"></ul>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan Flatpickr untuk DateTime Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#jam_sampai", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
            });

            // Tambah Regu ke Daftar
            $('#regu_select').on('change', function() {
                let reguId = $(this).val();
                let reguNama = $(this).find('option:selected').data('name');

                if (reguId) {
                    let reguItem = `<li class="list-group-item d-flex justify-content-between align-items-center" data-id="${reguId}">
                        ${reguNama}
                        <input type="hidden" name="regu_id[]" value="${reguId}">
                        <button type="button" class="btn btn-sm btn-danger remove-regu">
                            <i class="fas fa-times"></i>
                        </button>
                    </li>`;

                    $('#selected-regu-list').append(reguItem);

                    // Hapus dari dropdown setelah dipilih
                    $(this).find('option[value="' + reguId + '"]').remove();
                }

                // Reset pilihan dropdown
                $(this).val('');
            });

            // Hapus Regu dari Daftar dan Tambahkan Kembali ke Dropdown
            $(document).on('click', '.remove-regu', function() {
                let reguItem = $(this).closest('li');
                let reguId = reguItem.data('id');
                let reguNama = reguItem.text().trim();

                // Kembalikan regu ke dropdown
                $('#regu_select').append(
                    `<option value="${reguId}" data-name="${reguNama}">${reguNama}</option>`);

                // Hapus dari daftar yang dipilih
                reguItem.remove();
            });
        });
    </script>
@endsection

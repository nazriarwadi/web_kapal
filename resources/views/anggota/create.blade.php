@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Anggota</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('anggota.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            <small class="form-text text-muted">Hanya boleh mengandung huruf dan spasi.</small>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telp <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="no_telp" name="no_telp" required>
                            <small class="form-text text-muted">Minimal 10 digit, maksimal 15 digit, dan hanya boleh mengandung angka.</small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <small class="form-text text-muted">Format email harus valid dan unik.</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="form-text text-muted">Minimal 8 karakter.</small>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            <small class="form-text text-muted">Harus sama dengan password.</small>
                        </div>
                        <div class="form-group">
                            <label for="regu_id">Regu <span class="text-danger">*</span></label>
                            <select class="form-control @error('regu_id') is-invalid @enderror" id="regu_id" name="regu_id" required>
                                <option value="" selected disabled>Pilih Regu</option>
                                @foreach ($regu as $item)
                                    <option value="{{ $item->id }}" data-jumlah="{{ $item->anggota_count }}">
                                        {{ $item->nama_regu }} ({{ $item->anggota_count }}/6)
                                    </option>
                                @endforeach
                            </select>
                            <small id="regu_warning" class="text-danger" style="display: none;">Regu ini sudah penuh, pilih regu lain.</small>
                        
                            @error('regu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        
                        <div class="form-group">
                            <label for="profesi_id">Profesi <span class="text-danger">*</span></label>
                            <select class="form-control" id="profesi_id" name="profesi_id" required>
                                <option value="" selected disabled>Pilih Profesi</option> <!-- Opsi default -->
                                @foreach ($profesi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_profesi }}</option>
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
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#regu_id").change(function() {
            var jumlahAnggota = $("#regu_id option:selected").data("jumlah");

            if (jumlahAnggota >= 6) {
                $("#regu_warning").show();
                $("#regu_id").val(""); // Reset pilihan regu
            } else {
                $("#regu_warning").hide();
            }
        });
    });
</script>
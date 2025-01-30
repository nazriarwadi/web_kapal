@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Anggota</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $anggota->nama }}" required>
                            <small class="form-text text-muted">Hanya boleh mengandung huruf dan spasi.</small>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telp <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="no_telp" name="no_telp" value="{{ $anggota->no_telp }}" required>
                            <small class="form-text text-muted">Minimal 10 digit, maksimal 15 digit, dan hanya boleh mengandung angka.</small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $anggota->email }}" required>
                            <small class="form-text text-muted">Format email harus valid dan unik.</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Minimal 8 karakter.</small>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            <small class="form-text text-muted">Harus sama dengan password jika diisi.</small>
                        </div>
                        <div class="form-group">
                            <label for="regu_id">Regu <span class="text-danger">*</span></label>
                            <select class="form-control" id="regu_id" name="regu_id" required>
                                <option value="" disabled>Pilih Regu</option> <!-- Opsi default -->
                                @foreach ($regu as $item)
                                    <option value="{{ $item->id }}" {{ $anggota->regu_id == $item->id ? 'selected' : '' }}>{{ $item->nama_regu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="profesi_id">Profesi <span class="text-danger">*</span></label>
                            <select class="form-control" id="profesi_id" name="profesi_id" required>
                                <option value="" disabled>Pilih Profesi</option> <!-- Opsi default -->
                                @foreach ($profesi as $item)
                                    <option value="{{ $item->id }}" {{ $anggota->profesi_id == $item->id ? 'selected' : '' }}>{{ $item->nama_profesi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
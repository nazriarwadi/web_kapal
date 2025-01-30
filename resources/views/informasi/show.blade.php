@extends('layouts.app')

@section('title', 'Detail Informasi')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Informasi</h1>
        <a href="{{ route('informasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label>Gambar</label>
                        <div>
                            <img src="{{ asset('storage/' . $informasi->gambar) }}" alt="Gambar Informasi" width="200">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bawaan</label>
                        <p>{{ $informasi->bawaan }}</p>
                    </div>
                    <div class="form-group">
                        <label>Kebarangkatan</label>
                        <p>{{ $informasi->kebarangkatan }}</p>
                    </div>
                    <div class="form-group">
                        <label>Waktu/Jam Sampai</label>
                        <p>
                            {{ \Carbon\Carbon::parse($informasi->jam_sampai)
                                ->locale('id') // Set locale ke Indonesia
                                ->translatedFormat('d F Y, \j\a\m H:i') }}
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Regu</label>
                        <p>{{ $informasi->regu->nama_regu }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
                    <div class="form-group border-bottom pb-3">
                        <label class="font-weight-bold">Gambar</label>
                        <div>
                            <img src="{{ asset('storage/' . $informasi->gambar) }}" alt="Gambar Informasi" width="200" class="rounded shadow">
                        </div>
                    </div>
                    
                    <div class="form-group border-bottom pb-3">
                        <label class="font-weight-bold">Bawaan</label>
                        <p class="mb-0">{{ $informasi->bawaan }}</p>
                    </div>

                    <div class="form-group border-bottom pb-3">
                        <label class="font-weight-bold">Kebarangkatan</label>
                        <p class="mb-0">{{ $informasi->kebarangkatan }}</p>
                    </div>

                    <div class="form-group border-bottom pb-3">
                        <label class="font-weight-bold">Waktu/Jam Sampai</label>
                        <p class="mb-0">
                            {{ \Carbon\Carbon::parse($informasi->jam_sampai)
                                ->locale('id')
                                ->translatedFormat('d F Y, \j\a\m H:i') }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="form-group border-bottom pb-3">
                        <label class="font-weight-bold">Status</label>
                        <p class="mb-0">
                            @if ($informasi->status == 'Selesai dikerjakan')
                                <span class="badge badge-success">Selesai dikerjakan</span>
                            @elseif ($informasi->status == 'Sedang dikerjakan')
                                <span class="badge badge-warning">Sedang dikerjakan</span>
                            @else
                                <span class="badge badge-danger">Belum dikerjakan</span>
                            @endif
                        </p>
                    </div>

                    <!-- Regu -->
                    <div class="form-group">
                        <label class="font-weight-bold">Regu</label>
                        <p class="mb-0">
                            @if($informasi->regus->isNotEmpty()) 
                                @foreach($informasi->regus as $regu)
                                    <span class="badge badge-primary">{{ $regu->nama_regu }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Tidak ada regu</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Daftar Informasi')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Informasi</h1>
        <a href="{{ route('informasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Informasi
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Bawaan</th>
                                    <th>Kebarangkatan</th>
                                    <th>Waktu/Jam Sampai</th>
                                    <th>Regu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informasi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Informasi" width="100">
                                        </td>
                                        <td>{{ $item->bawaan }}</td>
                                        <td>{{ $item->kebarangkatan }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->jam_sampai)
                                                ->locale('id') // Set locale ke Indonesia
                                                ->translatedFormat('d F Y, \j\a\m H:i') }}
                                        </td>                                       
                                        <td>{{ $item->regu->nama_regu }}</td>
                                        <td>
                                            <!-- Tombol Show -->
                                            <a href="{{ route('informasi.show', $item->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('informasi.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <!-- Tombol Delete -->
                                            <form action="{{ route('informasi.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

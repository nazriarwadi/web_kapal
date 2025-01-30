@extends('layouts.app')

@section('title', 'Daftar Absensi')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Absensi</h1>
        <a href="{{ route('absensi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Absensi
        </a>
    </div>

    <!-- Filter berdasarkan bulan dan tahun -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="form-group">
                <label for="bulan">Bulan</label>
                <select class="form-control" id="bulan" name="bulan">
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <select class="form-control" id="tahun" name="tahun">
                    <option value="">Pilih Tahun</option>
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" id="filterButton" class="btn btn-primary mt-4">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Profesi</th>
                                    <th>Regu</th>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Lembur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->anggota->nama }}</td>
                                        <td>{{ $item->profesi->nama_profesi }}</td>
                                        <td>{{ $item->regu->nama_regu }}</td>
                                        <td>{{ $item->hadir }}</td>
                                        <td>{{ $item->izin }}</td>
                                        <td>{{ $item->lembur }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk filter data -->
    <script>
        document.getElementById('filterButton').addEventListener('click', function() {
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;

            // Redirect ke halaman yang sama dengan query parameter bulan dan tahun
            window.location.href = "{{ route('absensi.index') }}?bulan=" + bulan + "&tahun=" + tahun;
        });
    </script>

    <!-- Tampilkan pesan sukses dengan Toastr -->
    @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}", "Sukses", {
                positionClass: "toast-bottom-right",
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
        </script>
    @endif
@endsection
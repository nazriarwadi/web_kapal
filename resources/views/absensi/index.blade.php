@extends('layouts.app')

@section('title', 'Daftar Absensi')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Absensi</h1>
        <div>
            <a href="{{ route('absensi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Absensi
            </a>
            {{-- <button class="btn btn-success" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button> --}}
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <!-- Filter Bulan -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="bulan">Bulan</label>
                <input type="month" class="form-control" id="bulan"
                    value="{{ request('bulan', now()->format('Y-m')) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="anggota">Nama Anggota</label>
                <select class="form-control" id="anggota">
                    <option value="">Semua Anggota</option>
                    @foreach ($allAnggota as $anggota)
                        <option value="{{ $anggota->id }}" {{ request('anggota') == $anggota->id ? 'selected' : '' }}>
                            {{ $anggota->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="regu">Regu</label>
                <select class="form-control" id="regu">
                    <option value="">Semua Regu</option>
                    @foreach ($allRegu as $regu)
                        <option value="{{ $regu->id }}" {{ request('regu') == $regu->id ? 'selected' : '' }}>
                            {{ $regu->nama_regu }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="form-group w-60">
                <label class="d-block">&nbsp;</label>
                <button type="button" id="filterButton" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </div>


    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Hadir
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalHadir }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Izin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalIzin }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Lembur
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLembur }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-injured fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Profesi</th>
                            <th>Regu</th>
                            <th>Tanggal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Lembur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->anggota->nama }}</td>
                                <td>{{ $item->profesi->nama_profesi }}</td>
                                <td>{{ $item->regu->nama_regu }}</td>
                                <td>{{ $item->tanggal_absensi ? $item->tanggal_absensi->format('d M Y') : '-' }}</td>
                                <td class="text-center">
                                    @if ($item->hadir)
                                        <span class="badge badge-success p-2">Hadir</span>
                                    @elseif($item->izin)
                                        <span class="badge badge-warning p-2">Izin</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->lembur)
                                        <span class="badge badge-info p-2">{{ $item->lembur }} Hari</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between mt-4">
                <div class="text-muted">
                    Menampilkan {{ $absensi->firstItem() }} - {{ $absensi->lastItem() }} dari {{ $absensi->total() }}
                    entri
                </div>
                {{ $absensi->links() }}
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bulanInput = document.getElementById('bulan');

            // Jika tidak ada parameter bulan di URL, gunakan default bulan ini
            if (!new URLSearchParams(window.location.search).has('bulan')) {
                const bulanSekarang = new Date().toISOString().slice(0, 7); // Format YYYY-MM
                window.location.href = `{{ route('absensi.index') }}?bulan=${bulanSekarang}`;
            }
        });

        // Filter Handling
        document.getElementById('filterButton').addEventListener('click', function() {
            const params = new URLSearchParams({
                bulan: document.getElementById('bulan').value,
                anggota: document.getElementById('anggota').value,
                regu: document.getElementById('regu').value
            });

            window.location.href = `{{ route('absensi.index') }}?${params.toString()}`;
        });

        // Toastr Notification
        @if (session('success'))
            toastr.success("{{ session('success') }}", "Sukses", {
                positionClass: "toast-bottom-right",
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
        @endif
    </script>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fc;
            cursor: pointer;
        }

        .badge {
            min-width: 70px;
        }
    </style>
@endsection

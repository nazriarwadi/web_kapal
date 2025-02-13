@extends('layouts.app')
@section('title', 'Daftar Slip Gaji')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Slip Gaji</h1>
        <a href="{{ route('gaji.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Slip Gaji
        </a>
    </div>

    <!-- Filter berdasarkan regu dan bulan -->
    <div class="row mb-2">
        <div class="col-md-2">
            <div class="form-group">
                <label for="regu_filter">Pilih Regu</label>
                <select class="form-control" id="regu_filter" name="regu_filter">
                    <option value="">Semua Regu</option>
                    @foreach ($regu as $item)
                        <option value="{{ $item->id }}" {{ request('regu_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_regu }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="bulan_filter">Pilih Bulan</label>
                <select class="form-control" id="bulan_filter" name="bulan_filter">
                    <option value="">Semua Bulan</option>
                    @php
                        $months = [
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maret',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Agustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember',
                        ];
                    @endphp
                    @foreach ($months as $key => $month)
                        <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-auto ml-auto">
            <div class="form-group">
                <label>&nbsp;</label>
                <button class="btn btn-success form-control" onclick="printData()">
                    <i class="fas fa-print"></i> Print Data
                </button>
            </div>
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
                                    <th>Gaji</th>
                                    <th>Bulan Gaji</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($slipGaji as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->anggota->nama }}</td>
                                        <td>{{ $item->profesi->nama_profesi }}</td>
                                        <td>{{ $item->regu->nama_regu }}</td>
                                        <td>{{ $item->hadir }}</td>
                                        <td>{{ $item->izin }}</td>
                                        <td>{{ $item->lembur }}</td>
                                        <td>Rp. {{ number_format($item->gaji, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('MMMM') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk filter data otomatis -->
    <script>
        document.getElementById('regu_filter').addEventListener('change', function() {
            const reguId = this.value;
            const bulan = document.getElementById('bulan_filter').value;
            // Redirect ke halaman yang sama dengan query parameter regu_id dan bulan
            window.location.href = "{{ route('gaji.index') }}?regu_id=" + reguId + "&bulan=" + bulan;
        });

        document.getElementById('bulan_filter').addEventListener('change', function() {
            const bulan = this.value;
            const reguId = document.getElementById('regu_filter').value;
            // Redirect ke halaman yang sama dengan query parameter regu_id dan bulan
            window.location.href = "{{ route('gaji.index') }}?regu_id=" + reguId + "&bulan=" + bulan;
        });

        function printData() {
            const reguId = document.getElementById('regu_filter').value;
            const bulan = document.getElementById('bulan_filter').value;
            // Redirect ke route print dengan query parameter regu_id dan bulan
            window.location.href = "{{ route('gaji.print') }}?regu_id=" + reguId + "&bulan=" + bulan;
        }
    </script>
@endsection
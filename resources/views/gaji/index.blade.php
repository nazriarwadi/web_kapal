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

    <!-- Filter berdasarkan regu -->
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
                                    <th>Aksi</th>
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
                                        <td>
                                            <a href="{{ route('gaji.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('gaji.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
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

    <!-- JavaScript untuk filter data otomatis -->
    <script>
        document.getElementById('regu_filter').addEventListener('change', function() {
            const reguId = this.value;

            // Redirect ke halaman yang sama dengan query parameter regu_id
            window.location.href = "{{ route('gaji.index') }}?regu_id=" + reguId;
        });
    </script>

    <!-- Toastr Notification -->
    <script>
        $(document).ready(function() {
            // Tampilkan toastr success jika ada session success
            @if (session('success'))
                toastr.success("{{ session('success') }}", "Sukses", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right",
                    timeOut: 3000, // Muncul selama 3 detik
                });
            @endif

            // Tampilkan toastr error jika ada session error
            @if (session('error'))
                toastr.error("{{ session('error') }}", "Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right",
                    timeOut: 3000, // Muncul selama 3 detik
                });
            @endif
        });
    </script>
@endsection
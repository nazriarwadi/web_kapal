@extends('layouts.app')
@section('title', 'Daftar Anggota')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Anggota</h1>
        <a href="{{ route('anggota.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
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
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Email</th>
                                    <th>Regu</th>
                                    <th>Profesi</th>
                                    <th>Status Banned</th>
                                    <th>Banned Sampai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggota as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->no_telp }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->regu->nama_regu }}</td>
                                        <td>{{ $item->profesi->nama_profesi }}</td>
                                        <td>
                                            @if ($item->is_banned)
                                                <span class="badge badge-danger">Banned</span>
                                            @else
                                                <span class="badge badge-success">Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->is_banned)
                                                {{ \Carbon\Carbon::parse($item->banned_until)->format('d-m-Y H:i') }}
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('anggota.edit', $item->id) }}" class="btn btn-sm btn-warning mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if (!$item->is_banned)
                                                <!-- Dropdown Durasi Ban -->
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <form action="{{ route('anggota.ban', $item->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="ban_duration" value="1">
                                                            <button type="submit" class="dropdown-item">Ban 1 Hari</button>
                                                        </form>
                                                        <form action="{{ route('anggota.ban', $item->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="ban_duration" value="3">
                                                            <button type="submit" class="dropdown-item">Ban 3 Hari</button>
                                                        </form>
                                                        <form action="{{ route('anggota.ban', $item->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="ban_duration" value="7">
                                                            <button type="submit" class="dropdown-item">Ban 7 Hari</button>
                                                        </form>
                                                        <form action="{{ route('anggota.ban', $item->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="ban_duration" value="30">
                                                            <button type="submit" class="dropdown-item">Ban 30 Hari</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Form Inline untuk Unban -->
                                                <form action="{{ route('anggota.unban', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
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

@section('scripts')
    <!-- Auto-refresh page every 5 minutes (optional) -->
    <script>
        setInterval(function() {
            location.reload();
        }, 300000);
    </script>
@endsection
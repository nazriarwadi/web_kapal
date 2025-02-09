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
                                        <td>
                                            <a href="{{ route('anggota.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if (!$item->is_banned)
                                                <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#banModal" data-id="{{ $item->id }}">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <form action="{{ route('anggota.unban', $item->id) }}" method="POST"
                                                    style="display:inline;">
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

    <!-- Modal untuk memilih durasi banned -->
    <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="banModalLabel">Pilih Durasi Banned</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('anggota.ban', $anggota) }}" method="POST" id="banForm">
                    @csrf
                    <div class="modal-body">
                        <label for="ban_duration">Durasi Banned:</label>
                        <select name="ban_duration" id="ban_duration" class="form-control" required>
                            <option value="">Pilih Durasi</option>
                            <option value="1">1 Hari</option>
                            <option value="3">3 Hari</option>
                            <option value="7">7 Hari</option>
                            <option value="30">30 Hari</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Banned</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#banModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var anggotaId = button.data('id');
            var modal = $(this);

            var formAction = '/anggota/' + anggotaId + '/ban';
            modal.find('#banForm').attr('action', formAction);
        });

        // Auto refresh halaman setiap 5 menit agar banned otomatis diperbarui
        setInterval(function() {
            location.reload();
        }, 300000); // 300000ms = 5 menit
    </script>

@endsection

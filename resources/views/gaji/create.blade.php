@extends('layouts.app')

@section('title', 'Tambah Slip Gaji')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Slip Gaji</h1>
        <a href="{{ route('gaji.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('gaji.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="anggota_id">Nama Anggota <span class="text-danger">*</span></label>
                            <select class="form-control" id="anggota_id" name="anggota_id" required>
                                <option value="" selected disabled>Pilih Anggota</option>
                                @foreach ($anggota as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="profesi_id">Profesi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="profesi_name" value="" readonly>
                            <input type="hidden" id="profesi_id" name="profesi_id" value="">
                        </div>
                        <div class="form-group">
                            <label for="regu_id">Regu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="regu_name" value="" readonly>
                            <input type="hidden" id="regu_id" name="regu_id" value="">
                        </div>                        
                        <div class="form-group">
                            <label for="hadir">Hadir <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="hadir" name="hadir" value="0" readonly>
                        </div>
                        <div class="form-group">
                            <label for="izin">Izin <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="izin" name="izin" value="0" readonly>
                        </div>
                        <div class="form-group">
                            <label for="lembur">Lembur <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="lembur" name="lembur" value="0" readonly>
                        </div>
                        <div class="form-group">
                            <label for="gaji">Gaji <span class="text-danger">*</span></label>
                            <div style="position: relative;">
                                <input type="text" class="form-control" id="gaji" name="gaji" required
                                    style="padding-left: 30px;">
                                <span
                                    style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">Rp.</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function getAnggotaData(anggotaId) {
                if (anggotaId) {
                    $.ajax({
                        url: '/get-anggota-data/' + anggotaId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#profesi_name').val(data.profesi.nama_profesi);
                            $('#regu_name').val(data.regu.nama_regu);
                            $('#hadir').val(data.hadir || 0); // Default ke 0 jika kosong
                            $('#izin').val(data.izin || 0);
                            $('#lembur').val(data.lembur || 0);

                            // Update hidden inputs
                            $('#profesi_id').val(data.profesi.id);
                            $('#regu_id').val(data.regu.id);
                        }
                    });
                }
            }

            $('#anggota_id').change(function() {
                var anggotaId = $(this).val();
                getAnggotaData(anggotaId);
            });

            // Ambil data anggota saat halaman pertama kali dimuat
            var initialAnggotaId = $('#anggota_id').val();
            getAnggotaData(initialAnggotaId);
        });
    </script>
@endsection

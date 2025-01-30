@extends('layouts.app')

@section('title', 'Edit Slip Gaji')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Slip Gaji</h1>
        <a href="{{ route('gaji.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('gaji.update', $slipGaji->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="anggota_id">Nama Anggota <span class="text-danger">*</span></label>
                            <select class="form-control" id="anggota_id" name="anggota_id" required>
                                <option value="" disabled>Pilih Anggota</option>
                                @foreach ($anggota as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $slipGaji->anggota_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="profesi_name">Profesi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="profesi_name"
                                value="{{ $slipGaji->profesi->nama_profesi }}" readonly>
                            <input type="hidden" id="profesi_id" name="profesi_id" value="{{ $slipGaji->profesi_id }}">
                        </div>
                        <div class="form-group">
                            <label for="regu_name">Regu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="regu_name"
                                value="{{ $slipGaji->regu->nama_regu }}" readonly>
                            <input type="hidden" id="regu_id" name="regu_id" value="{{ $slipGaji->regu_id }}">
                        </div>
                        <div class="form-group">
                            <label for="hadir">Hadir <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="hadir" name="hadir"
                                value="{{ $slipGaji->hadir }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="izin">Izin <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="izin" name="izin"
                                value="{{ $slipGaji->izin }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="lembur">Lembur <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="lembur" name="lembur"
                                value="{{ $slipGaji->lembur }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="gaji">Gaji <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="gaji" name="gaji"
                                value="{{ number_format($slipGaji->gaji, 2, ',', '.') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
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
                            // Update nilai pada input readonly
                            $('#profesi_name').val(data.profesi.nama_profesi);
                            $('#regu_name').val(data.regu.nama_regu);

                            // Update nilai pada hidden input
                            $('#profesi_id').val(data.profesi.id);
                            $('#regu_id').val(data.regu.id);

                            // Update kolom hadir, izin, dan lembur jika diperlukan
                            $('#hadir').val(data.hadir || 0);
                            $('#izin').val(data.izin || 0);
                            $('#lembur').val(data.lembur || 0);
                        }
                    });
                }
            }

            // Trigger perubahan saat dropdown anggota berubah
            $('#anggota_id').change(function() {
                var anggotaId = $(this).val();
                getAnggotaData(anggotaId);
            });

            // Ambil data anggota saat halaman pertama kali dimuat
            var initialAnggotaId = $('#anggota_id').val();
            getAnggotaData(initialAnggotaId);
        });
    </script>

    <!-- Script untuk format mata uang Rupiah -->
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script>
        var cleave = new Cleave('#gaji', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            delimiter: '.',
            numeralDecimalMark: ',',
            numeralIntegerScale: 14,
            numeralDecimalScale: 2
        });
    </script>
@endsection

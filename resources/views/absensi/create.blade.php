@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Absensi</h1>
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Dropdown untuk memilih regu -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="form-group">
                <label for="regu_filter">Pilih Regu</label>
                <select class="form-control" id="regu_filter" name="regu_filter">
                    <option value="all" selected>Semua Regu</option>
                    @foreach ($regu as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_regu }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Tabel untuk menampilkan data anggota berdasarkan regu -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('absensi.store') }}" method="POST" id="absensiForm">
                        @csrf
                        <!-- Dalam file blade template create -->
                        <table class="table table-bordered" id="anggotaTable">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama</th>
                                    <th>Profesi</th>
                                    <th>Regu</th>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Lembur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggotaBelumAbsen as $index => $anggota)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $anggota->nama }}</td>
                                        <td>{{ $anggota->profesi->nama_profesi }}</td>
                                        <td>{{ $anggota->regu->nama_regu }}</td>
                                        <td><input type="checkbox" name="hadir[]" value="{{ $anggota->id }}"
                                                onclick="handleCheckbox(this, 'hadir')"></td>
                                        <td><input type="checkbox" name="izin[]" value="{{ $anggota->id }}"
                                                onclick="handleCheckbox(this, 'izin')"></td>
                                        <td><input type="checkbox" name="lembur[]" value="{{ $anggota->id }}"
                                                onclick="handleCheckbox(this, 'lembur')"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk mengambil dan menampilkan data anggota berdasarkan regu -->
    <script>
        function loadAnggota(reguId) {
            const tableBody = document.querySelector('#anggotaTable tbody');
            tableBody.innerHTML = '';

            fetch(`/get-anggota-by-regu/${reguId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach((anggota, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${anggota.nama}</td>
                            <td>${anggota.profesi.nama_profesi}</td>
                            <td>${anggota.regu.nama_regu}</td>
                            <td><input type="checkbox" name="hadir[]" value="${anggota.id}" onclick="handleCheckbox(this, 'hadir')"></td>
                            <td><input type="checkbox" name="izin[]" value="${anggota.id}" onclick="handleCheckbox(this, 'izin')"></td>
                            <td><input type="checkbox" name="lembur[]" value="${anggota.id}" onclick="handleCheckbox(this, 'lembur')"></td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        document.getElementById('regu_filter').addEventListener('change', function() {
            const reguId = this.value;
            loadAnggota(reguId);
        });

        // Load semua anggota saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function() {
            loadAnggota('all');
        });

        // Fungsi untuk memastikan hanya satu checkbox yang dicentang per baris
        function handleCheckbox(checkbox, type) {
            const row = checkbox.closest('tr');
            const checkboxes = row.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
        }

        // Fungsi untuk mengirim data ke server
        document.getElementById('absensiForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const data = {
                hadir: [],
                izin: [],
                lembur: []
            };

            // Ambil semua checkbox yang dicentang
            document.querySelectorAll('input[name="hadir[]"]:checked').forEach(checkbox => {
                data.hadir.push(checkbox.value);
            });

            document.querySelectorAll('input[name="izin[]"]:checked').forEach(checkbox => {
                data.izin.push(checkbox.value);
            });

            document.querySelectorAll('input[name="lembur[]"]:checked').forEach(checkbox => {
                data.lembur.push(checkbox.value);
            });

            console.log(data); // Debugging: Periksa data yang dikirim

            // Kirim data ke server
            fetch("{{ route('absensi.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Redirect ke halaman absensi.index
                        window.location.href = result.redirect_url;
                    } else {
                        alert('Gagal menyimpan data.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data.');
                });
        });
    </script>
@endsection

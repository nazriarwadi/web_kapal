<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/sb-admin/img/ship.png') }}" alt="Logo Perusahaan" style="max-width: 120px; margin-bottom: 10px;">
        <h1>PT. Tenaga Kerja Bongkar Muat</h1>
        <p>Jl. Awang Mahmuda. 123, Bengkalis, Indonesia</p>
        <p>Telp: (021) 123-456 | Email: tkbm@gmail.com</p>
        <hr>
        <p><strong>Slip Gaji - {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</strong></p>
    </div>

    <table>
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
                    <td>Rp. {{ number_format($item->gaji, 0) }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('MMMM YYYY') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengangkutan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 { margin: 0; text-transform: uppercase; }
        h4 { margin: 5px 0 0; font-weight: normal; }

        hr { border: 0; border-top: 2px solid #000; margin: 15px 0; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 8px;
        }

        table th {
            background: #f4f4f4;
            text-align: center;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .rekap {
            margin-top: 30px;
            width: 300px;
        }

        .rekap td {
            border: 1px solid #ccc;
            padding: 5px 10px;
        }

        .ttd-container {
            margin-top: 50px;
            width: 100%;
        }

        .ttd-box {
            float: right;
            width: 200px;
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>Dinas Lingkungan Hidup</h2>
        <h2>Kabupaten Jayapura</h2>
        <h4>LAPORAN PENGANGKUTAN SAMPAH</h4>
    </div>

    <hr>

    @if($tanggalAwal && $tanggalAkhir)
    <p>Periode: <strong>{{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}</strong></p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Driver</th>
                <th>Kendaraan</th>
                <th>TPS</th>
                <th>Muatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengangkutans as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->driver->nama }}</td>
                <td>{{ $item->optimasi->kendaraan->nama_kendaraan }}</td>
                <td class="text-center">{{ $item->details->count() }}</td>
                <td class="text-right">{{ number_format($item->muatan_sekarang, 0) }} Kg</td>
                <td class="text-center">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="rekap">
        <tr>
            <td width="60%"><strong>Total Pengangkutan</strong></td>
            <td class="text-right">{{ $totalPengangkutan }}</td>
        </tr>
        <tr>
            <td><strong>Total TPS</strong></td>
            <td class="text-right">{{ $totalTPS }}</td>
        </tr>
        <tr>
            <td><strong>Total Sampah</strong></td>
            <td class="text-right"><strong>{{ number_format($totalSampah, 0) }} Kg</strong></td>
        </tr>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            Jayapura, {{ now()->format('d F Y') }}
            <br><br><br><br>
            <strong>Administrator</strong>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
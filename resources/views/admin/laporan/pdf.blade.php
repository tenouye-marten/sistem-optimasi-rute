<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px; /* Ditingkatkan sedikit untuk keterbacaan */
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h2, h3 {
            margin: 0;
            text-transform: uppercase;
        }

        hr {
            border: 0;
            border-top: 2px solid #000;
            margin: 10px 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        /* Tabel Info (Tanpa Border) */
        .info { width: 100%; }
        .info td {
            border: none;
            padding: 3px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .rekap {
            width: 300px;
            margin-top: 10px;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Dinas Lingkungan Hidup</h2>
        <h3>Kabupaten Jayapura</h3>
    </div>
    
    <hr>

    <div style="text-align: center; font-weight: bold; margin-bottom: 15px;">
        LAPORAN PENGANGKUTAN SAMPAH
    </div>

    <table class="info">
        <tr>
            <td width="15%"><strong>Periode</strong></td>
            <td width="45%">: 
                @if($tanggalAwal && $tanggalAkhir)
                    {{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
                @else
                    Semua Data
                @endif
            </td>
            <td width="15%"><strong>Dicetak</strong></td>
            <td>: {{ now()->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th>Driver</th>
                <th>Kendaraan</th>
                <th width="8%">TPS</th>
                <th width="15%">Muatan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengangkutans as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ optional($item->driver)->nama }}</td>
                <td>{{ optional(optional($item->optimasi)->kendaraan)->nama_kendaraan }}</td>
                <td class="text-center">{{ $item->details->count() }}</td>
                <td class="text-right">{{ number_format($item->muatan_sekarang, 0) }} Kg</td>
                <td class="text-center">{{ $item->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="rekap">
        <tr>
            <td style="border:none"><strong>Total Pengangkutan</strong></td>
            <td style="border:none" class="text-right">{{ $totalPengangkutan }}</td>
        </tr>
        <tr>
            <td style="border:none"><strong>Total TPS</strong></td>
            <td style="border:none" class="text-right">{{ $totalTPS }}</td>
        </tr>
        <tr>
            <td style="border:none"><strong>Total Sampah</strong></td>
            <td style="border:none" class="text-right"><strong>{{ number_format($totalSampah, 0) }} Kg</strong></td>
        </tr>
    </table>

    <div class="ttd">
        <div class="ttd-box">
            Jayapura, {{ now()->translatedFormat('d F Y') }}
            <br>
            <br>
            <br>
            <br>
            <strong>Administrator</strong>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
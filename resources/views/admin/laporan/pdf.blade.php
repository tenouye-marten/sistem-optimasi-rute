<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengangkutan Sampah - SIMPAS DLH</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #111;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #000;
        }

        .header h3 {
            margin: 0;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 2px 0;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            font-size: 9px;
            font-style: italic;
            color: #444;
        }

        .document-title {
            text-align: center;
            margin: 15px 0 10px;
        }

        .document-title h4 {
            margin: 0;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .document-title p {
            margin: 3px 0 0;
            font-size: 10px;
        }

        table.info-meta {
            width: 100%;
            margin-bottom: 12px;
            font-size: 10px;
            border-collapse: collapse;
        }

        table.info-meta td {
            border: none;
            padding: 2px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data-table th, table.data-table td {
            border: 1px solid #333;
            padding: 6px 8px;
        }

        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 9px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .summary-wrapper {
            width: 100%;
            margin-top: 15px;
        }

        table.rekap-table {
            width: 320px;
            border-collapse: collapse;
            float: left;
        }

        table.rekap-table td {
            border: 1px solid #666;
            padding: 4px 8px;
            font-size: 10px;
        }

        .ttd-box {
            float: right;
            width: 200px;
            text-align: center;
            font-size: 10px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div class="header">
        <h3>Pemerintah Kabupaten Jayapura</h3>
        <h2>Dinas Lingkungan Hidup</h2>
        <p>Jl. Raya Sentani - Depapre, Gunung Merah Sentani, Kabupaten Jayapura, Papua</p>
    </div>

    <!-- Judul Dokumen -->
    <div class="document-title">
        <h4>Laporan Rekapitulasi Pengangkutan Sampah</h4>
        @if($tanggalAwal && $tanggalAkhir)
            <p>Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}</p>
        @else
            <p>Periode: Seluruh Data Operasional</p>
        @endif
    </div>

    <!-- Info Metadata -->
    <table class="info-meta">
        <tr>
            <td width="15%"><strong>Dicetak Pada</strong></td>
            <td width="35%">: {{ now()->translatedFormat('d F Y - H:i') }} WIT</td>
            <td width="15%"><strong>Dicetak Oleh</strong></td>
            <td width="35%">: {{ auth()->user()->name ?? 'Administrator' }}</td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="22%">Driver</th>
                <th width="22%">Kendaraan</th>
                <th width="8%">TPS</th>
                <th width="15%">Total Muatan</th>
                <th width="16%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengangkutans as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ optional($item->driver)->nama ?? '-' }}</td>
                <td>{{ optional(optional($item->optimasi)->kendaraan)->nama_kendaraan ?? '-' }}</td>
                <td class="text-center font-bold">{{ optional($item->details)->count() ?? 0 }}</td>
                <td class="text-right font-bold">{{ number_format($item->total_sampah, 0, ',', '.') }} Kg</td>
                <td class="text-center">{{ $item->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pengangkutan yang sesuai filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary & Signature -->
    <div class="summary-wrapper">
        <table class="rekap-table">
            <tr>
                <td><strong>Total Task Pengangkutan</strong></td>
                <td class="text-right font-bold">{{ $totalPengangkutan }} Task</td>
            </tr>
            <tr>
                <td><strong>Total Titik TPS</strong></td>
                <td class="text-right font-bold">{{ $totalTPS }} Titik</td>
            </tr>
            <tr>
                <td><strong>Total Volume Sampah</strong></td>
                <td class="text-right font-bold">{{ number_format($totalSampah, 0, ',', '.') }} Kg</td>
            </tr>
        </table>

        <div class="ttd-box">
            Sentani, {{ now()->translatedFormat('d F Y') }}
            <br>
            <strong>Dinas Lingkungan Hidup</strong>
            <br><br><br><br>
            <span style="text-decoration: underline; font-weight: bold;">{{ auth()->user()->name ?? 'Administrator' }}</span><br>
            <span>NIP. ........................................</span>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
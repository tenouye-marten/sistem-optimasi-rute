<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengangkutan - SIMPAS DLH</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #111;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .kop-surat {
            text-align: center;
            position: relative;
            padding-bottom: 8px;
            border-bottom: 3px solid #000;
        }

        .kop-surat::after {
            content: "";
            display: block;
            border-bottom: 1px solid #000;
            margin-top: 2px;
        }

        .kop-surat h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-surat h2 {
            margin: 2px 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-surat p {
            margin: 0;
            font-size: 9pt;
            font-style: italic;
        }

        .document-title {
            text-align: center;
            margin: 20px 0 15px;
        }

        .document-title h4 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .document-title p {
            margin: 4px 0 0;
            font-size: 10pt;
        }

        .info-meta {
            width: 100%;
            margin-bottom: 12px;
            font-size: 10pt;
        }

        .info-meta td {
            padding: 2px 0;
            vertical-align: top;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table.data-table th, table.data-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-size: 10pt;
        }

        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 9pt;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }

        .summary-container {
            width: 100%;
            margin-top: 15px;
            display: table;
        }

        .rekap-box {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rekap-table td {
            border: 1px solid #555;
            padding: 5px 8px;
            font-size: 9.5pt;
        }

        .ttd-box {
            display: table-cell;
            width: 60%;
            text-align: right;
            vertical-align: top;
        }

        .ttd-wrapper {
            display: inline-block;
            text-align: center;
            width: 220px;
            font-size: 10pt;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <!-- Print Control Bar -->
    <div class="no-print" style="background: #1e293b; color: #fff; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-family: sans-serif;">
        <span style="font-weight: bold; font-size: 14px;">Pratinjau Cetak Laporan Pengangkutan</span>
        <div>
            <button onclick="window.print()" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; margin-right: 8px;">
                Cetak Sekarang
            </button>
            <button onclick="window.close()" style="background: #64748b; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Tutup
            </button>
        </div>
    </div>

    <!-- Kop Surat -->
    <div class="kop-surat">
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

    <!-- Info Meta -->
    <table class="info-meta">
        <tr>
            <td width="15%"><strong>Dicetak Pada</strong></td>
            <td width="35%">: {{ now()->translatedFormat('l, d F Y - H:i') }} WIT</td>
            <td width="15%"><strong>Dicetak Oleh</strong></td>
            <td width="35%">: {{ auth()->user()->name ?? 'Administrator' }}</td>
        </tr>
    </table>

    <!-- Table Data -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Driver</th>
                <th width="20%">Kendaraan</th>
                <th width="8%">Jumlah TPS</th>
                <th width="14%">Total Muatan</th>
                <th width="14%">Status</th>
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
    <div class="summary-container">
        <div class="rekap-box">
            <p class="font-bold" style="margin: 0 0 5px; font-size: 10pt;">Rekapitulasi Total:</p>
            <table class="rekap-table">
                <tr>
                    <td><strong>Total Pengangkutan</strong></td>
                    <td class="text-right font-bold">{{ $totalPengangkutan }} Task</td>
                </tr>
                <tr>
                    <td><strong>Total TPS Diangkut</strong></td>
                    <td class="text-right font-bold">{{ $totalTPS }} Titik</td>
                </tr>
                <tr>
                    <td><strong>Total Volume Sampah</strong></td>
                    <td class="text-right font-bold">{{ number_format($totalSampah, 0, ',', '.') }} Kg</td>
                </tr>
            </table>
        </div>

        <div class="ttd-box">
            <div class="ttd-wrapper">
                Sentani, {{ now()->translatedFormat('d F Y') }}
                <br>
                <strong>Dinas Lingkungan Hidup</strong>
                <br><br><br><br>
                <span style="text-decoration: underline; font-weight: bold;">{{ auth()->user()->name ?? 'Administrator' }}</span><br>
                <span>NIP. ........................................</span>
            </div>
        </div>
    </div>

</body>
</html>
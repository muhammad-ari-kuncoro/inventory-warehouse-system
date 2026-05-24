<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $titleDoc }} - {{ $gr->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 25px;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .content-table th {
            background-color: #f2f2f2;
            border: 1px solid #dddddd;
            padding: 8px;
            font-weight: bold;
            text-align: left;
            font-size: 11px;
        }

        .content-table td {
            border: 1px solid #dddddd;
            padding: 8px;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Tampilan Tanda Tangan */
        .signature-container {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
        }

        .signature-box {
            text-align: center;
            width: 33%;
            height: 80px;
            vertical-align: bottom;
        }
    </style>
</head>

<body>

    <!-- Header Dokumen / Kop Sederhana -->
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <span style="font-size: 14px; font-weight: bold;">INTERNAL WAREHOUSE MANAGEMENT</span><br>
                <small>Fabrication & Engineering Division</small>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: bottom;">
                <small>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</small>
            </td>
        </tr>
    </table>

    <div class="title">{{ $titleDoc }}</div>

    <!-- Informasi Utama Metadata GR -->
    <table class="info-table">
        <tr>
            <td style="width: 18%; font-weight: bold;">No. Dokumen GR</td>
            <td style="width: 2%;">:</td>
            <td style="width: 30%;">GR-{{ str_pad($gr->id, 5, '0', STR_PAD_LEFT) }}</td>

            <td style="width: 18%; font-weight: bold;">Nama Project</td>
            <td style="width: 2%;">:</td>
            <td style="width: 30%;">{{ $gr->project->nama_project ?? 'No Project Allocation' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tanggal Masuk</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($gr->created_at)->format('d F Y') }}</td>

            <td style="font-weight: bold;">No. JO Project</td>
            <td>:</td>
            <td>{{ $gr->project->no_jo_project ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Diterima Oleh</td>
            <td>:</td>
            <td>{{ $gr->user->name ?? 'Admin Gudang' }}</td>

            <td style="font-weight: bold;">Status Stok</td>
            <td>:</td>
            <td style="color: green; font-weight: bold; text-transform: uppercase;">{{ $gr->status }}</td>
        </tr>
    </table>

    <!-- Tabel Detail Item Barang Masuk -->
    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 20%;">Jenis Barang</th>
                <th style="width: 40%;">Nama Item / Deskripsi</th>
                <th style="width: 15%;" class="text-center">Qty Terima</th>
                <th style="width: 20%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gr->details as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="text-transform: capitalize;">{{ $detail->jenis_barang }}</td>
                    <td>
                        @if (str_contains(strtolower($detail->jenis_barang), 'material'))
                            <strong>{{ $detail->material->nama_material ?? 'Unknown' }}</strong>
                        @elseif(str_contains(strtolower($detail->jenis_barang), 'consumable'))
                            <strong>{{ $detail->consumable->nama_consumable ?? 'Unknown' }}</strong>
                        @elseif(str_contains(strtolower($detail->jenis_barang), 'machine'))
                            <strong>{{ $detail->machine->nama_mesin ?? 'Unknown' }}</strong>
                        @else
                            {{-- Failsafe: Jika jenis_barang tidak masuk kategori manapun, teks ini akan muncul --}}
                            <span style="color: red;">Jenis Tidak Diketahui ({{ $detail->jenis_barang }})</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $detail->quantity }} {{ $detail->quantity_jenis }}
                    </td>
                    <td>{{ $detail->keterangan_barang ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td class="signature-box">
                    <p>Diserahkan Oleh (Vendor),</p>
                    <br><br><br>
                    <p>( .................................... )</p>
                </td>
                <td class="signature-box">
                    <p>Diperiksa Oleh,</p>
                    <br><br><br>
                    <p>( .................................... )</p>
                </td>
                <td class="signature-box">
                    <p>Diketahui Oleh (Gudang),</p>
                    <br><br><br>
                    <p><strong>{{ $gr->user->name ?? 'Admin Gudang' }}</strong></p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        h4 {
            text-align: center;
            margin-bottom: 4px;
            font-size: 16px;
            uppercase: true;
        }

        p {
            text-align: center;
            margin: 0 0 16px;
            color: #666;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #0dcaf0;
            color: #fff;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #0bafcf;
        }

        td {
            padding: 5px 6px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            padding: 2px 4px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #198754;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

    </style>
</head>

<body>

    <h4>Report Data Goods Received</h4>
    <p>Printed On: {{ now()->format('d M Y, H:i') }} WID</p>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 10%;">Tanggal Masuk</th>
                <th style="width: 12%;">No. Surat Jalan</th>
                <th style="width: 12%;">Supplier</th>
                <th style="width: 15%;">Nama Barang</th>
                <th style="width: 10%;">Jenis</th>
                <th style="width: 8%;">Qty</th>
                <th style="width: 10%;">Satuan</th>
                <th style="width: 11%;">Project</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp

            @forelse ($reportItems as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $item->tanggal_masuk ?? '-' }}</td>
                <td>{{ $item->kode_surat_jalan ?? '-' }}</td>
                <td>{{ $item->nama_supplier ?? '-' }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td class="text-center" style="text-transform: capitalize;">{{ $item->jenis_barang }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td>{{ $item->quantity_jenis }}</td>
                <td>{{ $item->nama_project ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge {{ $item->status == 'received' ? 'badge-success' : 'badge-warning' }}">
                        {{ $item->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 15px;">There Is No Data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>

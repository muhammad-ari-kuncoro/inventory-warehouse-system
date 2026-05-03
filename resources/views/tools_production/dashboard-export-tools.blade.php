<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h4   { text-align: center; margin-bottom: 4px; }
        p    { text-align: center; margin: 0 0 16px; color: #666; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #0dcaf0; color: #fff; padding: 6px; text-align: center; }
        td { padding: 5px 6px; border: 1px solid #dee2e6; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .text-center { text-align: center; }
        .text-danger  { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>

    <h4>Report Data Tools</h4>
    <p>Printed On: {{ now()->format('d M Y, H:i') }}</p>
    <p>Print layout can sometimes vary according to needs/requests.</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Code Tools</th>
                <th>Name Tools</th>
                <th>Spesification Tools</th>
                <th>Quantity</th>
                <th>Type Tools</th>
                <th>Size Tools</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tools as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item->kode_alat ?? '-' }}</td>
                <td>{{ $item->nama_alat ?? '-' }}</td>
                <td>{{ $item->spesifikasi_alat ?? '-' }}</td>
                <td class="text-center {{ $item->quantity == 0 ? 'text-danger' : '' }}">
                    {{ $item->quantity }} {{ $item->jenis_quantity ?? '-' }}
                </td>
                <td>{{ $item->jenis_alat ?? '-' }}</td>
                <td>{{ $item->tipe_alat ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

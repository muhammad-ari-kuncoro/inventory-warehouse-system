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

    <h4>Report Data Materials</h4>
    <p>Printed On: {{ now()->format('d M Y, H:i') }}</p>
    <p>Print layout can sometimes vary according to needs/requests.</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Materials Code</th>
                <th>Materials Name</th>
                <th>Spesification</th>
                <th>Quantity</th>
                <th>Quantity Type</th>
                <th>Materials Name</th>
                <th>Prices</th>
                <th>Project</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($materials as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item->kode_material ?? '-' }}</td>
                <td>{{ $item->nama_material ?? '-' }}</td>
                <td>{{ $item->spesifikasi_material ?? '-' }}</td>
                <td class="text-center {{ $item->quantity == 0 ? 'text-danger' : '' }}">
                    {{ $item->quantity }}
                </td>
                <td>{{ $item->jenis_quantity ?? '-' }}</td>
                <td>{{ $item->jenis_material ?? '-' }}</td>
                <td>Rp {{ number_format($item->harga_material, 0, ',', '.') }}</td>
                <td>{{ $item->project->nama_project ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">There Is No Data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

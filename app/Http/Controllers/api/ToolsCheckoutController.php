<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CheckOutTools;
use App\Models\Tools;
use Illuminate\Http\Request;

class ToolsCheckoutController extends Controller
{
    //
    // API Index - list semua data pinjam user yang belum dikembalikan
    public function index()
    {
        $data = CheckOutTools::with('tool')
            ->where('status_kembali', false)
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar peminjaman alat',
            'data' => $data
        ]);
    }

    // API Create Peminjaman Alat
    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $alat = Tools::findOrFail($request->tool_id);

        if ($request->quantity > $alat->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah yang diminta melebihi stok tersedia.'
            ], 400);
        }

        // Simpan data peminjaman
        $peminjaman = CheckOutTools::create([
            'user_id' => auth()->id(),
            'tool_id' => $request->tool_id,
            'quantity' => $request->quantity,
            'tanggal_pengambilan' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil ditambahkan',
            'data' => $peminjaman
        ]);
    }

    // // API Show Detail Peminjaman
    // public function show($id)
    // {
    //     $data = CheckOutTools::with('tool')->findOrFail($id);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Detail peminjaman ditemukan',
    //         'data' => $data
    //     ]);
    // }
}

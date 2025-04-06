<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CheckInTools;
use Illuminate\Http\Request;

class CheckinToolsRentalAPIController extends Controller
{
    //
    public function store(Request $request)
    {
         // Pastikan user terautentikasi dengan JWT
         $user = auth()->user();
         if (!$user) {
             return response()->json([
                 'success' => false,
                 'message' => 'Unauthorized. Silakan login untuk mengakses API.',
             ], 401);
         }

          // Validasi input
        $request->validate([
            'tanggal_pengembalian'   => 'required|min:3|max:100',
            'bagian_divisi'         => 'required|min:3|max:100',
            'nama_pengembalian'     => 'required|min:3|max:100',
            'tool_id'               => 'required|exists:tools,id',
            'quantity'              => 'required|numeric|min:1',
            'jenis_quantity'        => 'required|min:1|max:100',
            'keterangan_alat'       => 'required|min:3|max:100',
        ]);

    try {
        // Simpan data ke database
        $checkIn = CheckInTools::create([
            'tanggal_pengembalian'   => $request->tanggal_pengembalian,
            'bagian_divisi'         => $request->bagian_divisi,
            'nama_pengembalian'     => $request->nama_pengembalian,
            'tool_id'               => $request->tool_id,
            'quantity'              => $request->quantity,
            'jenis_quantity'        => $request->jenis_quantity,
            'keterangan_alat'       => $request->keterangan_alat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan!',
            'data' => $checkIn
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan data!',
            'error' => $e->getMessage()
        ], 500);
    }

    }
    public function update($id)
    {
         // Pastikan user terautentikasi dengan JWT
         $user = auth()->user();
         if (!$user) {
             return response()->json([
                 'success' => false,
                 'message' => 'Unauthorized. Silakan login untuk mengakses API.',
             ], 401);
         }

         try {
            // Cari data berdasarkan ID
            $checkInTool = CheckInTools::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan!',
                'data' => $checkInTool
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'error' => $e->getMessage()
            ], 404);
        }

    }
}

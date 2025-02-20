<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Consumables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsumableAPIController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama_consumable' => 'required|min:5|max:255',
            'spesifikasi_consumable' => 'required|min:5|max:255',
            'jenis_quantity' => 'required|min:1|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_consumable' => 'required|min:5|max:255',
            'harga_consumable' => 'required|min:1|max:255',
            'project_id' => 'nullable|exists:projects,id', // Pastikan project_id valid jika ada
        ]);

        try {
            // Simpan Data
            $consumable = Consumables::create([
                'nama_consumable' => $request->nama_consumable,
                'spesifikasi_consumable' => $request->spesifikasi_consumable,
                'jenis_quantity' => $request->jenis_quantity,
                'quantity' => $request->quantity,
                'jenis_consumable' => $request->jenis_consumable,
                'harga_consumable' => $request->harga_consumable,
                'project_id' => $request->project_id
            ]);

            // Response JSON Berhasil
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan!',
                'data' => $consumable
            ], 201);

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat menyimpan data: ' . $e->getMessage());

            // Response JSON Gagal
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        // Validasi Input
        $request->validate([
            'nama_consumable'        => 'required|min:5|max:255',
            'spesifikasi_consumable' => 'required|min:5|max:255',
            'jenis_quantity'         => 'required|min:1|max:255',
            'quantity'               => 'required|min:1|max:100',
            'jenis_consumable'       => 'required|min:5|max:255',
            'harga_consumable'       => 'required|min:1|max:255',
            'project_id'             => 'nullable|exists:projects,id', // Pastikan project_id valid jika ada
        ]);

        try {
            // Cari data berdasarkan ID
            $consumable = Consumables::find($id);

            // Jika data tidak ditemukan
            if (!$consumable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 404);
            }

            // Update data
            $consumable->update($request->only([
                'nama_consumable',
                'spesifikasi_consumable',
                'jenis_quantity',
                'quantity',
                'jenis_consumable',
                'harga_consumable',
                'project_id'
            ]));

            // Response JSON Berhasil
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui!',
                'data' => $consumable
            ], 200);

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat update data: ' . $e->getMessage());

            // Response JSON Gagal
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data!',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}

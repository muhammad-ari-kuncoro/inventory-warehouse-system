<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Materials;
use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ToolsAPIController extends Controller
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

         //Validasi
        $request->validate([
            'nama_alat' => 'required|min:5|max:255',
            'spesifikasi_alat' => 'required|min:5|max:255',
            'jenis_alat' => 'required|min:1|max:255',
            'tipe_alat' => 'required|min:1|max:100',
            'quantity' => 'required|min:1|max:255',
            'jenis_quantity' => 'required',

        ]);
        try {
            //code...
            $tool = Tools::create([
                'nama_alat' => $request->nama_alat,
                'spesifikasi_alat' => $request->spesifikasi_alat,
                'jenis_alat' => $request->jenis_alat,
                'tipe_alat' => $request->tipe_alat,
                'quantity' => $request->quantity,
                'jenis_quantity' => $request->jenis_quantity
            ]);
             // Response JSON Berhasil
             return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan!',
                'data' => $tool
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
    public function update(Request $request,$id)
    {
        // Pastikan user terautentikasi dengan JWT
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Silakan login untuk mengakses API.',
            ], 401);
        }

      //Validasi
     $request->validate([
         'nama_alat' => 'required|min:5|max:255',
         'spesifikasi_alat' => 'required|min:5|max:255',
         'jenis_alat' => 'required|min:1|max:255',
         'tipe_alat' => 'required|min:1|max:100',
         'quantity' => 'required|min:1|max:255',
         'jenis_quantity' => 'required',

     ]);

     try {
        // Cari data berdasarkan ID
        $material = Materials::find($id);

        // Jika data tidak ditemukan
        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 404);
        }

         // Update data consumable
         $material->update($request->only([
            'nama_alat',
            'spesifikasi_alat',
            'jenis_alat',
            'tipe_alat',
            'quantity',
            'jenis_quantity',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui!',
            'data' => $material
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

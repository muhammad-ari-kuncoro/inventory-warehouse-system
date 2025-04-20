<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Materials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaterialAPIController extends Controller
{
    //
    public function getdataAll()
    {
        $material = Materials::all();
        return response()->json([
            'success' => true,
            'message' => 'Data material  diambil',
            'data' => $material
        ]);
    }

    public function getDataID($id){
        $materialId = Materials::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Data proyek  diambil',
            'data' => $materialId
        ]);
    }

    public function store(Request $request){
        //Validasi
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Silakan login untuk mengakses API.',
            ], 401);
        }


        $request->validate([
            'nama_material' => 'required|min:5|max:255',
            'spesifikasi_material' => 'required|min:5|max:255',
            'jenis_quantity' => 'required|min:1|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_material' => 'required|min:1|max:255',
            'harga_material' => 'required|min:1|max:255',
            'project_id' => 'nullable',

        ]);
             // Menangani Data
             try {
                $material = Materials::create([
                    'nama_material' => $request->nama_material,
                    'spesifikasi_material' => $request->spesifikasi_material,
                    'jenis_quantity' => $request->jenis_quantity,
                    'quantity' => $request->quantity,
                    'jenis_material' => $request->jenis_material,
                    'harga_material' => $request->harga_material,
                    'project_id' => $request->project_id,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil ditambahkan!',
                    'data' => $material
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
        public function update(Request $request , $id)
        {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Silakan login untuk mengakses API.',
                ], 401);
            }

            // Validasi input
            $request->validate([
                'nama_material' => 'required|min:5|max:255',
                'spesifikasi_material' => 'required|min:5|max:255',
                'jenis_quantity' => 'required|min:1|max:255',
                'quantity' => 'required|integer|min:1|max:100',
                'jenis_material' => 'required|min:1|max:255',
                'harga_material' => 'required|numeric|min:0',
                'project_id' => 'nullable|exists:projects,id',
            ]);

            try {
                // ambil data material berdasarkan ID
                $material = Materials::find($id);

                if (!$material) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data material tidak ditemukan.',
                    ], 404);
                }

                // Update data hanya dengan kolom yang diperbolehkan
                $material->update($request->only([
                    'nama_material',
                    'spesifikasi_material',
                    'jenis_quantity',
                    'quantity',
                    'jenis_material',
                    'harga_material',
                    'project_id'
                ]));

                return response()->json([
                    'success' => true,
                    'message' => 'Data material berhasil diperbarui.',
                    'data' => $material,
                ]);

            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data.',
                    'error' => $th->getMessage(),
                ], 500);
            }

        }
    }

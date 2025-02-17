<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Materials;
use Illuminate\Http\Request;

class MaterialAPIController extends Controller
{
    //
    public function store(Request $request){
        //Validasi
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
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data!',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

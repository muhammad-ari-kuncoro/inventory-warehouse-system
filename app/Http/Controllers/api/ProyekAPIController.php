<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProyekAPIController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_project' => 'required|min:5|max:255',
            'sub_nama_project' => 'required|min:5|max:255',
            'kategori_project' => 'required|min:5|max:255',
            'no_jo_project' => 'required|min:5|max:255',
            'no_po_project' => 'required|min:3|max:255'
        ]);

        // Menangani Data
        try {
            $project = Project::create([
                'nama_project' => $request->nama_project,
                'sub_nama_project' => $request->sub_nama_project,
                'kategori_project' => $request->kategori_project,
                'no_jo_project' => $request->no_jo_project,
                'no_po_project' => $request->no_po_project,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan!',
                'data' => $project
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request,$id)
    {



     // Validasi
     $request->validate([
        'nama_project' => 'required|min:5|max:255',
        'sub_nama_project' => 'required|min:5|max:255',
        'kategori_project' => 'required|min:5|max:255',
        'no_jo_project' => 'required|min:5|max:255',
        'no_po_project' => 'required|min:3|max:255'
    ]);

        try {
            // Cari data berdasarkan ID
            $project = Project::find($id);

            // Jika data tidak ditemukan
            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 404);
            }

            // Update data
            $project->update($request->only([
                'nama_project',
                'sub_nama_project',
                'kategori_project',
                'no_jo_project',
                'no_po_project'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui!',
                'data' => $project
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Error saat update project: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data!',
                'error' => 'Silakan coba lagi nanti.'
            ], 500);
        }
    }
}

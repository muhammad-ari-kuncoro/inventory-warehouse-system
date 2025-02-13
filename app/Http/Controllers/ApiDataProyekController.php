<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ApiDataProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $project = Project::findOrFail($id);
        return response()->json($project);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

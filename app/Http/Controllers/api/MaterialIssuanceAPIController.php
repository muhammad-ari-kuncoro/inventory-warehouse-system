<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MaterialIssuance;
use App\Models\Materials;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialIssuanceAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = [
        //     'sub_title' => 'Pengambilan Material',
        //     'title' => 'Menu Material Halaman',
        //     'data_project' => Project::all(),
        //     'data_materials' => Materials::all(),
        //     'data_material_issuance' => MaterialIssuance::all(),
        // ];

        // return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     * (In API, this is usually not needed, kept for compatibility)
     */
    public function create()
    {
        // $data = [
        //     'sub_title' => 'Pengambilan Material',
        //     'title' => 'Menu Tambah Material Halaman',
        //     'data_project' => Project::all(),
        //     'data_materials' => Materials::paginate(5),
        // ];

        // return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengambilan'        => 'required|min:3|max:100',
            'material_id'                => 'required|exists:materials,id',
            'project_id'                 => 'required|exists:menu_project,id',
            'quantity'                   => 'required|numeric|min:1',
            'jenis_quantity'             => 'required|min:1|max:100',
            'keterangan_material'        => 'required|min:3|max:100',
        ]);

        DB::beginTransaction();
        try {
            $materialIssuance = MaterialIssuance::create([
                'tanggal_pengambilan'     => $request->tanggal_pengambilan,
                'user_id'               => Auth::user()->id,
                'material_id'             => $request->material_id,
                'project_id'              => $request->project_id,
                'quantity'                => $request->quantity,
                'jenis_quantity'          => $request->jenis_quantity,
                'keterangan_material'     => $request->keterangan_material,
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil ditambahkan!',
                'data' => $materialIssuance
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = [
                'title' => 'Formulir Detail Pengambilan Consumable',
                'sub_title' => 'Pengambilan Material',
                'data_materials' => Materials::all(),
                'data_project' => Project::all(),
                'find_id' => MaterialIssuance::findOrFail($id),
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * (Optional in API, normally handled in frontend)
     */
    public function edit($id)
    {
        try {
            $data = MaterialIssuance::findOrFail($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $materialIssuance = MaterialIssuance::findOrFail($id);

            $materialIssuance->update($request->all());

            return response()->json([
                'message' => 'Data berhasil diperbarui!',
                'data' => $materialIssuance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $materialIssuance = MaterialIssuance::findOrFail($id);
            $materialIssuance->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

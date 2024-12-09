<?php

namespace App\Http\Controllers;

use App\Models\MaterialTemporary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
class MaterialTemporaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //
        $data['data_material_temporary'] = MaterialTemporary::all();
        $data['sub_title'] = 'Material-Temporary';
        $data['title'] = 'Menu Halaman Material Temporary';
        return view('material_temporary.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         //Validasi
         $request->validate([
            'nm_material_temporary' => 'required',
            'spesifikasi_material_temporary' => 'required',
            'quantity_temporary' => 'required',
            'jenis_quantity' => 'required',
            'jenis_material' => 'required'
        ]);
        // dd($request);

        // Menangani Data
        try {
            MaterialTemporary::create([
                'nm_material_temporary'          => $request->nm_material_temporary,
                'spesifikasi_material_temporary' => $request->spesifikasi_material_temporary,
                'quantity_temporary'             => $request->quantity_temporary,
                'jenis_quantity'                 => $request->jenis_quantity,
                'jenis_material'                 => $request->jenis_material,
            ]);
            return redirect()->route('material-temporary.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialTemporary $materialTemporary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialTemporary $materialTemporary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialTemporary $materialTemporary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialTemporary $materialTemporary)
    {
        //
    }
}

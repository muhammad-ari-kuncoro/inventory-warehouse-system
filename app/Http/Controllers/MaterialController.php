<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Materials;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['data_material'] = Materials::all();
        $data['sub_title'] = 'Materials';
        $data['title'] = 'Menu Material Halaman';
        $data['data_project'] = Project::all();
        return view('materials.index',$data);
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
         //Validasi
         $request->validate([
            'nama_material' => 'required|min:5|max:255',
            'spesifikasi_material' => 'required|min:5|max:255',
            'jenis_quantity' => 'required|min:1|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_material' => 'required|min:5|max:255',
            'harga_material' => 'required|min:1|max:255',
            'project_id' => 'required',

        ]);


        try {
            Materials::create([
                'nama_material' => $request->nama_material,
                'spesifikasi_material' => $request->spesifikasi_material,
                'jenis_quantity' => $request->jenis_quantity,
                'quantity' => $request->quantity,
                'jenis_material' => $request->jenis_material,
                'harga_material' => $request->harga_material,
                'project_id' => $request->project_id
            ]);
            // dd($tambah);
            return redirect()->route('materials.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $th) {
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Materials $materials)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $data['sub_title'] = 'Materials';
        $data['title'] = 'Halaman Edit Material';
        $data['data_project'] = Project::all();
        $data['find_id'] = Materials::findOrFail($id);
        $data['data_all'] = Materials::all();
        return view('materials.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //Validasi
        $request->validate([
            'nama_material'         => 'required|min:5|max:255',
            'spesifikasi_material'  => 'required|min:5|max:255',
            'jenis_quantity'        => 'required|min:1|max:255',
            'quantity'              => 'required|min:1|max:100',
            'jenis_material'        => 'min:5|max:255',
            'harga_material'        => 'required|min:1|max:100',
            'project_id'            => 'required',

        ]);

        // dd($request);

        $updateMaterial = Materials::findOrFail($id);
        $updateMaterial->nama_material          = $request->nama_material;
        $updateMaterial->spesifikasi_material   = $request->spesifikasi_material;
        $updateMaterial->jenis_quantity         = $request->jenis_quantity;
        $updateMaterial->quantity               = $request->quantity;
        $updateMaterial->jenis_material         = $request->jenis_material;
        $updateMaterial->harga_material         = $request->harga_material;
        $updateMaterial->project_id             = $request->project_id;
        $updateMaterial->save();
        // Redirect ke halaman yang diinginkan
        return redirect()->route('material.index')->with('editSuccess', 'Data berhasil Di Edit!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materials $materials)
    {
        //
    }
}

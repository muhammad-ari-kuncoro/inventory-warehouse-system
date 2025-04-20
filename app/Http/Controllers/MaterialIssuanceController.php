<?php

namespace App\Http\Controllers;

use App\Models\MaterialIssuance;
use App\Http\Controllers\Controller;
use App\Models\Materials;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class MaterialIssuanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['sub_title'] = 'Pengambilan Material';
        $data['title'] = 'Menu Material Halaman';
        $data['data_project'] = Project::all();
        $data['data_materials'] = Materials::all();
        $data['data_material_issuance'] = MaterialIssuance::all();
        return view('material_issuance.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['sub_title'] = 'Pengambilan Material';
        $data['title'] = 'Menu  tambah Material Halaman';
        $data['data_project'] = Project::all();
        $data['data_materials'] = Materials::paginate(5);
        return view('material_issuance.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tanggal_pengambilan'        => 'required|min:3|max:100',
            'material_id'                => 'required|exists:materials,id',
            'project_id'                 => 'required|exists:menu_project,id',
            'quantity'                   => 'required|numeric|min:1',
            'jenis_quantity'             => 'required|min:1|max:100',
            'keterangan_material'        => 'required|min:3|max:100',
        ]);
        // dd($request);
        try {
            //code...
            MaterialIssuance::create([
                'tanggal_pengambilan'               => $request->tanggal_pengambilan,
                'user_id'                           => Auth::user()->id,
                'material_id'                       => $request->material_id,
                'project_id'                        => $request->project_id,
                'quantity'                          => $request->quantity,
                'jenis_quantity'                    => $request->jenis_quantity,
                'keterangan_material'               => $request->keterangan_material
            ]);
            return redirect()->route('material-issuance.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $data['title'] = 'Formulir Detail Pengambilan Consumable';
        $data['sub_title'] = 'Pengambilan Material';
        $data['data_materials'] = Materials::all();
        $data['data_project'] = Project::all();
        $data['find_id'] = MaterialIssuance::findOrFail($id);
        return view('material_issuance.show ',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialIssuance $materialIssuance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialIssuance $materialIssuance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialIssuance $materialIssuance)
    {
        //
    }
}

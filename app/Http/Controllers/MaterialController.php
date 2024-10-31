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
        //
        $data['sub_title'] = 'Dashboard';
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
            'kode_material' => 'required|min:5|max:255',
            'jenis_quantity' => 'required|min:5|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_material' => 'required|min:5|max:255',
            'project_id' => 'nullable|exists:menu_project,id',

        ]);

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
    public function edit(Materials $materials)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materials $materials)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materials $materials)
    {
        //
    }
}

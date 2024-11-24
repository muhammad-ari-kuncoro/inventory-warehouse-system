<?php

namespace App\Http\Controllers;

use App\Models\MaterialIssuance;
use App\Http\Controllers\Controller;
use App\Models\Materials;
use Illuminate\Http\Request;
use App\Models\Project;
class MaterialIssuanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['sub_title'] = 'Pengambilan Material';
        $data['title'] = 'Menu Consumable Halaman';
        $data['data_project'] = Project::all();
        $data['data_materials'] = Materials::paginate(5);
        return view('material_issuance.index',$data);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialIssuance $materialIssuance)
    {
        //
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

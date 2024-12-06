<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Consumables;
use App\Models\MaterialTemporary;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialTemporaryRequest;
use App\Http\Requests\UpdateMaterialTemporaryRequest;

class MaterialTemporaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreMaterialTemporaryRequest $request)
    {
        //
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
    public function update(UpdateMaterialTemporaryRequest $request, MaterialTemporary $materialTemporary)
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

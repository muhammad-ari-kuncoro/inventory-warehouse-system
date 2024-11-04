<?php

namespace App\Http\Controllers;

use App\Models\Consumables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
class ConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Consumables';
        $data['title'] = 'Menu Consumable Halaman';
        $data['data_project'] = Project::all();
        return view('consumables.index',$data);
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
            'nama_consumable' => 'required|min:5|max:255',
            'spesifikasi_consumable' => 'required|min:5|max:255',
            'jenis_quantity' => 'required|min:5|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_consumable' => 'required|min:5|max:255',
            'project_id' => 'required',

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Consumables $consumables)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consumables $consumables)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consumables $consumables)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consumables $consumables)
    {
        //
    }
}

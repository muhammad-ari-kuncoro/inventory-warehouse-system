<?php

namespace App\Http\Controllers;

use App\Models\ConsumableIssuance;
use App\Http\Controllers\Controller;
use App\Models\Consumables;
use App\Models\Project;
use Illuminate\Http\Request;

class ConsumableIssuanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['title'] = 'Formulir Pengambilan Consumable';
        $data['sub_title'] = 'Pengambilan Consumable';
        $data['data_project'] = Project::all();
        return view('consumable_issuance.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = 'Formulir Pengambilan Consumable';
        $data['sub_title'] = 'Pengambilan Consumable';
        $data['data_consumables'] = Consumables::all();
        $data['data_project'] = Project::all();
        return view('consumable_issuance.create',$data);

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
    public function show(ConsumableIssuance $consumableIssuance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConsumableIssuance $consumableIssuance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConsumableIssuance $consumableIssuance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsumableIssuance $consumableIssuance)
    {
        //
    }
}

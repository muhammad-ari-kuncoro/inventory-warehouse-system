<?php

namespace App\Http\Controllers;

use App\Models\Consumables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

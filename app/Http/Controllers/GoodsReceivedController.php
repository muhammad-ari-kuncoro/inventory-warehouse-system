<?php

namespace App\Http\Controllers;

use App\Models\GoodReceived;
use App\Http\Controllers\Controller;
use App\Models\Consumables;
use App\Models\Materials;
use App\Models\Tools;
use Illuminate\Http\Request;

class GoodsReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['title'] = 'Menu Barang Masuk';
        $data['sub_title'] = 'Barang Masuk';
        return view('good_recevied.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = 'Menu Barang Masuk';
        $data['sub_title'] = 'Barang Masuk';
        $data['data_consumable'] = Consumables::all();
        $data['data_tools']  = Tools::all();
        $data['data_material'] = Materials::all();
        return view('good_recevied.create', $data);
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
    public function show(GoodReceived $goodReceive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodReceived $goodReceive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GoodReceived $goodReceive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoodReceived $goodReceive)
    {
        //
    }
}

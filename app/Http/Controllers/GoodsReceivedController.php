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
        $data['consumables'] = Consumables::all();
        $data['tools']  = Tools::all();
        $data['materials'] = Materials::all();
        return view('good_recevied.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          //Validasi
          $request->validate([
            'tanggal_masuk' => 'required|min:3|max:255',
            'no_transaksi' => 'required|min:5|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_stok' => 'required|min:3|max:255',
            'keterangan_barang' => 'required|min:5|max:255',
            'material_id' => 'nullable|min:1|max:100',
            'consumable_id' => 'nullable|min:1|max:100',
            'tools_id' => 'nullable|min:1|max:100',

        ]);

        dd($request);

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

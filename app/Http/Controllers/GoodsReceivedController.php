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
        // Validate the incoming request
        $request->validate([
            'tanggal_masuk' => 'required|min:3|max:255',
            'no_transaksi' => 'required|min:5|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_stok' => 'required|min:3|max:255',
            'keterangan_barang' => 'required|min:5|max:255',
            'material_id' => 'nullable|exists:materials,id',
            'consumable_id' => 'nullable|exists:consumables,id',
            'tools_id' => 'nullable|exists:tools,id',
        ]);

        try {
            // Check if one of the IDs (material, consumable, or tool) is null and create the record accordingly
            GoodReceived::create([
                'tanggal_masuk' => $request->tanggal_masuk,
                'no_transaksi' => $request->no_transaksi,
                'quantity' => $request->quantity,
                'jenis_stok' => $request->jenis_stok,
                'keterangan_barang' => $request->keterangan_barang,
                'material_id' => $request->material_id,   // Make sure this is set or nullable
                'consumable_id' => $request->consumable_id, // Same for this
                'tools_id' => $request->tools_id,         // Same for this
            ]);

            return redirect()->route('good-received.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Handle errors if the insertion fails
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data! ' . $e->getMessage());
        }
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

<?php

namespace App\Http\Controllers;

use App\Models\GoodReceived;
use App\Http\Controllers\Controller;
use App\Models\Consumables;
use App\Models\Materials;
use App\Models\Tools;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

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
        $data['data_good_received'] = GoodReceived::all();
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
            'tanggal_masuk' => 'required|min:2|max:255',
            'no_transaksi' => 'required|min:2|max:255',
            'nama_supplier' => 'required|min:2|max:255',
            'jenis_barang' => 'required|min:2|max:255',
            'material_id' => 'nullable|exists:materials,id',
            'consumable_id' => 'nullable|exists:consumables,id',
            'tools_id' => 'nullable|exists:tools,id',
            'quantity' => 'required|min:1|max:100',
            'quantity_jenis' => 'required|min:1|max:255',
            'keterangan_barang' => 'nullable',
        ]);
        // dd($request);
        try {
            // Check if one of the IDs (material, consumable, or tool) is null and create the record accordingly
            GoodReceived::create([
                'tanggal_masuk' => $request->tanggal_masuk,
                'no_transaksi' => $request->no_transaksi,
                'nama_supplier' => $request->nama_supplier,
                'jenis_barang' => $request->jenis_barang,
                'material_id' => $request->material_id,   // Make sure this is set or nullable
                'consumable_id' => $request->consumable_id, // Same for this
                'tools_id' => $request->tools_id,         // Same for this
                'quantity' => $request->quantity,
                'quantity_jenis' => $request->quantity_jenis,
                'keterangan_barang' => $request->keterangan_barang,
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
    public function edit($id)
    {
        //
        $data['title'] = 'Edit Menu Barang Masuk';
        $data['sub_title'] = 'Barang Masuk';
        $data['consumables'] = Consumables::all();
        $data['tools']  = Tools::all();
        $data['materials'] = Materials::all();

        $data['find_id'] = GoodReceived::findOrFail($id);

        return view('good_recevied.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        // Validate the incoming request
        $request->validate([
            'tanggal_masuk'         => 'required|min:2|max:255',
            'no_transaksi'          => 'required|min:2|max:255',
            'nama_supplier'         => 'required|min:2|max:255',
            'jenis_barang'          => 'required|min:2|max:255',
            'material_id'           => 'nullable|exists:materials,id',
            'consumable_id'         => 'nullable|exists:consumables,id',
            'tools_id'              => 'nullable|exists:tools,id',
            // 'quantity'              => 'required|min:1|max:100',
            'quantity_jenis'        => 'required|min:1|max:255',
            'keterangan_barang'     => 'nullable',
        ]);

        $updateGoodReceived = GoodReceived::findOrFail($id);
        $updateGoodReceived->tanggal_masuk             = $request->tanggal_masuk;
        $updateGoodReceived->no_transaksi              = $request->no_transaksi;
        $updateGoodReceived->nama_supplier             = $request->nama_supplier;
        $updateGoodReceived->jenis_barang              = $request->jenis_barang;
        $updateGoodReceived->material_id               = $request->material_id;
        $updateGoodReceived->consumable_id             = $request->consumable_id;
        $updateGoodReceived->tools_id                  = $request->tools_id;
        // $updateGoodReceived->quantity                  = $request->quantity;
        $updateGoodReceived->quantity_jenis            = $request->quantity_jenis;
        $updateGoodReceived->keterangan_barang         = $request->keterangan_barang;
        $updateGoodReceived->save();
        // Redirect ke halaman yang diinginkan
        return redirect()->route('good-received.index')->with('editSuccess', 'Data berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $goodReceive = GoodReceived::find($id);

        if ($goodReceive) {
            $goodReceive->delete(); // Menghapus data
            return redirect()->back()->with('delete', 'Data berhasil dihapus.');
        }

        return redirect()->back()->with('delete', 'Data tidak ditemukan.');

    }
}

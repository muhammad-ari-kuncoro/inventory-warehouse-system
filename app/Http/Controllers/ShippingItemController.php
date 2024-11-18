<?php

namespace App\Http\Controllers;

use App\Models\ShippingItem;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ShippingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $data['title'] = 'Menu Barang Keluar Page';
        $data['sub_title'] = 'Barang Keluar';
        $data['data_shipping'] = ShippingItem::all();
        return view('shipping_items.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = 'Menu Tambah Barang Keluar Page';
        $data['sub_title'] = 'Barang Keluar';
        $data['data_project'] = Project::all();
        return view('shipping_items.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validasi
        $request->validate([
            'tgl_kirim'                  => 'required|min:3|max:255',
            'pengirim'                   => 'required|min:3|max:255',
            'tujuan'                     => 'required|min:10|max:255',
            'deskripsi_brg'              => 'required|min:10|max:100',
            'quantity'                   => 'min:1|max:50',
            'jenis_quantity'              => 'min:1|max:50',
            'project_id'                 => 'required',
            'keterangan_brg'             => 'required|min:5|max:100',

        ]);
        try {
            ShippingItem::create([
                'tgl_kirim'                 => $request->tgl_kirim,
                'pengirim'                  => $request->pengirim,
                'tujuan'                    => $request->tujuan,
                'deskripsi_brg'             => $request->deskripsi_brg,
                'quantity'                  => $request->quantity,
                'jenis_quantity'            => $request->jenis_quantity,
                'project_id'                => $request->project_id,
                'keterangan_brg'            => $request->keterangan_brg
                ]);

            // dd($tambah);
            return redirect()->route('shipping-items.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $th) {
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingItem $shippingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingItem $shippingItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingItem $shippingItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingItem $shippingItem)
    {
        //
    }
}

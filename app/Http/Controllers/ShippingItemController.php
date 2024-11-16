<?php

namespace App\Http\Controllers;

use App\Models\ShippingItem;
use App\Http\Controllers\Controller;
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
        return view('shipping_items.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validasi
        $request->validate([
            'nama_material'         => 'required|min:5|max:255',
            'spesifikasi_material'  => 'required|min:5|max:255',
            'jenis_quantity'        => 'required|min:1|max:255',
            'quantity'              => 'required|min:1|max:100',
            'jenis_material'        => 'min:5|max:255',
            'project_id'            => 'required',

        ]);
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

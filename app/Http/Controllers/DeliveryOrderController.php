<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $data['title'] = 'Delivery Order Halaman';
        $data['sub_title'] = 'Pengiriman Delivery Order';
        $data['data_delivery_order']  = DeliveryOrder::all();
        return view('delivery_order.index',$data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = 'Delivery Order Form';
        $data['sub_title'] = 'Pengiriman Delivery Order';
        $data['data_project'] = Project::all();
        return view('delivery_order.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         //Validasi
         $request->validate([
            'tanggal_pengiriman' => 'required|min:5|max:255',
            'pengirim' => 'required|min:5|max:255',
            'penerima' => 'required|min:1|max:255',
            'project_id' => 'required',
            'deskripsi_barang' => 'required|min:10|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_quantity' => 'required|min:1|max:255',
            'keterangan_barang' => 'required|min:5|max:255',

        ]);
        // dd($request);
        try {
            //code...
            DeliveryOrder::create([
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
                'pengirim' => $request->pengirim,
                'penerima' => $request->penerima,
                'project_id' => $request->project_id,
                'deskripsi_barang' => $request->deskripsi_barang,
                'quantity' => $request->quantity,
                'jenis_quantity' => $request->jenis_quantity,
                'keterangan_barang' => $request->keterangan_barang
            ]);

            // dd($tambah);
            return redirect()->route('delivery-order.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            //throw $th;
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryOrder $deliveryOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryOrder $deliveryOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryOrder $deliveryOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryOrder $deliveryOrder)
    {
        //
    }
}

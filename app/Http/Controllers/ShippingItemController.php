<?php

namespace App\Http\Controllers;

use App\Models\ShippingItem;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ShippingItemsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        $data['data_shipping'] = ShippingItemsDetail::all();
        $data['data_project'] = Project::all();
        return view('shipping_items.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function storeItem(Request $request)
    {
    $validated = $request->validate([
        'item_names' => 'required',
        'quantity' => 'nullable',
        'quantity_type' => 'nullable',
        'description_items' => 'nullable',
    ]);

    // dd($validated);
    Log::info('Validation passed:', $validated);

    DB::beginTransaction();
    try {
        if ($request->do_id) {
            $doDraft = ShippingItemsDetail::findOrFail($request->do_id);
        } else {
            $doDraft = ShippingItem::where('user_id', Auth::user()->id)->where('kd_sj_brg_keluar', 'draft')->first();
            if (!$doDraft) {
                $doDraft = new ShippingItem();
                $doDraft->kd_sj_brg_keluar = 'draft';
                $doDraft->user_id = Auth::user()->id;
                $doDraft->save();
            }
        }

        $checkDoDetail = ShippingItemsDetail::where('shipping_items_id', $doDraft->id)->where('item_names', trim($request->item_names))->first();
        if ($checkDoDetail) {
            $doDraftDetail = $checkDoDetail;
        } else {
            $doDraftDetail = new ShippingItemsDetail();
        }
        $doDraftDetail->shipping_items_id = $doDraft->id;
        $doDraftDetail->item_names = trim($request->item_names);
        $doDraftDetail->quantity = $request->quantity;
        $doDraftDetail->quantity_type = $request->quantity_type;
        $doDraftDetail->description_items = $request->description_items;
        $doDraftDetail->save();

        DB::commit();
        if ($request->do_id) {
            return redirect()->route('shipping-items.edit', $request->do_id)->with('success', 'Item berhasil ditambahkan!');
        } else {
            return redirect()->route('shipping-items.create')->with('success', 'Item berhasil ditambahkan!');
        }
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', $e->getMessage());
    }
}


    public function store(Request $request)
    {
        $request->validate([
            'date_delivery' => 'required',
            'to' => 'required|min:1|max:255',
            'description_stuff' => 'required',
        ]);
        try {

            $doDraft = ShippingItem::where('user_id', Auth::user()->id)->where('kd_sj_brg_keluar', 'draft')->first();
            if (!$doDraft) {
                return redirect()->back()->with('error','Harap Masukkan Barang!');
            }

            $doDraft->kd_sj_brg_keluar          = $this->generatKdJsBrngKeluar();
            $doDraft->date_delivery             = $request->date_delivery;
            $doDraft->to                        = $request->to;
            $doDraft->description_stuff         = $request->description_stuff;

            $doDraft->save();

            return redirect()->route('shipping-items.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Terjadi kesalahan saat menyimpan data!');
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
    public function edit($id)
    {
        $data['title'] = 'Menu Edit Barang Keluar Page';
        $data['sub_title'] = 'Barang Keluar';
        $data['do'] = ShippingItemsDetail::findOrFail($id);
        $data['find_id'] = ShippingItem::findOrFail($id);
        $data['data_project'] = Project::all();
        return view('shipping_items.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'tgl_kirim'                  => 'required|min:3|max:255',
            'pengirim'                   => 'required|min:3|max:255',
            'tujuan'                     => 'required|min:10|max:255',
            'deskripsi_brg'              => 'required|min:10|max:100',
            'quantity'                   => 'min:1|max:50',
            'quantity_type'              => 'min:1|max:50',
            'project_id'                 => 'required',
            'keterangan_brg'             => 'required|min:5|max:100',

        ]);

        $updateShippingItems                     = ShippingItem::findOrFail($id);
        $updateShippingItems->tgl_kirim          = $request->tgl_kirim;
        $updateShippingItems->pengirim           = $request->pengirim;
        $updateShippingItems->tujuan             = $request->tujuan;
        $updateShippingItems->quantity           = $request->quantity;
        $updateShippingItems->deskripsi_brg      = $request->deskripsi_brg;
        $updateShippingItems->quantity           = $request->quantity;
        $updateShippingItems->quantity_type     = $request->quantity_type;
        $updateShippingItems->keterangan_brg     = $request->keterangan_brg;
        $updateShippingItems->project_id         = $request->project_id;
        $updateShippingItems->save();
        // Redirect ke halaman yang diinginkan
        return redirect()->route('shipping-items.index')->with('editSuccess', 'Data berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingItem $shippingItem)
    {
        //
    }
    private function generatKdJsBrngKeluar()
    {
        return 'BK/'. 'AJM/O/VII/-'. date('Ymd') . '/' . strtoupper(Str::random(3));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Http\Controllers\Controller;
use App\Models\DeliveryOrderDetail;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $data['data_delivery_order']  = DeliveryOrder::where('do_no', '!=', 'draft')->get();
        $data['data_project'] = Project::get();
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
        $data['data_project'] = Project::get();
        $data['do_draft'] = DeliveryOrder::where('user_id', Auth::user()->id)->where('do_no', 'draft')->first();
        return view('delivery_order.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeItem(Request $request)
    {
         $request->validate([
            'item_description' => 'required',
            'item_size' => 'required',
            'item_qty' => 'required|min:1',
            'satuan_barang' => 'required',

        ]);
        DB::beginTransaction();
        try {
            // Cek Apakah DO Draft Sudah ada
            $doDraft = DeliveryOrder::where('user_id', Auth::user()->id)->where('do_no', 'draft')->first();
            if (!$doDraft) {
                $doDraft = new DeliveryOrder();
                $doDraft->do_no = 'draft';
                $doDraft->user_id = Auth::user()->id;
                $doDraft->save();
            }

            $doDraftDetail = new DeliveryOrderDetail();
            $doDraftDetail->delivery_order_id = $doDraft->id;
            $doDraftDetail->item_description = $request->item_description;
            $doDraftDetail->item_size = $request->item_size;
            $doDraftDetail->item_weight = $request->item_weight;
            $doDraftDetail->item_qty = $request->item_qty;
            $doDraftDetail->item_measurement = $request->satuan_barang;
            $doDraftDetail->save();

            DB::commit();
            return redirect()->route('delivery-order.create')->with('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengiriman' => 'required',
            'penerima' => 'required|min:1|max:255',
            'project_id' => 'required',
        ]);
        try {

            $doDraft = DeliveryOrder::where('user_id', Auth::user()->id)->where('do_no', 'draft')->first();
            if (!$doDraft) {
                return redirect()->back()->with('error','Harap Masukkan Barang!');
            }

            $doDraft->do_no             = $this->generateDoNo();
            $doDraft->do_date           = $request->tanggal_pengiriman;
            $doDraft->project_id        = $request->project_id;
            $doDraft->shipment_address  = $request->penerima;

            $doDraft->save();

            return redirect()->route('delivery-order.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $data['title'] = 'Edit Delivery Order Form';
        $data['sub_title'] = 'Pengiriman Delivery Order';
        $data['data_project'] = Project::all();
        $data['do'] = DeliveryOrder::findOrFail($id);
        return view('delivery_order.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $data['title'] = 'Edit Delivery Order Form';
        $data['sub_title'] = 'Pengiriman Delivery Order';
        $data['data_project'] = Project::all();
        $data['do'] = DeliveryOrder::findOrFail($id);
        $data['data_project'] = Project::all();
        return view('delivery_order.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'tanggal_pengiriman'            => 'required|min:5|max:255',
            'penerima'                      => 'required|min:1|max:255',
            'project_id'                    => 'required',
        ]);

        $updateDeliveryOrder                    = DeliveryOrder::findOrFail($id);
        $updateDeliveryOrder->do_date           = $request->tanggal_pengiriman;
        $updateDeliveryOrder->project_id        = $request->project_id;
        $updateDeliveryOrder->shipment_address  = $request->penerima;
        $updateDeliveryOrder->save();

        return redirect()->route('delivery-order.index')->with('editSuccess', 'Data berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryOrder $deliveryOrder)
    {
        //
    }

    public function deleteDraft()
    {
        try {
            $doDraft = DeliveryOrder::where('user_id', Auth::user()->id)->where('do_no', 'draft')->first();
            DeliveryOrderDetail::where('delivery_order_id', $doDraft->id)->delete();
            $doDraft->delete();

            return redirect()->back()->with('success', 'Success Delete Draft');
        } catch (\Throwable $th) {
            return redirect()->back()->with('success', $th->getMessage());
        }

    }

    public function printPDF($id)
    {
        $deliveryOrder = DeliveryOrder::findOrFail($id);
        $data['deliveryOrder'] = $deliveryOrder;
        $pdf = Pdf::loadView('delivery_order.pdf', $data);
        $fileName = preg_replace('/[\/\\\\]/', '_', $deliveryOrder->do_no);
        return $pdf->stream($fileName . '.pdf');
    }

    private function generateDoNo()
    {
        return 'DO/'. 'AJM/O/VII/-'. date('Ymd') . '/' . strtoupper(Str::random(3));
    }
}

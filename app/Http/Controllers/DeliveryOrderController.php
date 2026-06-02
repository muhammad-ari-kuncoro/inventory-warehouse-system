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

    public function index()
    {
        $data['title']                = 'Delivery Order Page';
        $data['sub_title']            = 'Delivery Order';
        $data['data_delivery_order']  = DeliveryOrder::paginate(10);
        $data['data_project']         = Project::get();
        return view('delivery_order.index',$data);
    }

    public function create()
    {
        $data['title']              = 'Delivery Order Page';
        $data['sub_title']          = 'Delivery Order';
        $data['data_project']       = Project::get();
        $data['do_draft']           = DeliveryOrder::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
        return view('delivery_order.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengiriman'      => 'required',
            'penerima'                => 'required|min:1|max:255',
            'project_id'              => 'required',
        ]);

        try {
                $doDraft = DeliveryOrder::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
            if (!$doDraft) {
                return redirect()->back()->with('error', 'Please Insert Item First!');
            }

            if ($doDraft->do_no == 'DO-DRAFT-NONE') {
                $doDraft->do_no = $this->generateDoNo();
            }

            $doDraft->packing_list          = $request->packing_list;
            $doDraft->delivery_order_no_doc = $request->delivery_order_no_doc;
            $doDraft->do_date               = $request->tanggal_pengiriman;
            $doDraft->project_id            = $request->project_id;
            $doDraft->shipment_address      = $request->penerima;
            $doDraft->status                = 'shipped';
            $doDraft->save();
        return redirect()->route('delivery-order.index')->with('success', 'Data Draft Successfully Created!');
        }catch (\Exception $e) {
            return redirect()->back()->with('failed', 'An error occurred while saving data!');
        }
    }


    public function storeItem(Request $request)
    {
        $request->validate([
            'item_description'  => 'required',
            'item_size'         => 'nullable',
            'item_qty'          => 'nullable',
            'satuan_barang'     => 'nullable',
        ]);
        DB::beginTransaction();
        try {
            if ($request->do_id) {
                $doDraft = DeliveryOrder::findOrFail($request->do_id);
            }else{
                $doDraft = DeliveryOrder::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
            if (!$doDraft) {
                $doDraft = new DeliveryOrder();
                $doDraft->do_no   = 'DO-DRAFT-NONE';
                $doDraft->status  = 'draft';
                $doDraft->user_id = Auth::user()->id;
                $doDraft->save();
            }
        }
            $doDraftDetail                      = new DeliveryOrderDetail();
            $doDraftDetail->delivery_order_id   = $doDraft->id;
            $doDraftDetail->item_description    = trim($request->item_description);
            $doDraftDetail->item_size           = $request->item_size;
            $doDraftDetail->item_weight         = $request->item_weight;
            $doDraftDetail->item_qty            = $request->item_qty;
            $doDraftDetail->item_measurement    = $request->satuan_barang;
            $doDraftDetail->save();
        DB::commit();
        return redirect()->route('delivery-order.edit', $doDraft->id)->with('success', 'Item Successfully Added!');
        }catch(\Exception $e) {
            DB::rollback();
        return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['title']        = 'Edit Delivery Order Page';
        $data['sub_title']    = 'Delivery Order';
        $data['data_project'] = Project::all();
        $data['do']           = DeliveryOrder::findOrFail($id);
        $data['data_project'] = Project::all();
        return view('delivery_order.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengiriman' => 'required|min:5|max:255',
            'penerima'           => 'required|min:1|max:255',
            'project_id'         => 'nullable',
        ]);
        $updateDeliveryOrder = DeliveryOrder::findOrFail($id);
    if ($updateDeliveryOrder->status == 'draft') {
        if ($updateDeliveryOrder->do_no == 'DO-DRAFT-NONE') {
            $updateDeliveryOrder->do_no = $this->generateDoNo();
        }
        $updateDeliveryOrder->status = 'shipped';
    }
    $updateDeliveryOrder->do_date               = $request->tanggal_pengiriman;
    $updateDeliveryOrder->packing_list          = $request->packing_list;
    $updateDeliveryOrder->delivery_order_no_doc = $request->delivery_order_no_doc;
    $updateDeliveryOrder->project_id            = $request->project_id;
    $updateDeliveryOrder->shipment_address      = $request->penerima;
    $updateDeliveryOrder->save();

    return redirect()->route('delivery-order.index')->with('editSuccess', 'Data Has Been Successfully Updated!');
}

    public function editDetailItemInDraft($id){
        $data['title']      = 'Edit Detail Item Delivery Order Page';
        $data['sub_title']  = 'Delivery Order';
        $data['find_id']    = DeliveryOrderDetail::findOrFail($id);
        return view('delivery_order.edit_detail', $data);
    }

    public function updateDetailItemInDraft(Request $request, $id)
    {
        $this->validate($request, [
            'item_description'      => 'required',
            'item_size'             => 'nullable',
            'item_qty'              => 'nullable',
            'satuan_barang'         => 'nullable',
        ]);
        $updatingDeliveryOrder = DeliveryOrderDetail::findOrFail($id);
        $updatingDeliveryOrder->item_description    = trim($request->item_description);
        $updatingDeliveryOrder->item_size           = $request->item_size;
        $updatingDeliveryOrder->item_weight         = $request->item_weight;
        $updatingDeliveryOrder->item_qty            = $request->item_qty;
        $updatingDeliveryOrder->item_measurement    = $request->satuan_barang;
        $updatingDeliveryOrder->save();
        return redirect()->route('delivery-order.create')->with('editSuccess', 'Data Item Has Been Edited!');
    }

    public function deleteItemInDraft($id){
        $detail = DeliveryOrderDetail::find($id);
        if ($detail) {
            $detail->delete();
            return redirect()->back()->with('success', 'Item Has Been Deleted!.');
        }

        return redirect()->back()->with('failed', 'Item Not Found.');
    }

    public function show($id)
    {
        $data['title']        = 'Detail Delivery Order Page';
        $data['sub_title']    = 'Delivery Order';
        $data['data_project'] = Project::all();
        $data['do']           = DeliveryOrder::findOrFail($id);
        return view('delivery_order.show',$data);
    }

    public function printPDF($id)
    {
        $deliveryOrder = DeliveryOrder::findOrFail($id);
        $totalQty = $deliveryOrder->details->sum('item_qty');
        $totalWeight = $deliveryOrder->details->sum('item_weight');

        $data['deliveryOrder'] = $deliveryOrder;
        $data['totalQty'] = $totalQty;
        $data['totalWeight'] = $totalWeight;
        $pdf = Pdf::loadView('delivery_order.pdf', $data);
        $fileName = preg_replace('/[\/\\\\]/', '_', $deliveryOrder->do_no);
        return $pdf->stream($fileName . '.pdf');
    }

    private function generateDoNo()
    {
        return 'DO/'. 'AJM/O/VII/-'. date('Ymd') . '/' . strtoupper(Str::random(3));
    }

    public function deleteDraft()
    {
        try {
            $doDraft = DeliveryOrder::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
            DeliveryOrderDetail::where('delivery_order_id', $doDraft->id)->delete();
            $doDraft->delete();

            return redirect()->back()->with('success', 'Success Delete Draft');
        } catch (\Throwable $th) {
            return redirect()->back()->with('success', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
                $deliveryOrder = DeliveryOrder::findOrFail($id);
                DeliveryOrderDetail::where('delivery_order_id', $deliveryOrder->id)->delete();
                $deliveryOrder->delete();
                DB::commit();

                return redirect()->route('delivery-order.index')->with('delete', 'Data Delivery Order Has Been Deleted !!!');

        } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('delivery-order.index')->with('error', 'Failed To Delete Draft: ' . $e->getMessage());
        }
    }
}

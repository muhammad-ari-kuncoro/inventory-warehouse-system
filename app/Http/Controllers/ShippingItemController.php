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

    public function index()
    {
        $data['sub_title']      = 'Subcon Out';
        $data['title']          = 'Subcon Out Page';
        $data['data_shipping']  = ShippingItem::all();
        return view('shipping_items.index',$data);
    }

    public function create()
    {
        $data['details'] = ShippingItem::where('user_id', Auth::user()->id)->where('status', 'draft')->first();

            if ($data['details']) {
            return redirect()->route('shipping-items.edit', $data['details']->id)->with('info', 'You have an unsettled draft transaction.');
            }
        $data['sub_title'] = 'Subcon Out';
        $data['title']     = 'Create Data Subcon Out Page';

        return view('shipping_items.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_delivery'     => 'required',
            'to'                => 'required|min:1|max:255',
            'description_stuff' => 'required',
        ]);

        try {
            $scDraft = ShippingItem::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
            if (!$scDraft) {
                return redirect()->back()->with('error', 'Please Insert Item First!');
            }
            if ($scDraft->kd_sj_brg_keluar == 'SHI-DRAFT-NONE') {
                $scDraft->kd_sj_brg_keluar = $this->generatKdJsBrngKeluar();
            }
            $scDraft->date_delivery     = $request->date_delivery;
            $scDraft->to                = $request->to;
            $scDraft->description_stuff = $request->description_stuff;
            $scDraft->status            = 'shipped';
            $scDraft->save();

            return redirect()->route('shipping-items.index')->with('success', 'Data Draft Successfully Created!');
        }catch(\Exception $e) {
            return redirect()->back()->with('failed', 'An error occurred while saving data: ' . $e->getMessage());
        }
    }

    public function storeItem(Request $request)
    {
            $request->validate([
            'item_names'        => 'required',
            'quantity'          => 'nullable',
            'quantity_type'     => 'nullable',
            'description_items' => 'nullable',
        ]);
        DB::beginTransaction();
            try {
                if ($request->sc_id) {
                    $scDraft = ShippingItem::findOrFail($request->sc_id);
            }else{
                    $scDraft = ShippingItem::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
            if (!$scDraft) {
                $scDraft = new ShippingItem();
                $scDraft->kd_sj_brg_keluar = 'SHI-DRAFT-NONE';
                $scDraft->status            = 'draft';
                $scDraft->user_id           = Auth::user()->id;
                $scDraft->save();
            }
        }

        $scDraftDetail                      = new ShippingItemsDetail();
        $scDraftDetail->shipping_item_id    = $scDraft->id;
        $scDraftDetail->item_names          = trim($request->item_names);
        $scDraftDetail->quantity            = $request->quantity;
        $scDraftDetail->quantity_type       = $request->quantity_type;
        $scDraftDetail->description_items   = $request->description_items;
        $scDraftDetail->save();

        DB::commit();

        return redirect()->route('shipping-items.edit', $scDraft->id)->with('success', 'Item Successfully Added!');
        }catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editDetailItemInDraft($id)
    {
        $data['title']     = 'Edit Detail Item Page';
        $data['sub_title'] = 'Subcon Out';
        $data['find_id']   = ShippingItemsDetail::findOrFail($id);

        return view('shipping_items.edit_detail_item', $data);
    }

    public function updateDetailItemInDraft(Request $request, $id)
    {
            $request->validate([
            'item_names'        => 'required',
            'quantity'          => 'nullable|numeric',
            'quantity_type'     => 'nullable',
            'description_items' => 'nullable',
        ]);

        $shippingDetail = ShippingItemsDetail::findOrFail($id);
        $shippingDetail->item_names        = trim($request->item_names);
        $shippingDetail->quantity          = $request->quantity;
        $shippingDetail->quantity_type     = $request->quantity_type;
        $shippingDetail->description_items = $request->description_items;
        $shippingDetail->save();

        return redirect()->route('shipping-items.edit', $shippingDetail->shipping_item_id)->with('editSuccess', 'Data Item Successfully Edited!');
    }

    public function deleteItemInDraft($id)
    {
            $detail = ShippingItemsDetail::find($id);
        if ($detail) {
            $detail->delete();
            return redirect()->back()->with('success', 'Item Has Been Deleted In Draft!');
        }
        return redirect()->back()->with('failed', 'Item Not Found.');
    }

public function show($id)
{
    $data['title']     = 'Detail Subcon Out Page';
    $data['sub_title'] = 'Subcon Out';
    $data['subcon']    = ShippingItem::with('details')->findOrFail($id);
    return view('subcon_out.show', $data);
}

public function edit($id)
{
    $data['title']     = 'Edit Subcon Out Page';
    $data['sub_title'] = 'Subcon Out';
    $data['shipping']  = ShippingItem::findOrFail($id);
    return view('shipping_items.edit', $data);
}

public function update(Request $request, $id)
{
    $request->validate([
        'date_delivery'     => 'required',
        'to'                => 'required|min:1|max:255',
        'description_stuff' => 'nullable',
    ]);

    $shippingItem = ShippingItem::findOrFail($id);

    if ($shippingItem->status == 'draft') {
        if ($shippingItem->kd_sj_brg_keluar == 'SHI-DRAFT-NONE') {
            $shippingItem->kd_sj_brg_keluar = $this->generatKdJsBrngKeluar();
        }
        $shippingItem->status = 'shipped';
    }

    $shippingItem->date_delivery     = $request->date_delivery;
    $shippingItem->to                = $request->to;
    $shippingItem->description_stuff = $request->description_stuff;
    $shippingItem->save();

    return redirect()->route('shipping-items.index')->with('editSuccess', 'Data Subcon Has Been Edited!');
}

public function destroy($id)
{
    DB::beginTransaction();
    try {
        $shippingItem = ShippingItem::findOrFail($id);
        ShippingItemsDetail::where('shipping_item_id', $shippingItem->id)->delete();
        $shippingItem->delete();
        DB::commit();

        return redirect()->route('shipping-items.index')->with('delete', 'Data Subcon Has Been Deleted!!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('shipping-items.index')->with('error', 'Failed to delete data: ' . $e->getMessage());
    }
}

public function deleteDraft()
{
    try {
        $shippingDraft = ShippingItem::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
        if ($shippingDraft) {
            ShippingItemsDetail::where('shipping_item_id', $shippingDraft->id)->delete();
            $shippingDraft->delete();
        }
        return redirect()->route('shipping-items.index')->with('success', 'Draft Subcon Has Been Deleted!!.');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
}

private function generatKdJsBrngKeluar()
{
    return 'BK/' . 'AJM/O/VII/-' . date('Ymd') . '/' . strtoupper(Str::random(3));
}

}

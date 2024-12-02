<?php

namespace App\Http\Controllers;

use App\Models\GoodReceived;
use App\Http\Controllers\Controller;
use App\Models\Consumables;
use App\Models\GoodReceivedDetail;
use App\Models\Materials;
use App\Models\Tools;
use App\Models\Project;

use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $data['data_delivery_order']  = GoodReceived::where('kd_sj', '!=', 'draft')->get();
        $data['data_project'] = Project::get();
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
        $data['data_project'] = Project::get();
        $data['do_draft'] = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
        return view('good_recevied.create', $data);
    }

    public function storeItem(Request $request)
    {
         $request->validate([
            'tgl_masuk' => 'required',
            'no_surat_jalan' => 'required',
            'nama_supplier' => 'required|min:1',
            'satuan_barang' => 'required',
            'project_id'    => 'required'

        ]);
        DB::beginTransaction();
        try {
            // Cek Apakah Surat Jalan Draft Sudah ada
            $kdSJDraf = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$kdSJDraf) {
                $kdSJDraf = new GoodReceived();
                $kdSJDraf->kd_sj = 'draft';
                $kdSJDraf->user_id = Auth::user()->id;
                $kdSJDraf->save();
            }

            $kdSJDrafDetail = new GoodReceivedDetail();
            $kdSJDrafDetail->good_received_id = $kdSJDraf->id;
            $kdSJDrafDetail->consumable_id = $kdSJDraf->id;
            $kdSJDrafDetail->material_id = $kdSJDraf->id;
            $kdSJDrafDetail->tool_id = $kdSJDraf->id;

            $kdSJDrafDetail->quantity = $request->quantity;

            if ($request->jenis_barang === 'Materials') {
                $kdSJDrafDetail->material_id = $request->material_id;
            } elseif ($request->jenis_barang === 'Consumables') {
                $kdSJDrafDetail->consumable_id = $request->consumable_id;
            } elseif ($request->jenis_barang === 'Tools') {
                $kdSJDrafDetail->tool_id = $request->tools_id;
            }

            $kdSJDrafDetail->quantity_jenis =  $request->quantity_jenis;
            $kdSJDrafDetail->keterangan_barang = $request->keterangan_barang;
            $kdSJDrafDetail->save();

            DB::commit();
            return redirect()->route('good-received.create')->with('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'tgl_masuk' => 'required',
            'penerima' => 'required|min:1|max:255',
            'project_id' => 'required',
        ]);
        try {

            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$doDraft) {
                return redirect()->back()->with('error','Harap Masukkan Barang!');
            }

            $doDraft->kd_sj             = $this->generatekdSJ();
            $doDraft->tgl_masuk           = $request->tgl_masuk;
            $doDraft->project_id        = $request->project_id;
            $doDraft->shipment_address  = $request->penerima;

            $doDraft->save();

            return redirect()->route('good-received.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Terjadi kesalahan saat menyimpan data!');
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
        $request->validate([
            'tanggal_pengiriman'            => 'required|min:5|max:255',
            'penerima'                      => 'required|min:1|max:255',
            'project_id'                    => 'required',
        ]);

        $updateGoodReceived                    = GoodReceived::findOrFail($id);
        $updateGoodReceived->do_date           = $request->tanggal_pengiriman;
        $updateGoodReceived->project_id        = $request->project_id;
        $updateGoodReceived->shipment_address  = $request->penerima;
        $updateGoodReceived->save();

        return redirect()->route('delivery-order.index')->with('editSuccess', 'Data berhasil Di Edit!');
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

    public function deleteDraft()
    {
        try {
            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            GoodReceivedDetail::where('good_received_id', $doDraft->id)->delete();
            $doDraft->delete();

            return redirect()->back()->with('success', 'Success Delete Draft');
        } catch (\Throwable $th) {
            return redirect()->back()->with('success', $th->getMessage());
        }

    }

    private function generatekdSJ()
    {
        return 'DO/'. 'AJM/O/SJ/-'. date('Ymd') . '/' . strtoupper(Str::random(3));
    }
}

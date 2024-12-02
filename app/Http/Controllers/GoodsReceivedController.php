<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Models\Project;
use App\Models\Materials;
use App\Models\Consumables;
use Illuminate\Support\Str;
use App\Models\GoodReceived;
use Illuminate\Http\Request;

use App\Models\GoodReceivedDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $data['data_delivery_order']  = GoodReceived::where('kd_sj', '!=', 'draft')->get();
        $data['data_project'] = Project::get();
        return view('good_recevied.index', $data);
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
            'jenis_barang' => 'required|min:1',
            'consumable_id' => 'nullable',
            'material_id' => 'nullable',
            'tools_id' => 'nullable',
            'quantity' => 'required|min:1',
            'quantity_jenis' => 'required|min:1',
            'keterangan_barang' => 'required|min:1',

        ]);
        // dd($request);

        DB::beginTransaction();
        try {
            // Cek apakah draft sudah ada
            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$doDraft) {
                $doDraft = new GoodReceived();
                $doDraft->kd_sj = 'draft';
                $doDraft->user_id = Auth::user()->id;
                $doDraft->save();
            }

            // Simpan detail
            $kdSJDrafDetail = new GoodReceivedDetail();
            $kdSJDrafDetail->good_received_id   = $doDraft->id;
            $kdSJDrafDetail->jenis_barang       = $request->jenis_barang;
            $kdSJDrafDetail->consumable_id      = $request->consumable_id;
            $kdSJDrafDetail->material_id        = $request->material_id;
            $kdSJDrafDetail->tools_id           = $request->tools_id;
            $kdSJDrafDetail->quantity           = $request->quantity;
            $kdSJDrafDetail->quantity_jenis     = $request->quantity_jenis;
            $kdSJDrafDetail->keterangan_barang  = $request->keterangan_barang;
            $kdSJDrafDetail->save();

            DB::commit();
            return redirect()->route('good-received.create')->with('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage()); // Tambahkan log untuk melihat error
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
            'tanggal_masuk' => 'required|min:1|max:255',
            'nama_supplier' => 'required|min:1|max:255',
            'kode_surat_jalan' => 'required|min:1|max:100',
            'project_id' => 'required',
        ]);
        try {

            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$doDraft) {
                return redirect()->back()->with('error', 'Harap Masukkan Barang!');
            }

            $doDraft->kd_sj             = $this->generatekdSJ();
            $doDraft->tanggal_masuk     = $request->tanggal_masuk;
            $doDraft->project_id        = $request->project_id;
            $doDraft->nama_supplier  = $request->nama_supplier;
            $doDraft->kode_surat_jalan  = $request->kode_surat_jalan;
            $doDraft->project_id  = $request->project_id;

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

        return view('good_recevied.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
        return 'GR/' . 'AJM/O/SJ/-' . date('Ymd') . '/' . strtoupper(Str::random(3));
    }
}

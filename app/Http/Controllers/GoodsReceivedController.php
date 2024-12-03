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
        $data['data_delivery_order']  = GoodReceived::where('kd_sj', '!=', 'drafts')->get();
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
        $validated = $request->validate([
            'jenis_barang' => 'required',
            'consumable_id' => 'nullable',
            'material_id' => 'nullable',
            'tools_id' => 'nullable',
            'quantity' => 'required|min:1',
            'quantity_jenis' => 'required',
            'keterangan_barang' => 'nullable',

        ]);
        Log::info('Validation passed:', $validated);
        // dd($request->all());

        DB::beginTransaction();
        try {
            // Cek Apakah DO Draft Sudah ada
            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$doDraft) {
                $doDraft = new GoodReceived();
                $doDraft->user_id = Auth::user()->id;
                $doDraft->save();
            }

            $doDraftDetail = new GoodReceivedDetail();
            $doDraftDetail->good_received_id = $doDraft->id;
            $doDraftDetail->jenis_barang        = $request->jenis_barang;
            $doDraftDetail->consumable_id       = $request->consumable_id ?: null;
            $doDraftDetail->material_id         = $request->material_id ?: null;
            $doDraftDetail->tools_id            = $request->tools_id ?: null;
            $doDraftDetail->quantity            = $request->quantity;
            $doDraftDetail->quantity_jenis      = $request->quantity_jenis;
            $doDraftDetail->keterangan_barang   = $request->keterangan_barang;
            $doDraftDetail->save();

            DB::commit();
            return redirect()->route('good-received.create')->with('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('failed', $e->getMessage());
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
            'project_id' => 'nullable',
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
    public function show($id)
    {
        //
         //
         $data['title'] = 'Edit Delivery Order Form';
         $data['sub_title'] = 'Pengiriman Delivery Order';
         $data['data_project'] = Project::all();
         $data['consumables'] = Consumables::all();
         $data['tools']  = Tools::all();
         $data['materials'] = Materials::all();
         $data['do'] = GoodReceived::findOrFail($id);
         return view('good_recevied.show',$data);

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
        $data['data_project'] = Project::all();
        $data['do'] = GoodReceived::findOrFail($id);

        return view('good_recevied.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|min:1|max:255',
            'nama_supplier' => 'required|min:1|max:255',
            'kode_surat_jalan' => 'required|min:1|max:100',
            'project_id' => 'required',
        ]);


        $updateGoodReceived                           = GoodReceived::findOrFail($id);
        $updateGoodReceived->tanggal_masuk           = $request->tanggal_masuk;
        $updateGoodReceived->nama_supplier           = $request->nama_supplier;
        $updateGoodReceived->kode_surat_jalan        = $request->kode_surat_jalan;
        $updateGoodReceived->project_id              = $request->project_id;
        $updateGoodReceived->save();

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

   public function deleteDraft()
{
    try {
        $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();

        if ($doDraft) {
            // Ambil semua detail barang masuk
            $details = GoodReceivedDetail::where('good_received_id', $doDraft->id)->get();

            foreach ($details as $detail) {
                // Kurangi stok berdasarkan jenis barang
                if ($detail->material_id) {
                    $material = Materials::find($detail->material_id);
                    if ($material) {
                        $material->decrement('quantity', $detail->quantity);
                    }
                }

                if ($detail->consumable_id) {
                    $consumable = Consumables::find($detail->consumable_id);
                    if ($consumable) {
                        $consumable->decrement('quantity', $detail->quantity);
                    }
                }

                if ($detail->tools_id) {
                    $tool = Tools::find($detail->tools_id);
                    if ($tool) {
                        $tool->decrement('quantity', $detail->quantity);
                    }
                }
            }

            // Hapus semua detail barang masuk
            GoodReceivedDetail::where('good_received_id', $doDraft->id)->delete();

            // Hapus draft utama
            $doDraft->delete();
        }

        return redirect()->back()->with('success', 'Draft dan stok berhasil dihapus.');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
}


    private function generatekdSJ()
    {
        return 'GR/' . 'AJM/O/SJ/-' . date('Ymd') . '/' . strtoupper(Str::random(3));
    }
}

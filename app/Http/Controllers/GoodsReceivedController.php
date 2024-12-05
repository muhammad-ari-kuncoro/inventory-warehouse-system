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
        $data['title']                  = 'Menu Barang Masuk';
        $data['sub_title']              = 'Barang Masuk';
        $data['data_delivery_order']    = GoodReceived::where('kd_sj', '!=', 'draft')->get();
        $data['data_project']           = Project::get();
        return view('good_recevied.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title']          = 'Menu Barang Masuk';
        $data['sub_title']      = 'Barang Masuk';
        $data['consumables']    = Consumables::all();
        $data['tools']          = Tools::all();
        $data['materials']      = Materials::all();
        $data['data_project']   = Project::get();
        $data['do_draft']       = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
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

        DB::beginTransaction();
        try {
            $do_draft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();

            // Cek apakah kombinasi jenis_barang dan nama barang sudah ada
            $existingItem = GoodReceivedDetail::where('good_received_id', $do_draft->id)->where('jenis_barang', $request->jenis_barang)
                ->where(function ($query) use ($request) {
                    $query->where('consumable_id', $request->consumable_id)
                        ->whereNotNull('consumable_id') // Pastikan hanya mengecek jika ID barang tersedia
                        ->orWhere('material_id', $request->material_id)
                        ->whereNotNull('material_id')
                        ->orWhere('tools_id', $request->tools_id)
                        ->whereNotNull('tools_id');
                })
                ->first();

            if ($existingItem) {
                return redirect()->back()->with('failed', 'nama barang ini sudah ada. Silakan gunakan data yang sudah tersedia.');
            }

            // Cek Apakah DO Draft Sudah ada
            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$doDraft) {
                $doDraft = new GoodReceived();
                $doDraft->user_id = Auth::user()->id;
                $doDraft->save();
            }

            // Tambahkan detail barang baru
            $doDraftDetail                      = new GoodReceivedDetail();
            $doDraftDetail->good_received_id    = $doDraft->id;
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
    
    public function storeItemUpdate(Request $request, $id)
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

        DB::beginTransaction();
        try {
            $goodReceive = GoodReceived::findOrFail($id);

            // Cek apakah kombinasi jenis_barang dan nama barang sudah ada
            $existingItem = GoodReceivedDetail::where('good_received_id', $goodReceive->id)->where('jenis_barang', $request->jenis_barang)
                ->where(function ($query) use ($request) {
                    $query->where('consumable_id', $request->consumable_id)
                        ->whereNotNull('consumable_id') // Pastikan hanya mengecek jika ID barang tersedia
                        ->orWhere('material_id', $request->material_id)
                        ->whereNotNull('material_id')
                        ->orWhere('tools_id', $request->tools_id)
                        ->whereNotNull('tools_id');
                })
                ->first();

            if ($existingItem) {
                return redirect()->back()->with('failed', 'nama barang ini sudah ada. Silakan gunakan data yang sudah tersedia.');
            }
            // Tambahkan detail barang baru
            $doDraftDetail                      = new GoodReceivedDetail();
            $doDraftDetail->good_received_id    = $goodReceive->id;
            $doDraftDetail->jenis_barang        = $request->jenis_barang;
            $doDraftDetail->consumable_id       = $request->consumable_id ?: null;
            $doDraftDetail->material_id         = $request->material_id ?: null;
            $doDraftDetail->tools_id            = $request->tools_id ?: null;
            $doDraftDetail->quantity            = $request->quantity;
            $doDraftDetail->quantity_jenis      = $request->quantity_jenis;
            $doDraftDetail->keterangan_barang   = $request->keterangan_barang;
            $doDraftDetail->save();

            DB::commit();
            return redirect()->route('good-received.edit', $goodReceive->id)->with('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }



    public function destroyDetail($id)
    {
        DB::beginTransaction();
        try {
            // Temukan detail barang berdasarkan ID
            $detail = GoodReceivedDetail::findOrFail($id);

            // Kembalikan quantity ke stok asli
            if ($detail->material_id) {
                $material               = Materials::findOrFail($detail->material_id);
                $material->quantity    -= $detail->quantity;
                $material->save();
            } elseif ($detail->consumable_id) {
                $consumable             = Consumables::findOrFail($detail->consumable_id);
                $consumable->quantity  -= $detail->quantity;
                $consumable->save();
            } elseif ($detail->tools_id) {
                $tool = Tools::findOrFail($detail->tools_id);
                $tool->quantity -= $detail->quantity;
                $tool->save();
            }

            // Hapus detail barang
            $detail->delete();
            DB::commit();
            return redirect()->route('good-received.create')->with('warning', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus item: ' . $e->getMessage()]);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'tanggal_masuk'     => 'required|min:1|max:255',
            'nama_supplier'     => 'required|min:1|max:255',
            'kode_surat_jalan'  => 'required|min:1|max:100',
            'project_id'        => 'nullable',
        ]);
        try {

            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$doDraft) {
                return redirect()->back()->with('error', 'Harap Masukkan Barang!');
            }

            $doDraft->kd_sj             = $this->generatekdSJ();
            $doDraft->tanggal_masuk     = $request->tanggal_masuk;
            $doDraft->project_id        = $request->project_id;
            $doDraft->nama_supplier     = $request->nama_supplier;
            $doDraft->kode_surat_jalan  = $request->kode_surat_jalan;
            $doDraft->project_id        = $request->project_id;

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


        $updateGoodReceived                          = GoodReceived::findOrFail($id);
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
        DB::beginTransaction();
        try {
            $goodReceive = GoodReceived::find($id);

            if ($goodReceive) {
                // Loop melalui semua detail barang terkait
                foreach ($goodReceive->details as $detail) {
                    // Cek jenis barang dan update quantity berdasarkan ID barang
                    if ($detail->consumable_id) {
                        $item = Consumables::find($detail->consumable_id);
                        if ($item) {
                            $item->quantity += $detail->quantity;
                            $item->save();
                        }
                    } elseif ($detail->material_id) {
                        $item = Materials::find($detail->material_id);
                        if ($item) {
                            $item->quantity += $detail->quantity;
                            $item->save();
                        }
                    } elseif ($detail->tools_id) {
                        $item = Tools::find($detail->tools_id);
                        if ($item) {
                            $item->quantity += $detail->quantity;
                            $item->save();
                        }
                    }
                }

                // Hapus data utama dan detailnya
                $goodReceive->delete();
                DB::commit();
                return redirect()->back()->with('delete', 'Data berhasil dihapus dan quantity barang telah diperbarui.');
            }

            DB::rollBack();
            return redirect()->back()->with('delete', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('delete', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Consumables;
use App\Models\GoodReceived;
use App\Models\GoodReceivedDetail;
use App\Models\Materials;
use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoodReceivedAPIController extends Controller
{
    //
    public function dataALL()
    {
        try {
            $data = GoodReceived::where('kd_sj', '!=', 'drafts')
                ->with('project') // kalau relasi ada
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data Barang Masuk berhasil diambil.',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data Barang Masuk',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function storeGoodReceived(Request $request)
    {
          // Pastikan user terautentikasi dengan JWT
          $user = auth()->user();
          if (!$user) {
              return response()->json([
                  'success' => false,
                  'message' => 'Unauthorized. Silakan login untuk mengakses API.',
              ], 401);
          }


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
            // Mengambil user yang terautentikasi dari token JWT
            $user = auth()->user();

            // Cek apakah sudah ada draft GoodReceived untuk user ini
            $do_draft = GoodReceived::firstOrCreate(
                ['user_id' => $user->id, 'kd_sj' => 'draft'],
                ['user_id' => $user->id]
            );

            // Cek apakah barang dengan kombinasi tertentu sudah ada dalam draft
            $existingItem = GoodReceivedDetail::where('good_received_id', $do_draft->id)
                ->where('jenis_barang', $request->jenis_barang)
                ->where(function ($query) use ($request) {
                    $query->where('consumable_id', $request->consumable_id)
                        ->whereNotNull('consumable_id')
                        ->orWhere('material_id', $request->material_id)
                        ->whereNotNull('material_id')
                        ->orWhere('tools_id', $request->tools_id)
                        ->whereNotNull('tools_id');
                })
                ->first();

            if ($existingItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nama barang ini sudah ada. Silakan gunakan data yang sudah tersedia.',
                ], 400);
            }

            // Simpan data barang yang diterima
            $doDraftDetail = new GoodReceivedDetail();
            $doDraftDetail->good_received_id = $do_draft->id;
            $doDraftDetail->jenis_barang = $request->jenis_barang;
            $doDraftDetail->consumable_id = $request->consumable_id ?: null;
            $doDraftDetail->material_id = $request->material_id ?: null;
            $doDraftDetail->tools_id = $request->tools_id ?: null;
            $doDraftDetail->quantity = $request->quantity;
            $doDraftDetail->quantity_jenis = $request->quantity_jenis;
            $doDraftDetail->keterangan_barang = $request->keterangan_barang;
            $doDraftDetail->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan!',
                'data' => $doDraftDetail,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {

            // Pastikan user terautentikasi dengan JWT
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Silakan login untuk mengakses API.',
                    ], 401);
                }

        // Validate the incoming request
        $validated = $request->validate([
            'tanggal_masuk' => 'required|min:1|max:255',
            'nama_supplier' => 'required|min:1|max:255',
            'kode_surat_jalan' => 'required|min:1|max:100',
            'project_id' => 'nullable',
        ]);

        try {
            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('kd_sj', 'draft')->first();
            if (!$doDraft) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harap Masukkan Barang!',
                ], 400);
            }

            $doDraft->kd_sj             = $this->generatekdSJ();
            $doDraft->tanggal_masuk     = $request->tanggal_masuk;
            $doDraft->project_id        = $request->project_id;
            $doDraft->nama_supplier     = $request->nama_supplier;
            $doDraft->kode_surat_jalan  = $request->kode_surat_jalan;
            $doDraft->project_id        = $request->project_id;

            $doDraft->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan!',
                'data' => $doDraft,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

public function storeItemUpdate(Request $request, $id)
{
    // Pastikan user terautentikasi dengan JWT
    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Silakan login untuk mengakses API.',
        ], 401);
    }

    // Validasi input
    $validated = $request->validate([
        'jenis_barang'     => 'required',
        'consumable_id'    => 'nullable',
        'material_id'      => 'nullable',
        'tools_id'         => 'nullable',
        'quantity'         => 'required|min:1',
        'quantity_jenis'   => 'required',
        'keterangan_barang'=> 'nullable',
    ]);

    Log::info('Validation passed:', $validated);

    DB::beginTransaction();
    try {
        // Cari data berdasarkan ID
        $goodReceive = GoodReceived::findOrFail($id);

        // Cek apakah barang dengan kombinasi tertentu sudah ada dalam data
        $existingItem = GoodReceivedDetail::where('good_received_id', $goodReceive->id)
            ->where('jenis_barang', $request->jenis_barang)
            ->where(function ($query) use ($request) {
                $query->where('consumable_id', $request->consumable_id)
                    ->whereNotNull('consumable_id')
                    ->orWhere('material_id', $request->material_id)
                    ->whereNotNull('material_id')
                    ->orWhere('tools_id', $request->tools_id)
                    ->whereNotNull('tools_id');
            })
            ->first();

        if ($existingItem) {
            return response()->json([
                'success' => false,
                'message' => 'Nama barang ini sudah ada. Silakan gunakan data yang sudah tersedia.',
            ], 400);
        }

        // Simpan data barang yang diterima
        $doDraftDetail = new GoodReceivedDetail();
        $doDraftDetail->good_received_id = $goodReceive->id;
        $doDraftDetail->jenis_barang = $request->jenis_barang;
        $doDraftDetail->consumable_id = $request->consumable_id ?: null;
        $doDraftDetail->material_id = $request->material_id ?: null;
        $doDraftDetail->tools_id = $request->tools_id ?: null;
        $doDraftDetail->quantity = $request->quantity;
        $doDraftDetail->quantity_jenis = $request->quantity_jenis;
        $doDraftDetail->keterangan_barang = $request->keterangan_barang;
        $doDraftDetail->save();

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Item berhasil ditambahkan!',
            'data'    => $doDraftDetail,
        ], 201);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan data!',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

public function destroyDetailApi($id)
{
   // Pastikan user terautentikasi dengan JWT
   $user = auth()->user();
   if (!$user) {
       return response()->json([
           'success' => false,
           'message' => 'Unauthorized. Silakan login untuk mengakses API.',
       ], 401);
   }

   DB::beginTransaction();
   try {
       // Temukan detail barang berdasarkan ID
       $detail = GoodReceivedDetail::findOrFail($id);

       // Kembalikan quantity ke stok asli berdasarkan jenis barang
       if ($detail->material_id) {
           $material = Materials::findOrFail($detail->material_id);
           $material->quantity -= $detail->quantity;
           $material->save();
       } elseif ($detail->consumable_id) {
           $consumable = Consumables::findOrFail($detail->consumable_id);
           $consumable->quantity -= $detail->quantity;
           $consumable->save();
       } elseif ($detail->tools_id) {
           $tool = Tools::findOrFail($detail->tools_id);
           $tool->quantity -= $detail->quantity;
           $tool->save();
       }

       // Hapus detail barang
       $detail->delete();
       DB::commit();

       return response()->json([
           'success' => true,
           'message' => 'Item berhasil dihapus!',
       ], 200);
   } catch (\Exception $e) {
       DB::rollback();
       return response()->json([
           'success' => false,
           'error' => 'Terjadi kesalahan saat menghapus item: ' . $e->getMessage(),
       ], 500);
   }
}



}

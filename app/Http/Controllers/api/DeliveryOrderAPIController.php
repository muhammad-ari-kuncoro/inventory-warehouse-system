<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryOrderDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderAPIController extends Controller
{
    //
    public function storeItem(Request $request)
    {
          // Pastikan user terautentikasi dengan JWT
          $user = auth()->user();
          if (!$user) {
              return response()->json([
                  'success' => false,
                  'message' => 'Unauthorized. Silakan login untuk mengakses API.',
              ], 401);
          }


        $request->validate([
            'item_description' => 'required|string',
            'item_size' => 'nullable|string',
            'item_weight' => 'nullable|numeric',
            'item_qty' => 'nullable|integer',
            'satuan_barang' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            if ($request->do_id) {
                $doDraft = DeliveryOrder::findOrFail($request->do_id);
            } else {
                $doDraft = DeliveryOrder::where('user_id', Auth::id())->where('do_no', 'draft')->first();
                if (!$doDraft) {
                    $doDraft = new DeliveryOrder();
                    $doDraft->do_no = 'draft';
                    $doDraft->user_id = Auth::id();
                    $doDraft->save();
                }
            }

            $checkDoDetail = DeliveryOrderDetail::where('delivery_order_id', $doDraft->id)
                ->where('item_description', trim($request->item_description))
                ->first();

            if ($checkDoDetail) {
                $doDraftDetail = $checkDoDetail;
            } else {
                $doDraftDetail = new DeliveryOrderDetail();
            }

            $doDraftDetail->delivery_order_id = $doDraft->id;
            $doDraftDetail->item_description = trim($request->item_description);
            $doDraftDetail->item_size = $request->item_size;
            $doDraftDetail->item_weight = $request->item_weight;
            $doDraftDetail->item_qty = $request->item_qty;
            $doDraftDetail->item_measurement = $request->satuan_barang;
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
                'message' => 'Terjadi kesalahan!',
                'error' => $e->getMessage(),
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

        $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'penerima' => 'required|string|min:1|max:255',
            'project_id' => 'required|integer',
        ]);

        try {
            // Cari DO dengan status "draft" berdasarkan user
            $doDraft = DeliveryOrder::where('user_id', Auth::id())->where('do_no', 'draft')->first();

            if (!$doDraft) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harap masukkan barang terlebih dahulu!',
                ], 400);
            }

            // Update data draft menjadi DO final
            $doDraft->do_no = $this->generateDoNo();
            $doDraft->do_date = $request->tanggal_pengiriman;
            $doDraft->project_id = $request->project_id;
            $doDraft->shipment_address = $request->penerima;
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

    private function generateDoNo()
    {
        return 'DO/'. 'AJM/O/VII/-'. date('Ymd') . '/' . strtoupper(Str::random(3));
    }

    public function deleteDraft()
    {
        try {
            // Cari draft DO berdasarkan user yang login
            $doDraft = DeliveryOrder::where('user_id', Auth::id())->where('do_no', 'draft')->first();

            if (!$doDraft) {
                return response()->json([
                    'success' => false,
                    'message' => 'Draft tidak ditemukan!',
                ], 404);
            }

            // Hapus semua detail barang yang terkait dengan draft DO
            DeliveryOrderDetail::where('delivery_order_id', $doDraft->id)->delete();

            // Hapus draft DO
            $doDraft->delete();

            return response()->json([
                'success' => true,
                'message' => 'Draft berhasil dihapus!',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus draft!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

}

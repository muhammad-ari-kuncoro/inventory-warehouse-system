<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryOrderDetail;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class DeliveryOrderAPIController extends Controller
{
    //

    public function getdataALL()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Silakan login.'
                ], 401);
            }
            $data_delivery_order = DeliveryOrder::where('do_no', '!=', 'draft')->get();
            $data_project = Project::all();

            return response()->json([
                'success' => true,
                'message' => 'Data delivery order berhasil diambil.',
                'data' => [
                    'delivery_orders' => $data_delivery_order,
                    'projects' => $data_project
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getdataDraft()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Silakan login.'
                ], 401);
            }

            $data_project = Project::all();
            $do_draft = DeliveryOrder::where('user_id', $user->id)
                            ->where('do_no', 'draft')
                            ->first();

            return response()->json([
                'success' => true,
                'message' => 'Data draft delivery order berhasil diambil.',
                'data' => [
                    'projects' => $data_project,
                    'do_draft' => $do_draft
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data draft.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

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
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Silakan login untuk mengakses API.',
                ], 401);
            }
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

    public function detilUpdateAPI($id)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Silakan login untuk mengakses API.',
                ], 401);
            }
            $detail = DeliveryOrderDetail::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail delivery order ditemukan',
                'data' => $detail
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Detail tidak ditemukan',
                'error' => $th->getMessage()
            ], 404);
        }
    }
    public function apiUpdateDetail(Request $request, $id)
    {
        try {
            $request->validate([
                'item_description' => 'required',
                'item_size' => 'nullable',
                'item_weight' => 'nullable',
                'item_qty' => 'nullable',
                'satuan_barang' => 'nullable',
            ]);

            $detail = DeliveryOrderDetail::findOrFail($id);

            $detail->update([
                'item_description' => trim($request->item_description),
                'item_size' => $request->item_size,
                'item_weight' => $request->item_weight,
                'item_qty' => $request->item_qty,
                'item_measurement' => $request->satuan_barang,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detail berhasil diupdate',
                'data' => $detail
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate detail',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function apiPrintPDF($id)
{
    try {
        $deliveryOrder = DeliveryOrder::with('details')->findOrFail($id);

        $totalQty = $deliveryOrder->details->sum('item_qty');
        $totalWeight = $deliveryOrder->details->sum('item_weight');

        $data['deliveryOrder'] = $deliveryOrder;
        $data['totalQty'] = $totalQty;
        $data['totalWeight'] = $totalWeight;

        $pdf = Pdf::loadView('delivery_order.pdf', $data);

        $fileName = preg_replace('/[\/\\\\]/', '_', $deliveryOrder->do_no) . '.pdf';

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal generate PDF',
            'error' => $e->getMessage()
        ], 500);
    }
}



}

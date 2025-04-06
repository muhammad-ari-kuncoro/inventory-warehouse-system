<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConsumableIssuance;
use App\Models\Consumables;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumableIssuanceApiController extends Controller
{
    // GET: /api/consumable-issuance
    public function index()
    {
        $userId = Auth::id();
        $data = ConsumableIssuance::where('user_id', $userId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pengambilan consumable berhasil diambil',
            'data' => $data
        ]);
    }

    // POST: /api/consumable-issuance
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengambilan' => 'required|date',
            'consumable_id' => 'required|exists:consumables,id',
            'project_id' => 'required|exists:menu_project,id',
            'quantity' => 'required|numeric|min:1',
            'jenis_quantity' => 'required|string',
            'keterangan_consumable' => 'required|string',
        ]);

        try {
            $new = ConsumableIssuance::create([
                'tanggal_pengambilan'   => $request->tanggal_pengambilan,
                'user_id'               => Auth::id(),
                'consumable_id'         => $request->consumable_id,
                'project_id'            => $request->project_id,
                'quantity'              => $request->quantity,
                'jenis_quantity'        => $request->jenis_quantity,
                'keterangan_consumable' => $request->keterangan_consumable
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $new
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET: /api/consumable-issuance/{id}
    public function show($id)
    {
        $data = ConsumableIssuance::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // PUT: /api/consumable-issuance/{id}
    public function update(Request $request, $id)
    {
        $data = ConsumableIssuance::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'tanggal_pengambilan' => 'required|date',
            'consumable_id' => 'required|exists:consumables,id',
            'project_id' => 'required|exists:menu_project,id',
            'quantity' => 'required|numeric|min:1',
            'jenis_quantity' => 'required|string',
            'keterangan_consumable' => 'required|string',
        ]);

        $data->update([
            'tanggal_pengambilan' => $request->tanggal_pengambilan,
            'consumable_id' => $request->consumable_id,
            'project_id' => $request->project_id,
            'quantity' => $request->quantity,
            'jenis_quantity' => $request->jenis_quantity,
            'keterangan_consumable' => $request->keterangan_consumable
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $data
        ]);
    }

    // DELETE: /api/consumable-issuance/{id}
    public function destroy($id)
    {
        $data = ConsumableIssuance::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}

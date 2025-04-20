<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CheckInTools;
use App\Models\CheckOutTools;
use Illuminate\Http\Request;

class ToolsCheckInController extends Controller
{
    //
    public function apiIndex()
    {
        $data = CheckInTools::with('checkoutTool.tool')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pengembalian alat',
            'data' => $data
        ]);
    }
    // public function apiShow($id)
    // {
    //     $checkin = CheckInTools::with('checkoutTool.tool')->find($id);

    //     if (!$checkin) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data tidak ditemukan'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Detail pengembalian alat',
    //         'data' => $checkin
    //     ]);
    // }

    public function apiCheckin(Request $request, $id)
    {
        $peminjaman = CheckOutTools::find($id);

        if (!$peminjaman || $peminjaman->status_kembali) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan atau sudah dikembalikan.'
            ], 404);
        }

        $alat = $peminjaman->tool;
        $alat->quantity += $peminjaman->quantity;
        $alat->save();

        $peminjaman->update(['status_kembali' => true]);

        $checkIn = CheckInTools::create([
            'checkout_tool_id' => $peminjaman->id,
            'tanggal_pengembalian' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alat berhasil dikembalikan.',
            'data' => $checkIn
        ]);
    }



}

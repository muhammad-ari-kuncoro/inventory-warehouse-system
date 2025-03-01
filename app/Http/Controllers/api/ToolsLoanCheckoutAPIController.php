<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CheckOutTools;
use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ToolsLoanCheckoutAPIController extends Controller
{
    //

    public function store(Request $request)
{


    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User tidak terautentikasi!'
        ], 401);
    }


    $request->validate([
        'tanggal_pengambilan' => 'required|date',
        'bagian_divisi' => 'required|min:3|max:100',
        'nama_peminjam_alat' => 'required|min:3|max:100',
        'tool_id' => 'required|exists:tools,id',
        'quantity' => 'required|numeric|min:1',
        'jenis_quantity' => 'required|min:1|max:100',
        'keterangan_alat' => 'required|min:3|max:255',
    ]);

    DB::beginTransaction();
    try {
        $user = Auth::user();
        $today = now()->toDateString();

        // Hitung jumlah peminjaman user hari ini
        $loanCount = CheckOutTools::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();

        // Cek apakah user sudah mencapai batas 5 kali peminjaman per hari
        if ($loanCount >= 5) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah mencapai batas maksimal 5 peminjaman hari ini!',
            ], 400);
        }

        $tool = Tools::findOrFail($request->tool_id);

        // Cek apakah stok cukup
        if ($tool->stok < $request->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stok alat tidak mencukupi!',
            ], 400);
        }




        // Simpan data peminjaman alat dengan user_id dan role
        $checkOutTool = CheckOutTools::create([
            'user_id'             => $user->id, // Menyimpan user_id
            'tanggal_pengambilan' => $request->tanggal_pengambilan,
            'bagian_divisi'       => $request->bagian_divisi,
            'nama_peminjam_alat'  => $request->nama_peminjam_alat,
            'tool_id'             => $request->tool_id,
            'quantity'            => $request->quantity,
            'jenis_quantity'      => $request->jenis_quantity,
            'keterangan_alat'     => $request->keterangan_alat,
        ]);

        // Kurangi stok alat
        $tool->decrement('stok', $request->quantity);

        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Peminjaman berhasil!',
            'data' => $checkOutTool
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan data!',
            'error' => $e->getMessage()
        ], 500);
    }
}


}

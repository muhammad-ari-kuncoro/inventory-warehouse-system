<?php

namespace App\Http\Controllers;

use App\Models\CheckInTools;
use App\Http\Controllers\Controller;
use App\Models\CheckOutTools;
use App\Models\Tools;
use Illuminate\Http\Request;

class CheckInToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         //
         $data['sub_title'] = 'Pengembalian Alat';
         $data['title'] = 'Menu Pengembalian Alat Halaman';
         // $data['data_project'] = Project::all();
         $data['data_tools_in'] = CheckInTools::all();
         return view('control_tools.check_in_tools.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['sub_title'] = 'Pengembalian Alat';
        $data['title'] = 'Menu Tambah Pengembalian Alat Halaman';
         // $data['data_project'] = Project::all();
         $data['data_tools'] = Tools::all();
         return view('control_tools.check_in_tools.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }
    public function checkin($id) {
        $peminjaman = CheckOutTools::findOrFail($id);

        // Ambil data alat dari relasi
        $alat = $peminjaman->tool;

        // Tambahkan quantity yang dipinjam ke stok alat
        $alat->quantity += $peminjaman->quantity;
        $alat->save();

        // Update status peminjaman
        $peminjaman->update(['status_kembali' => true]);

        // Simpan ke tabel pengembalian
        CheckInTools::create([
            'checkout_tool_id' => $peminjaman->id,
            'tanggal_pengembalian' => now(),
        ]);

        return redirect()->back()->with('success', 'Alat berhasil dikembalikan dan stok diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        //
        $data['sub_title'] = 'Pengembalian Alat';
        $data['title'] = 'Menu Detail Pengembalian Alat Halaman';
        $data['find_id_check_in_tool'] = CheckInTools::findOrFail($id);
         return view('control_tools.check_in_tools.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CheckInTools $checkInTools)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CheckInTools $checkInTools)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CheckInTools $checkInTools)
    {
        //
    }
}

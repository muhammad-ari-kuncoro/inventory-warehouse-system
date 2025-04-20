<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Consumables;
use Illuminate\Http\Request;
use App\Models\CheckOutTools;
use App\Http\Controllers\Controller;
use App\Models\CheckInTools;
use App\Models\Tools;
use Illuminate\Support\Facades\Auth;

class CheckOutToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Peminjaman Alat';
        $data['title'] = 'Menu Peminjaman Alat Halaman';
        // $data['data_project'] = Project::all();
        $data['data_tools'] = CheckOutTools::where('status_kembali', false)
        ->where('user_id', auth()->id()) // opsional, biar cuma lihat milik sendiri
        ->with('tool')
        ->get();

        return view('control_tools.check_out_tools.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['sub_title'] = 'Peminjaman Alat';
        $data['title'] = 'Menu Tambah Peminjaman Alat Halaman';
        // $data['data_project'] = Project::all();
        $data['data_tools'] = Tools::all();
        return view('control_tools.check_out_tools.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'quantity'  => 'required|integer|min:1',
        ]);

        $alat = Tools::findOrFail($request->tool_id);

        if ($request->quantity > $alat->quantity) {
            return redirect()->back()->with('error', 'Jumlah yang diminta melebihi quantity tersedia.');
        }

        // $alat->quantity -= $request->quantity;
        $alat->save();

        CheckOutTools::create([
            'user_id'       => Auth::id(), // otomatis ambil user yg login
            'tool_id'       => $request->tool_id,
            'quantity'        => $request->quantity,
            'tanggal_pengambilan'=> now()
        ]);

        return redirect()->route('check-out-tools.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $data['sub_title'] = 'Peminjaman Alat';
        $data['title'] = 'Menu Tambah Peminjaman Alat Halaman';
         $data['find_id'] = CheckOutTools::findOrFail($id);
         return view('control_tools.check_out_tools.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CheckOutTools $checkOutTools)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CheckOutTools $checkOutTools)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CheckOutTools $checkOutTools)
    {
        //
    }
}

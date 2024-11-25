<?php

namespace App\Http\Controllers;

use App\Models\CheckInTools;
use App\Http\Controllers\Controller;
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
        //
        $request->validate([
            'tanggal_pengembalian'   => 'required|min:3|max:100',
            'bagian_divisi'         => 'required|min:3|max:100',
            'nama_pengembalian'     => 'required|min:3|max:100',
            'tool_id'               => 'required|exists:tools,id',
            'quantity'              => 'required|numeric|min:1',
            'jenis_quantity'        => 'required|min:1|max:100',
            'keterangan_alat'       => 'required|min:3|max:100',
        ]);

        // dd($request);
        try {
            //code...
            CheckInTools::create([
                'tanggal_pengembalian'              => $request->tanggal_pengembalian,
                'bagian_divisi'                     => $request->bagian_divisi,
                'nama_pengembalian'                 => $request->nama_pengembalian,
                'tool_id'                           => $request->tool_id,
                'quantity'                          => $request->quantity,
                'jenis_quantity'                    => $request->jenis_quantity,
                'keterangan_alat'                   => $request->keterangan_alat,
            ]);
            return redirect()->route('check-in-tools.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            //throw $th;
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
        }
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

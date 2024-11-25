<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Consumables;
use Illuminate\Http\Request;
use App\Models\CheckOutTools;
use App\Http\Controllers\Controller;
use App\Models\Tools;

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
        $data['data_tools'] = CheckOutTools::all();
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
        //
        $request->validate([
            'tanggal_pengambilan' => 'required|min:3|max:100',
            'bagian_divisi' => 'required|min:3|max:100',
            'nama_peminjam_alat' => 'required|min:3|max:100',
            'tool_id' => 'required|exists:tools,id',
            'quantity' => 'required|numeric|min:1',
            'jenis_quantity' => 'required|min:1|max:100',
            'keterangan_alat' => 'required|min:3|max:100',
        ]);
        // dd($request);

         // dd($request);
         try {
            //code...
            CheckOutTools::create([
                'tanggal_pengambilan'               => $request->tanggal_pengambilan,
                'bagian_divisi'                     => $request->bagian_divisi,
                'nama_peminjam_alat'                => $request->nama_peminjam_alat,
                'tool_id'                           => $request->tool_id,
                'quantity'                          => $request->quantity,
                'jenis_quantity'                    => $request->jenis_quantity,
                'keterangan_alat'                   => $request->keterangan_alat
            ]);
            return redirect()->route('check-out-tools.index')->with('success', 'Data berhasil ditambahkan!');

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

<?php

namespace App\Http\Controllers;

use App\Models\HydrotestMaterialLending;
use App\Http\Controllers\Controller;
use App\Models\Materials;
use Illuminate\Http\Request;

class HydrotestMaterialLendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Peminjaman Materials Hydrotest';
        $data['title'] = 'Menu Peminjaman Materials Hydrotest Halaman';
        // $data['data_project'] = Project::all();
        $data['Material_lending'] = HydrotestMaterialLending::all();
        return view('material_exchanger.hydrotest_material_lending.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['sub_title'] = 'Peminjaman Materials Hydrotest';
        $data['title'] = 'Menu Peminjaman Materials Hydrotest Halaman';
        $data['data_materials'] = Materials::all();
        // $data['data_tools_in'] = CheckInTools::all();
        return view('material_exchanger.hydrotest_material_lending.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tgl_pinjam_material'   => 'required|min:3|max:100',
            'bagian_divisi'         => 'required|min:3|max:100',
            'nama_peminjam'         => 'required|min:3|max:100',
            'material_id'           => 'required|exists:materials,id',
            'quantity'              => 'required|numeric|min:1',
            'jenis_quantity'        => 'required|min:1|max:100',
            'jenis_material'        => 'required|min:1|max:100',
            'keterangan_material'       => 'required|min:3|max:100',
        ]);

        // dd($request);

        try {
            //code...
            HydrotestMaterialLending::create([
                'tgl_pinjam_material'               => $request->tgl_pinjam_material,
                'bagian_divisi'                     => $request->bagian_divisi,
                'nama_peminjam'                => $request->nama_peminjam,
                'material_id'                           => $request->material_id,
                'quantity'                          => $request->quantity,
                'jenis_quantity'                    => $request->jenis_quantity,
                'jenis_material'                    => $request->jenis_material,
                'keterangan_material'                   => $request->keterangan_material
            ]);
            return redirect()->route('hydrotest-material-lending.index')->with('success', 'Data berhasil ditambahkan!');

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
    public function show(HydrotestMaterialLending $hydrotestMaterialLending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HydrotestMaterialLending $hydrotestMaterialLending)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HydrotestMaterialLending $hydrotestMaterialLending)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HydrotestMaterialLending $hydrotestMaterialLending)
    {
        //
    }
}

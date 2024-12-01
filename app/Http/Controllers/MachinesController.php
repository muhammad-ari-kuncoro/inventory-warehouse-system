<?php

namespace App\Http\Controllers;

use App\Models\Machines;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Machine';
        $data['title'] = 'Menu Machine Halaman';
        $data['data_machine_asset'] = Machines::all();
        return view('machines.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //Validasi
        $request->validate([
            'nama_mesin' => 'required|min:3|max:255',
            'spesifikasi_mesin' => 'required|min:3|max:255',
            'jenis_mesin' => 'required|min:1|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_quantity' => 'required|min:1|max:255',
            'harga_mesin' => 'required|min:1|max:255',

        ]);

        try {
            Machines::create([
                'nama_mesin' => $request->nama_mesin,
                'spesifikasi_mesin' => $request->spesifikasi_mesin,
                'jenis_mesin' => $request->jenis_mesin,
                'quantity' => $request->quantity,
                'jenis_quantity' => $request->jenis_quantity,
                'harga_mesin' => $request->harga_mesin,
            ]);
            return redirect()->route('machine.index')->with('success', 'Data berhasil ditambahkan!');

        } catch (\Exception $e) {
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Machines $machines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
         //
         $data['sub_title'] = 'Machine';
        $data['title'] = 'Menu Machine Halaman';
         $data['find_id'] = Machines::findOrFail($id);
         return view('machines.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
         //Validasi
         $request->validate([
            'nama_mesin' => 'required|min:3|max:255',
            'spesifikasi_mesin' => 'required|min:3|max:255',
            'jenis_mesin' => 'required|min:1|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_quantity' => 'required|min:1|max:255',
            'harga_mesin' => 'required|min:1|max:255',

        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Machines $machines)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ConsumableIssuance;
use App\Http\Controllers\Controller;
use App\Models\Consumables;
use App\Models\Project;
use Illuminate\Http\Request;

class ConsumableIssuanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['title'] = 'Formulir Pengambilan Consumable';
        $data['sub_title'] = 'Pengambilan Consumable';
        $data['data_project'] = Project::all();
        return view('consumable_issuance.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = 'Formulir Pengambilan Consumable';
        $data['sub_title'] = 'Pengambilan Consumable';
        $data['data_consumables'] = Consumables::all();
        $data['data_project'] = Project::all();
        return view('consumable_issuance.create',$data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tanggal_pengambilan' => 'required|min:3|max:100',
            'nama_pengambil' => 'required|min:3|max:100',
            'consumable_id' => 'required|exists:consumables,id',
            'quantity' => 'required|numeric|min:1',
            'jenis_quantity' => 'required|min:1|max:100',
            'keterangan_consumable' => 'required|min:3|max:100',
        ]);
        dd($request);
        try {
            //code...
            ConsumableIssuance::create([
                'tanggal_pengambilan'               => $request->tanggal_pengambilan,
                'nama_pengambil'                    => $request->nama_pengambil,
                'consumable_id'                     => $request->consumable_id,
                'quantity'                          => $request->quantity,
                'jenis_quantity'                    => $request->jenis_quantity,
                'keterangan_consumable'             => $request->keterangan_consumable
            ]);
            return redirect()->route('consumable-issuance.index')->with('success', 'Data berhasil ditambahkan!');

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
    public function show(ConsumableIssuance $consumableIssuance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConsumableIssuance $consumableIssuance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConsumableIssuance $consumableIssuance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsumableIssuance $consumableIssuance)
    {
        //
    }
}

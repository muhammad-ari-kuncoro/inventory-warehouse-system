<?php

namespace App\Http\Controllers;

use App\Models\Consumables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
class ConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Consumables';
        $data['title'] = 'Menu Consumable Halaman';
        $data['data_project'] = Project::all();
        $data['data_consumables'] = Consumables::paginate(5);
        return view('consumables.index',$data);
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
            'nama_consumable' => 'required|min:5|max:255',
            'spesifikasi_consumable' => 'required|min:5|max:255',
            'jenis_quantity' => 'required|min:1|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_consumable' => 'required|min:5|max:255',
            'project_id' => 'required',

        ]);
        try {
            Consumables::create([
                'nama_consumable' => $request->nama_consumable,
                'spesifikasi_consumable' => $request->spesifikasi_consumable,
                'jenis_quantity' => $request->jenis_quantity,
                'quantity' => $request->quantity,
                'jenis_consumable' => $request->jenis_consumable,
                'project_id' => $request->project_id
            ]);
            return redirect()->route('consumable.index')->with('success', 'Data berhasil ditambahkan!');

        } catch (\Exception $e) {
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consumables $consumables)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $data['sub_title'] = 'Consumables';
        $data['title'] = 'Halaman Edit Consumable';
        $data['data_project'] = Project::all();
        $data['find_id'] = Consumables::findOrFail($id);
        $data['data_all'] = Consumables::all();
        return view('consumables.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
         //Validasi
         $request->validate([
            'nama_consumable'          => 'required|min:5|max:255',
            'spesifikasi_consumable'   => 'required|min:5|max:255',
            'jenis_quantity'           => 'required|min:1|max:255',
            'quantity'                 => 'required|min:1|max:100',
            'jenis_consumable'         => 'min:5|max:255',
            'project_id'               => 'required',

        ]);
        $updateConsumable = Consumables::findOrFail($id);
        $updateConsumable->nama_consumable          = $request->nama_consumable;
        $updateConsumable->spesifikasi_consumable   = $request->spesifikasi_consumable;
        $updateConsumable->jenis_quantity         = $request->jenis_quantity;
        $updateConsumable->quantity               = $request->quantity;
        $updateConsumable->jenis_consumable         = $request->jenis_consumable;
        $updateConsumable->project_id             = $request->project_id;
        $updateConsumable->save();
        // Redirect ke halaman yang diinginkan
        return redirect()->route('consumable.index')->with('editSuccess', 'Data berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consumables $consumables)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Ambil input pencarian
        $search = $request->input('search');
        // Cek apakah ada input pencarian
        if ($search) {
            // Jika ada, lakukan pencarian di beberapa kolom
            $cari_alat = Tools::where('nama_alat', 'LIKE', '%' . $search . '%')
                ->orWhere('spesifikasi_alat', 'LIKE', '%' . $search . '%')
                ->orWhere('jenis_alat', 'LIKE', '%' . $search . '%')
                ->paginate(2); // Sesuaikan jumlah data per halaman
        } else {
            // Jika tidak ada pencarian, tampilkan semua data
            $cari_alat = Tools::paginate(5);
        }


        $data['cari_alat'] = $cari_alat;
        $data['sub_title'] = 'Tools';
        $data['title'] = 'Menu Tools Halaman';
        $data['data_tools'] = Tools::paginate(5);
        return view('Tools.index',$data);

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
            'nama_alat' => 'required|min:5|max:255',
            'spesifikasi_alat' => 'required|min:5|max:255',
            'jenis_alat' => 'required|min:1|max:255',
            'tipe_alat' => 'required|min:1|max:100',
            'quantity' => 'required|min:1|max:255',
            'jenis_quantity' => 'required',

        ]);

        // dd($request);
        try {
            //code...
            Tools::create([
                'nama_alat' => $request->nama_alat,
                'spesifikasi_alat' => $request->spesifikasi_alat,
                'jenis_alat' => $request->jenis_alat,
                'tipe_alat' => $request->tipe_alat,
                'quantity' => $request->quantity,
                'jenis_quantity' => $request->jenis_quantity
            ]);
            // dd($tambah);
            return redirect()->route('tools.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Tools $tools)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tools $tools)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tools $tools)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tools $tools)
    {
        //
    }
}

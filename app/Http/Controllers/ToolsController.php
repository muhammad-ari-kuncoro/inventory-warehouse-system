<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {



        $data['sub_title'] = 'Tools';
        $data['title'] = 'Menu Tools Halaman';
        $data['data_tools'] = Tools::paginate(5);
        return view('tools_machine.index',$data);

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();

            // Baca file Excel
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Proses setiap baris (abaikan header)
            foreach ($sheet as $index => $row) {
                // Lewati baris header
                if ($index === 0) continue;

                // Validasi setiap baris data
                if (
                    empty($row['A']) || empty($row['B']) || empty($row['C']) ||
                    empty($row['D']) || empty($row['E']) || empty($row['F']) ||
                    empty($row['G'])
                ) {
                    // Skip jika ada kolom yang kosong
                    continue;
                }

                Tools::create([
                    'kode_alat' => $row['A'],
                    'nama_alat' => $row['B'],
                    'spesifikasi_alat' => $row['C'],
                    'jenis_alat' => $row['D'],
                    'tipe_alat' => $row['E'],
                    'quantity' => $row['F'],
                    'jenis_quantity' => $row['G'],
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->back()->with('delete', 'Terjadi kesalahan: ' . $e->getMessage());
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
    public function edit($id)
    {
        //
        $data['title'] = 'Edit Menu Alat Atau Mesin';
        $data['sub_title'] = 'Tools';
        $data['find_id'] = Tools::findOrFail($id);
        return view('tools_machine.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
         //Validasi Update
        //  $this->validate($request, [
        //     'nama_alat' => 'required|min:5|max:255',
        //     'spesifikasi_alat' => 'required|min:5|max:255',
        //     'jenis_alat' => 'required|min:5|max:255',
        //     'tipe_alat' => 'required|min:5|max:255',
        //     'quantity' => 'required|min:1|max:255',
        //     'jenis_quantity' => 'required|min:5|max:255'

        // ]);

        $request->validate([
            'nama_alat' => 'required|min:5|max:255',
            'spesifikasi_alat' => 'required|min:5|max:255',
            'jenis_alat' => 'required|min:1|max:255',
            'tipe_alat' => 'required|min:1|max:100',
            'quantity' => 'required|min:1|max:255',
            'jenis_quantity' => 'required',

        ]);
        $updateTools = Tools::findOrFail($id);
        $updateTools->nama_alat = $request->nama_alat;
        $updateTools->spesifikasi_alat = $request->spesifikasi_alat;
        $updateTools->jenis_alat = $request->jenis_alat;
        $updateTools->tipe_alat = $request->tipe_alat;
        $updateTools->quantity = $request->quantity;
        $updateTools->jenis_quantity = $request->jenis_quantity;
        $updateTools->save();
        // Redirect ke halaman yang diinginkan
        return redirect()->route('tools.index')->with('editSuccess', 'Data berhasil Di Edit!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tools $tools)
    {
        //
    }
}

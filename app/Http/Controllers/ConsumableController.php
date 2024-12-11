<?php

namespace App\Http\Controllers;

use App\Models\Consumables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
            'harga_consumable' => 'required|min:1|max:255',
            'project_id' => 'nullable',

        ]);
        try {
            Consumables::create([
                'nama_consumable' => $request->nama_consumable,
                'spesifikasi_consumable' => $request->spesifikasi_consumable,
                'jenis_quantity' => $request->jenis_quantity,
                'quantity' => $request->quantity,
                'jenis_consumable' => $request->jenis_consumable,
                'harga_consumable' => $request->harga_consumable,
                'project_id' => $request->project_id
            ]);
            return redirect()->route('consumable.index')->with('success', 'Data berhasil ditambahkan!');

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

                Consumables::create([
                    'kode_consumable' => $row['A'],
                    'nama_consumable' => $row['B'],
                    'spesifikasi_consumable' => $row['C'],
                    'quantity' => $row['D'],
                    'jenis_quantity' => $row['E'],
                    'jenis_consumable' => $row['F'],
                    'harga_consumable' => $row['G'],
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
            'quantity'                 => 'required|min:1|max:100',
            'project_id'               => 'required',

        ]);
        $updateConsumable = Consumables::findOrFail($id);
        $updateConsumable->nama_consumable          = $request->nama_consumable;
        $updateConsumable->spesifikasi_consumable   = $request->spesifikasi_consumable;
        $updateConsumable->jenis_quantity         = $request->jenis_quantity;
        $updateConsumable->quantity               = $request->quantity;
        $updateConsumable->jenis_consumable         = $request->jenis_consumable;
        $updateConsumable->harga_consumable         = $request->harga_consumable;
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

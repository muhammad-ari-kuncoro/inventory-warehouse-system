<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Materials;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MaterialController extends Controller
{
    public function index()
    {
        $data['data_material'] = Materials::all();
        $data['sub_title'] = 'Materials';
        $data['title'] = 'Material Page';
        $data['data_project'] = Project::all();
        return view('materials.index', $data);
    }

    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validasi
        $request->validate([
            'nama_material' => 'required|min:5|max:255',
            'spesifikasi_material' => 'required|min:5|max:255',
            'jenis_quantity' => 'required|min:1|max:255',
            'quantity' => 'required|min:1|max:100',
            'jenis_material' => 'required|min:1|max:255',
            'harga_material' => 'required|min:1|max:255',
            'project_id' => 'nullable',
        ]);

        try {
            Materials::create([
                'nama_material' => $request->nama_material,
                'spesifikasi_material' => $request->spesifikasi_material,
                'jenis_quantity' => $request->jenis_quantity,
                'quantity' => $request->quantity,
                'jenis_material' => $request->jenis_material,
                'harga_material' => $request->harga_material,
                'project_id' => $request->project_id,
            ]);
            // dd($tambah);
            return redirect()->route('materials.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $th) {
            //erros jika data tidak sesuai
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    public function exportPage()
    {
        $data['title']      = 'Export PDF Material';
        $data['sub_title']  = 'Materials';
        $data['projects'] = Project::all();
        return view('materials.filter-export-pdf', $data);
    }

    public function exportDownload(Request $request)
    {
        $query = Materials::with('project');

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $data['materials'] = $query->get();
        $pdf = Pdf::loadView('materials.dashboard-export', $data);
        return $pdf->download('material-' . now()->format('d-m-Y') . '.pdf');
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
                if ($index === 0) {
                    continue;
                }

                // Validasi setiap baris data
                if (empty($row['A']) || empty($row['B']) || empty($row['C']) || empty($row['D']) || empty($row['E']) || empty($row['F']) || empty($row['G'])) {
                    // Skip jika ada kolom yang kosong
                    continue;
                }

                Materials::create([
                    'kode_material' => $row['A'],
                    'nama_material' => $row['B'],
                    'spesifikasi_material' => $row['C'],
                    'quantity' => $row['D'],
                    'jenis_quantity' => $row['E'],
                    'jenis_material' => $row['F'],
                    'harga_material' => $row['G'],
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('delete', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['sub_title'] = 'Materials';
        $data['title'] = 'Material Show Page';
        $data['data_project'] = Project::all();
        $data['find_id'] = Materials::findOrFail($id);
        $data['data_all'] = Materials::all();
        return view('materials.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['sub_title'] = 'Materials';
        $data['title'] = 'Material Edit Page';
        $data['data_project'] = Project::all();
        $data['find_id'] = Materials::findOrFail($id);
        $data['data_all'] = Materials::all();
        return view('materials.edit', $data);
    }

    public function update(Request $request, $id)
    {
        //Validasi
        $request->validate([
            'nama_material'         => 'required|min:5|max:255',
            'spesifikasi_material'  => 'required|min:5|max:255',
            'jenis_quantity'        => 'required|min:1|max:255',
            'quantity'              => 'required|min:1|max:100',
            'jenis_material'        => 'required|min:1|max:255',
            'harga_material'        => 'required|min:1|max:100',
            'project_id'            => 'nullable',
        ]);

        // dd($request);

        $updateMaterial                             = Materials::findOrFail($id);
        $updateMaterial->nama_material              = $request->nama_material;
        $updateMaterial->spesifikasi_material       = $request->spesifikasi_material;
        $updateMaterial->jenis_quantity             = $request->jenis_quantity;
        $updateMaterial->quantity                   = $request->quantity;
        $updateMaterial->jenis_material             = $request->jenis_material;
        $updateMaterial->harga_material             = $request->harga_material;
        $updateMaterial->project_id                 = $request->project_id;
        $updateMaterial->save();
        // Redirect ke halaman yang diinginkan
        return redirect()->route('material.index')->with('editSuccess', 'Data berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materials $materials)
    {
        //
    }
}

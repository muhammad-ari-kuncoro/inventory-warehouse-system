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
        $data['title']              = 'Material Page';
        $data['sub_title']          = 'Materials';
        $data['data_material']      = Materials::all();
        $data['data_project']       = Project::all();
        return view('materials.index', $data);
    }
    public function multipe_create()
    {
        $data['title']              = 'Material Multiple Page';
        $data['sub_title']          = 'Materials';
        $data['data_material']      = Materials::all();
        $data['data_project']       = Project::all();
        return view('materials.create-multiple-data', $data);
    }
    public function multiple_data(Request $request)
    {
        try {
            $data = $request->input('data');
            if (!$data || !is_array($data) || count($data) === 0) {
                return response()->json(['message' => 'Empty Data, Nothing to save!'], 422);
            }

            $created = [];
            foreach ($data as $idx => $item) {
                if (empty($item['nama_material']) || empty($item['spesifikasi_material']) || empty($item['jenis_quantity']) || empty($item['quantity']) || empty($item['jenis_material'])) {
                    return response()->json(
                        [
                            'message' => "Item index {$idx} Field Has Empty.",
                        ],
                        422,
                    );
                }

                $created[] = Materials::create([
                    'nama_material'                 => $item['nama_material'],
                    'spesifikasi_material'          => $item['spesifikasi_material'],
                    'jenis_quantity'                => $item['jenis_quantity'],
                    'quantity'                      => $item['quantity'],
                    'jenis_material'                => $item['jenis_material'],
                    'harga_material'                => $item['harga_material'] ?? null,
                    'project_id'                    => $item['project_id'] ?? null,
                ]);
            }

            return response()->json([
                'message'   => 'All Data Has Been Saved!',
                'count'     => count($created),
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Failed to Save Data: ' . $th->getMessage(),
                ],
                500,
            );
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_material'                     => 'required|min:5|max:255',
            'spesifikasi_material'              => 'required|min:5|max:255',
            'jenis_quantity'                    => 'required|min:1|max:255',
            'quantity'                          => 'required|min:1|max:100',
            'jenis_material'                    => 'required|min:1|max:255',
            'harga_material'                    => 'required|min:1|max:255',
            'project_id' => 'nullable',
        ]);
        try {
            Materials::create([
                'nama_material'                 => $request->nama_material,
                'spesifikasi_material'          => $request->spesifikasi_material,
                'jenis_quantity'                => $request->jenis_quantity,
                'quantity'                      => $request->quantity,
                'jenis_material'                => $request->jenis_material,
                'harga_material'                => $request->harga_material,
                'project_id'                    => $request->project_id,
            ]);
            return redirect()->route('materials.index')->with('success', 'Data Successfully Added!');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Failed to save Data!');
        }
    }

    public function exportPage()
    {
        $data['title']      = 'Export PDF Material';
        $data['sub_title']  = 'Materials';
        $data['projects']   = Project::all();
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
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            foreach ($sheet as $index => $row) {
                if ($index === 0) {
                    continue;
                }
                if (empty($row['A']) || empty($row['B']) || empty($row['C']) || empty($row['D']) || empty($row['E']) || empty($row['F']) || empty($row['G'])) {
                    continue;
                }

                Materials::create([
                    'kode_material'             => $row['A'],
                    'nama_material'             => $row['B'],
                    'spesifikasi_material'      => $row['C'],
                    'quantity'                  => $row['D'],
                    'jenis_quantity'            => $row['E'],
                    'jenis_material'            => $row['F'],
                    'harga_material'            => $row['G'],
                ]);
            }

            return redirect()->back()->with('success', 'Data Successfully Imported!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('delete', 'Failed to procced: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['sub_title']      = 'Materials';
        $data['title']          = 'Material Show Page';
        $data['data_project']   = Project::all();
        $data['find_id']        = Materials::findOrFail($id);
        $data['data_all']       = Materials::all();
        return view('materials.show', $data);
    }

    public function edit($id)
    {
        $data['sub_title']      = 'Materials';
        $data['title']          = 'Material Edit Page';
        $data['data_project']   = Project::all();
        $data['find_id']        = Materials::findOrFail($id);
        $data['data_all']       = Materials::all();
        return view('materials.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_material'              => 'required|min:5|max:255',
            'spesifikasi_material'       => 'required|min:5|max:255',
            'jenis_quantity'             => 'required|min:1|max:255',
            'quantity'                   => 'required|min:1|max:100',
            'jenis_material'             => 'required|min:1|max:255',
            'harga_material'             => 'required|min:1|max:100',
            'project_id'                 => 'nullable',
        ]);
        $updateMaterial                         = Materials::findOrFail($id);
        $updateMaterial->nama_material          = $request->nama_material;
        $updateMaterial->spesifikasi_material   = $request->spesifikasi_material;
        $updateMaterial->jenis_quantity         = $request->jenis_quantity;
        $updateMaterial->quantity               = $request->quantity;
        $updateMaterial->jenis_material         = $request->jenis_material;
        $updateMaterial->harga_material         = $request->harga_material;
        $updateMaterial->project_id             = $request->project_id;
        $updateMaterial->save();
        return redirect()->route('material.index')->with('editSuccess', 'Data Successfully Updated!');
    }

}

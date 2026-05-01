<?php

namespace App\Http\Controllers;

use App\Models\Consumables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ConsumableController extends Controller
{
    public function index()
    {
        $data['title']              = 'Consumable Page';
        $data['sub_title']          = 'Consumables';
        $data['data_project']       = Project::all();
        $data['data_consumables']   = Consumables::paginate(5);
        return view('consumables.index', $data);
    }

    public function multiple_create()
    {
        $data['title']              = 'Consumable Multiple Page';
        $data['sub_title']          = 'Consumables';
        $data['data_project']       = Project::all();
        $data['data_consumables']   = Consumables::all();
        return view('consumables.create-multiple-data', $data);
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
                if (empty($item['nama_consumable']) || empty($item['spesifikasi_consumable']) || empty($item['jenis_quantity']) || empty($item['quantity']) || empty($item['jenis_consumable'])) {
                    return response()->json(
                        [
                            'message' => "Item index {$idx} Field Has Empty.",
                        ],
                        422,
                    );
                }

                $created[] = Consumables::create([
                    'nama_consumable'           => $item['nama_consumable'],
                    'spesifikasi_consumable'    => $item['spesifikasi_consumable'],
                    'jenis_quantity'            => $item['jenis_quantity'],
                    'quantity'                  => $item['quantity'],
                    'jenis_consumable'          => $item['jenis_consumable'],
                    'harga_consumable'          => $item['harga_consumable'] ?? null,
                    'project_id'                => $item['project_id'] ?? null,
                ]);
            }

            return response()->json([
                'message' => 'All Data Has Been Saved!',
                'count' => count($created),
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
            'nama_consumable'           => 'required|min:5|max:255',
            'spesifikasi_consumable'    => 'required|min:5|max:255',
            'jenis_quantity'            => 'required|min:1|max:255',
            'quantity'                  => 'required|min:1|max:100',
            'jenis_consumable'          => 'required|min:5|max:255',
            'harga_consumable'          => 'required|min:1|max:255',
            'project_id'                => 'nullable',
        ]);
        try {
            Consumables::create([
                'nama_consumable'           => $request->nama_consumable,
                'spesifikasi_consumable'    => $request->spesifikasi_consumable,
                'jenis_quantity'            => $request->jenis_quantity,
                'quantity'                  => $request->quantity,
                'jenis_consumable'          => $request->jenis_consumable,
                'harga_consumable'          => $request->harga_consumable,
                'project_id'                => $request->project_id,
            ]);
            return redirect()->route('consumable.index')->with('success', 'Data Has Been Added!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data!');
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

            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            foreach ($sheet as $index => $row) {
                if ($index === 0) {
                    continue;
                }
                if (empty($row['A']) || empty($row['B']) || empty($row['C']) || empty($row['D']) || empty($row['E']) || empty($row['F']) || empty($row['G'])) {
                    continue;
                }

                Consumables::create([
                    'kode_consumable'          => $row['A'],
                    'nama_consumable'          => $row['B'],
                    'spesifikasi_consumable'   => $row['C'],
                    'quantity'                 => $row['D'],
                    'jenis_quantity'           => $row['E'],
                    'jenis_consumable'         => $row['F'],
                    'harga_consumable'         => $row['G'],
                ]);
            }

            return redirect()->back()->with('success', 'Data Success Imported');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('delete', 'An error occurred, please try again.: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['sub_title']      = 'Consumables';
        $data['title']          = 'Consumable Detail Page';
        $data['data_project']   = Project::all();
        $data['find_id']        = Consumables::findOrFail($id);
        $data['data_all']       = Consumables::all();
        return view('consumables.show', $data);
    }

    public function edit($id)
    {
        $data['sub_title']      = 'Consumables';
        $data['title']          = 'Consumable Edit Page';
        $data['data_project']   = Project::all();
        $data['find_id']        = Consumables::findOrFail($id);
        $data['data_all']       = Consumables::all();
        return view('consumables.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_consumable'           => 'required|min:5|max:255',
            'spesifikasi_consumable'    => 'required|min:5|max:255',
            'jenis_quantity'            => 'required|min:1|max:255',
            'quantity'                  => 'required|min:1|max:100',
            'jenis_consumable'          => 'min:5|max:255',
            'quantity'                  => 'required|min:1|max:100',
            'project_id'                => 'nullable',
        ]);
        $updateConsumable = Consumables::findOrFail($id);
        $updateConsumable->nama_consumable              = $request->nama_consumable;
        $updateConsumable->spesifikasi_consumable       = $request->spesifikasi_consumable;
        $updateConsumable->jenis_quantity               = $request->jenis_quantity;
        $updateConsumable->quantity                     = $request->quantity;
        $updateConsumable->jenis_consumable             = $request->jenis_consumable;
        $updateConsumable->harga_consumable             = $request->harga_consumable;
        $updateConsumable->project_id                   = $request->project_id;
        $updateConsumable->save();
        return redirect()->route('consumable.index')->with('editSuccess', 'Data Has Been Updated!');
    }

    public function exportPage()
    {
        $data['title']          = 'Export PDF Consumable';
        $data['sub_title']      = 'Consumables';
        $data['projects']       = Project::all();
        return view('consumables.filter-export-consumable', $data);
    }

    public function exportDownload(Request $request)
    {
        $query = Consumables::with('project');

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $data['consumable'] = $query->get();
        $pdf = Pdf::loadView('consumables.dashboard-export-consumable', $data);
        return $pdf->download('consumable-' . now()->format('d-m-Y') . '.pdf');
    }
    public function destroy(Consumables $consumables) {}
}

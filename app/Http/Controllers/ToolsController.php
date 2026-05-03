<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ToolsController extends Controller
{
    public function index()
    {
        $data['sub_title']      = 'Tools';
        $data['title']          = 'Tools Page';
        $data['data_tools']     = Tools::paginate(5);
        return view('tools_production.index', $data);
    }
    public function multiple_create()
    {
        $data['sub_title']      = 'Tools';
        $data['title']          = 'Tools Multiple Page';
        $data['data_tools']     = Tools::all();
        return view('tools_production.create-multiple-data', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'             => 'required|min:5|max:255',
            'spesifikasi_alat'      => 'required|min:5|max:255',
            'jenis_alat'            => 'required|min:1|max:255',
            'tipe_alat'             => 'required|min:1|max:100',
            'quantity'              => 'required|min:1|max:255',
            'jenis_quantity'        => 'required',
        ]);
        try {
            Tools::create([
                'nama_alat'         => $request->nama_alat,
                'spesifikasi_alat'  => $request->spesifikasi_alat,
                'jenis_alat'        => $request->jenis_alat,
                'tipe_alat'         => $request->tipe_alat,
                'quantity'          => $request->quantity,
                'jenis_quantity'    => $request->jenis_quantity,
            ]);
            return redirect()->route('tools.index')->with('success', 'Data added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data!');
        }
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
                if (empty($item['nama_alat']) || empty($item['spesifikasi_alat']) || empty($item['jenis_alat']) || empty($item['tipe_alat']) || empty($item['quantity']) || empty($item['jenis_quantity'])) {
                    return response()->json(
                        [
                            'message' => "Item index {$idx} Field Has Empty.",
                        ],
                        422,
                    );
                }

                $created[] = Tools::create([
                    'nama_alat'         => $item['nama_alat'],
                    'spesifikasi_alat'  => $item['spesifikasi_alat'],
                    'jenis_alat'        => $item['jenis_alat'],
                    'tipe_alat'         => $item['tipe_alat'],
                    'quantity'          => $item['quantity'],
                    'jenis_quantity'    => $item['jenis_quantity'],
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
    public function exportPage()
    {
        $data['title']      = 'Export PDF Material';
        $data['sub_title']  = 'Tools';
        return view('tools_production.filter-export-pdf-tools', $data);
    }
    public function exportDownload(Request $request)
    {
        $query = Tools::query();
        if ($request->filled('jenis_alat')) {
            $query->where('jenis_alat', $request->jenis_alat);
        }
        $data_tools = $query->get();
        if ($data_tools->isEmpty()) {
            return back()->with('error', 'No data found for that category Type Tools.');
        }

        $data['tools'] = $data_tools;
        $pdf = Pdf::loadView('tools_production.dashboard-export-tools', $data);
        return $pdf->download('tools-' . now()->format('d-m-Y') . '.pdf');
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

                Tools::create([
                    'kode_alat'         => $row['A'],
                    'nama_alat'         => $row['B'],
                    'spesifikasi_alat'  => $row['C'],
                    'jenis_alat'        => $row['D'],
                    'tipe_alat'         => $row['E'],
                    'quantity'          => $row['F'],
                    'jenis_quantity'    => $row['G'],
                ]);
            }
            return redirect()->back()->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('delete', 'There is an error: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $data['title']      = 'Show Tool Page';
        $data['sub_title']  = 'Tools';
        $data['find_id']    = Tools::findOrFail($id);
        return view('tools_production.show', $data);
    }
    public function edit($id)
    {
        $data['title']      = 'Edit Tool Page';
        $data['sub_title']  = 'Tools';
        $data['find_id']    = Tools::findOrFail($id);
        return view('tools_production.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alat'         => 'required|min:5|max:255',
            'spesifikasi_alat'  => 'required|min:5|max:255',
            'jenis_alat'        => 'required|min:1|max:255',
            'tipe_alat'         => 'required|min:1|max:100',
            'quantity'          => 'required|min:1|max:255',
            'jenis_quantity'    => 'required',
        ]);
        $updateTools = Tools::findOrFail($id);
        $updateTools->nama_alat         = $request->nama_alat;
        $updateTools->spesifikasi_alat  = $request->spesifikasi_alat;
        $updateTools->jenis_alat        = $request->jenis_alat;
        $updateTools->tipe_alat         = $request->tipe_alat;
        $updateTools->quantity          = $request->quantity;
        $updateTools->jenis_quantity    = $request->jenis_quantity;
        $updateTools->save();
        return redirect()->route('tools.index')->with('editSuccess', 'Data Has Been Updated!');
    }

    public function destroy(Tools $tools) {}
}

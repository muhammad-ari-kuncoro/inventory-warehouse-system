<?php

namespace App\Http\Controllers;

use App\Models\Machines;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    public function index()
    {
        $data['title']                = 'Machines Page';
        $data['sub_title']            = 'Machine';
        $data['data_machine_asset']   = Machines::paginate(10);
        return view('machines.index', $data);
    }

    public function create_multiple()
    {
        $data['title']            = 'Create Machine Multiple Page';
        $data['sub_title']        = 'Machine';
        $data['data_machine_pag'] = Machines::all();
        return view('machines.create-multiple-data', $data);
    }
    public function store_multiple(Request $request)
    {
        try {
            $data = $request->input('data');
            if (!$data || !is_array($data) || count($data) === 0) {
                return response()->json(['message' => 'Empty Data, Nothing to save!'], 422);
            }

            $created = [];
            foreach ($data as $idx => $item) {
                if (empty($item['nama_mesin']) || empty($item['spesifikasi_mesin']) || empty($item['jenis_quantity']) || empty($item['quantity']) || empty($item['jenis_mesin'])) {
                    return response()->json(
                        [
                            'message' => "Item index {$idx} Field Has Empty.",
                        ],
                        422,
                    );
                }

                $created[] = Machines::create([
                    'nama_mesin'        => $item['nama_mesin'],
                    'spesifikasi_mesin' => $item['spesifikasi_mesin'],
                    'jenis_quantity'    => $item['jenis_quantity'],
                    'quantity'          => $item['quantity'],
                    'jenis_mesin'       => $item['jenis_mesin'],
                    'harga_mesin'       => $item['harga_mesin'],
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
            'nama_mesin'            => 'required|min:3|max:255',
            'spesifikasi_mesin'     => 'required|min:3|max:255',
            'jenis_mesin'           => 'required|min:1|max:255',
            'quantity'              => 'required|min:1|max:100',
            'jenis_quantity'        => 'required|min:1|max:255',
            'harga_mesin'           => 'required|min:1|max:255',
        ]);
        try {
            Machines::create([
                'nama_mesin'        => $request->nama_mesin,
                'spesifikasi_mesin' => $request->spesifikasi_mesin,
                'jenis_mesin'       => $request->jenis_mesin,
                'quantity'          => $request->quantity,
                'jenis_quantity'    => $request->jenis_quantity,
                'harga_mesin'       => $request->harga_mesin,
            ]);
            return redirect()->route('machine.index')->with('success', 'Data Successfully Added!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data!');
        }
    }

    public function show($id)
    {
        $data['sub_title']      = 'Machine';
        $data['title']          = 'Machine Show Page';
        $data['find_id']        = Machines::findOrFail($id);
        return view('machines.show',$data);
    }

    public function edit($id)
    {
        $data['sub_title']      = 'Machine';
        $data['title']          = 'Menu Edit Page';
        $data['find_id']        = Machines::findOrFail($id);
        return view('machines.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mesin'            => 'required|min:3|max:255',
            'spesifikasi_mesin'     => 'required|min:3|max:255',
            'jenis_mesin'           => 'required|min:1|max:255',
            'quantity'              => 'required|min:1|max:100',
            'jenis_quantity'        => 'required|min:1|max:255',
            'harga_mesin'           => 'required|min:1|max:255',
        ]);

        $updateMachines = Machines::findOrFail($id);
        $updateMachines->nama_mesin             = $request->nama_mesin;
        $updateMachines->spesifikasi_mesin      = $request->spesifikasi_mesin;
        $updateMachines->jenis_mesin            = $request->jenis_mesin;
        $updateMachines->quantity               = $request->quantity;
        $updateMachines->jenis_quantity         = $request->jenis_quantity;
        $updateMachines->harga_mesin            = $request->harga_mesin;
        $updateMachines->save();
        return redirect()->route('machine.index')->with('editSuccess', 'Data Successfully Edited!');
    }

    public function destroy(Machines $machines)
    {

    }
    public function exportPage()
    {
        $data['title']      = 'Export PDF Machine';
        $data['sub_title']  = 'Machines';
        return view('machines.filter-export-pdf', $data);
    }
    public function exportDownload(Request $request)
    {
        $query = Machines::query();
        if ($request->filled('jenis_mesin')) {
            $query->where('jenis_mesin', $request->jenis_mesin);
        }
        $data_machine = $query->get();
        if ($data_machine->isEmpty()) {
            return back()->with('error', 'No data found for that category Type Machines.');
        }

        $data['machine'] = $data_machine;
        $pdf = Pdf::loadView('machines.dashboard-export', $data);
        return $pdf->download('machines-' . now()->format('d-m-Y') . '.pdf');
    }
}

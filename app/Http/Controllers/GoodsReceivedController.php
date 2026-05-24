<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Materials;
use App\Models\Consumables;
use Illuminate\Support\Str;
use App\Models\GoodReceived;
use Illuminate\Http\Request;

use App\Models\GoodReceivedDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Machines;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

class GoodsReceivedController extends Controller
{
    public function index()
    {
        $data['title']               = 'Good Received Page';
        $data['sub_title']           = 'Good Received';
        $data['data_delivery_order'] = GoodReceived::where('status', '!=', 'drafts')->get();
        $data['data_project']        = Project::get();
        return view('good_recevied.index', $data);
    }

    public function create()
    {
        $data['title']          = 'New Good Received Page';
        $data['sub_title']      = 'Good Received';
        $data['consumables']    = Consumables::all();
        $data['machines']       = Machines::all();
        $data['materials']      = Materials::all();
        $data['data_project']   = Project::get();
        $data['do_draft']       = GoodReceived::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
        return view('good_recevied.create', $data);
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'jenis_barang'      => 'required',
            'consumable_id'     => 'nullable',
            'material_id'       => 'nullable',
            'machine_id'        => 'nullable',
            'quantity'          => 'required|min:1',
            'quantity_jenis'    => 'required',
            'keterangan_barang' => 'nullable',
        ]);

        Log::info('Validation passed:', $validated);

        DB::beginTransaction();
        try {
            $do_draft = GoodReceived::firstOrCreate(['user_id' => Auth::user()->id, 'status' => 'draft'], ['user_id' => Auth::user()->id]);
            $existingItem = GoodReceivedDetail::where('good_received_id', $do_draft->id)
                ->where('jenis_barang', $request->jenis_barang)
                ->where(function ($query) use ($request) {
                    $query->where('consumable_id', $request->consumable_id)->whereNotNull('consumable_id')->orWhere('material_id', $request->material_id)->whereNotNull('material_id')->orWhere('machine_id', $request->machine_id)->whereNotNull('machine_id');
                })
                ->first();

            if ($existingItem) {
                return redirect()->back()->with('failed', 'This item name already exists. Please use the available data..');
            }
            $doDraftDetail  = new GoodReceivedDetail();
            $doDraftDetail->good_received_id        = $do_draft->id;
            $doDraftDetail->jenis_barang            = $request->jenis_barang;
            $doDraftDetail->consumable_id           = $request->consumable_id ?: null;
            $doDraftDetail->material_id             = $request->material_id ?: null;
            $doDraftDetail->machine_id              = $request->machine_id ?: null;
            $doDraftDetail->quantity                = $request->quantity;
            $doDraftDetail->quantity_jenis          = $request->quantity_jenis;
            $doDraftDetail->keterangan_barang       = $request->keterangan_barang;
            $doDraftDetail->save();
            DB::commit();
            return redirect()->route('good-received.create')->with('success', 'Item Successfully Added !');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
    public function storeItemUpdate(Request $request, int $id)
    {
        $validated = $request->validate([
            'jenis_barang'      => 'required',
            'consumable_id'     => 'nullable',
            'material_id'       => 'nullable',
            'machine_id'        => 'nullable',
            'quantity'          => 'required|min:1',
            'quantity_jenis'    => 'required',
            'keterangan_barang' => 'nullable',
        ]);

        Log::info('Validation passed:', $validated);
        DB::beginTransaction();
        try {
            $goodReceive = GoodReceived::findOrFail($id);
            $existingItem = GoodReceivedDetail::where('good_received_id', $goodReceive->id)->where('jenis_barang', $request->jenis_barang)->where(function ($query) use ($request) {
                    $query->where('consumable_id', $request->consumable_id)->whereNotNull('consumable_id')->orWhere('material_id', $request->material_id)->whereNotNull('material_id')->orWhere('machine_id', $request->machine_id)->whereNotNull('machine_id');
                })->first();
            if ($existingItem) {
                return redirect()->back()->with('failed', 'This item name already exists. Please use the available data.');
            }

            $doDraftDetail = new GoodReceivedDetail();
            $doDraftDetail->good_received_id        = $goodReceive->id;
            $doDraftDetail->jenis_barang            = $request->jenis_barang;
            $doDraftDetail->consumable_id           = $request->consumable_id ?: null;
            $doDraftDetail->material_id             = $request->material_id ?: null;
            $doDraftDetail->machine_id              = $request->machine_id ?: null;
            $doDraftDetail->quantity                = $request->quantity;
            $doDraftDetail->quantity_jenis          = $request->quantity_jenis;
            $doDraftDetail->keterangan_barang       = $request->keterangan_barang;
            $doDraftDetail->save();
            DB::commit();
            return redirect()->route('good-received.edit', $goodReceive->id)->with('success', 'Item Successfully Edited!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_masuk'     => 'required|min:1|max:255',
            'nama_supplier'     => 'required|min:1|max:255',
            'kode_surat_jalan'  => 'required|min:1|max:100',
            'project_id'        => 'nullable',
        ]);
        try {
            $doDraft = GoodReceived::where('user_id', Auth::user()->id)->where('status', 'draft')->first();
            if (!$doDraft) {
                return redirect()->back()->with('error', 'Please Enter The Items!');
            }

            $doDraft->status           = 'received';
            $doDraft->tanggal_masuk    = $request->tanggal_masuk;
            $doDraft->project_id       = $request->project_id;
            $doDraft->nama_supplier    = $request->nama_supplier;
            $doDraft->kode_surat_jalan = $request->kode_surat_jalan;
            $doDraft->project_id       = $request->project_id;

            $doDraft->save();
            return redirect()->route('good-received.index')->with('success', 'Data Successfully Add!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'An error occurred while saving data!');
        }
    }

    public function destroyDetail(int $id)
    {
        DB::beginTransaction();
        try {
            $detail = GoodReceivedDetail::findOrFail($id);

            if ($detail->material_id) {
                $material = Materials::findOrFail($detail->material_id);
                $material->quantity -= $detail->quantity;
                $material->save();
            } elseif ($detail->consumable_id) {
                $consumable = Consumables::findOrFail($detail->consumable_id);
                $consumable->quantity -= $detail->quantity;
                $consumable->save();
            } elseif ($detail->machine_id) {
                $machine = Machines::findOrFail($detail->machine_id);
                $machine->quantity -= $detail->quantity;
                $machine->save();
            }
            $detail->delete();
            DB::commit();
            return redirect()->route('good-received.create')->with('warning', 'Item Successfully Add!');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An Error Occurred While Deteled Item: ' . $e->getMessage()]);
        }
    }

    public function show(int $id)
    {
        $data['title']        = 'Show / Details Good Received';
        $data['sub_title']    = 'Good Received';
        $data['data_project'] = Project::all();
        $data['consumables']  = Consumables::all();
        $data['machines']     = Machines::all();
        $data['materials']    = Materials::all();
        $data['gr']           = GoodReceived::findOrFail($id);
        return view('good_recevied.show', $data);
    }

    public function edit(int $id)
    {
        $data['title']          = 'Edit Good Received';
        $data['sub_title']      = 'Good Received';
        $data['consumables']    = Consumables::all();
        $data['machines']       = Machines::all();
        $data['materials']      = Materials::all();
        $data['data_project']   = Project::all();
        $data['gr']             = GoodReceived::findOrFail($id);

        return view('good_recevied.edit', $data);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'tanggal_masuk'     => 'required|min:1|max:255',
            'nama_supplier'     => 'required|min:1|max:255',
            'kode_surat_jalan'  => 'required|min:1|max:100',
            'project_id'        => 'required',
        ]);

        $updateGoodReceived = GoodReceived::findOrFail($id);
        $updateGoodReceived->tanggal_masuk      = $request->tanggal_masuk;
        $updateGoodReceived->nama_supplier      = $request->nama_supplier;
        $updateGoodReceived->kode_surat_jalan   = $request->kode_surat_jalan;
        $updateGoodReceived->project_id         = $request->project_id;
        $updateGoodReceived->status             = 'received';
        $updateGoodReceived->save();

        return redirect()->route('good-received.index')->with('editSuccess', 'Data successfully Edited!');
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $goodReceive = GoodReceived::find($id);
            if ($goodReceive) {
                foreach ($goodReceive->details as $detail) {
                    if ($detail->consumable_id) {
                        $item = Consumables::find($detail->consumable_id);
                        if ($item) {
                            $item->quantity -= $detail->quantity;
                            $item->save();
                        }
                    } elseif ($detail->material_id) {
                        $item = Materials::find($detail->material_id);
                        if ($item) {
                            $item->quantity -= $detail->quantity;
                            $item->save();
                        }
                    } elseif ($detail->machine_id) {
                        $item = Machines::find($detail->machine_id);
                        if ($item) {
                            $item->quantity -= $detail->quantity;
                            $item->save();
                        }
                    }
                }
                $goodReceive->delete();
                DB::commit();
                return redirect()->back()->with('delete', 'Data was successfully deleted and item quantity has been updated.');
            }
            DB::rollBack();
            return redirect()->back()->with('delete', 'Data Not Found');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('delete', 'An Error Occurred: ' . $e->getMessage());
        }
    }

    public function deleteDraft()
    {
        try {
            $doDraft = GoodReceived::where('user_id', Auth::user()->id)
                ->where('status', 'draft')
                ->first();

            if ($doDraft) {
                $details = GoodReceivedDetail::where('good_received_id', $doDraft->id)->get();

                foreach ($details as $detail) {
                    if ($detail->material_id) {
                        $material = Materials::find($detail->material_id);
                        if ($material) {
                            $material->decrement('quantity', $detail->quantity);
                        }
                    }
                    if ($detail->consumable_id) {
                        $consumable = Consumables::find($detail->consumable_id);
                        if ($consumable) {
                            $consumable->decrement('quantity', $detail->quantity);
                        }
                    }
                    if ($detail->machine_id) {
                        $machine = Machines::find($detail->machine_id);
                        if ($machine) {
                            $machine->decrement('quantity', $detail->quantity);
                        }
                    }
                }
                GoodReceivedDetail::where('good_received_id', $doDraft->id)->delete();
                $doDraft->delete();
            }
            return redirect()->back()->with('success', 'Draft and stock successfully deleted.');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'An Error Occurred: ' . $th->getMessage());
        }
    }
    public function exportPage()
    {
        $data['title']     = 'Export PDF Goods Received';
        $data['sub_title'] = 'Good Received';
        $data['projects']  = Project::all();

        return view('good_recevied.filter-export-pdf-good-received', $data);
    }
    public function exportDownload(Request $request)
    {
            $query = GoodReceived::query();

            if ($request->filled('project_id')) {
                $query->where('project_id', $request->project_id);
                }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
                }

            $goodsReceived = $query->get();

            $reportItems = [];

            foreach ($goodsReceived as $received) {

                $details = DB::table('good_received_detail')->where('good_received_id', $received->id)->get();

                foreach ($details as $detail) {

                $namaBarang     = '-';
                $materialId     = $detail->material_id ?? $detail->id_material ?? null;
                $consumableId   = $detail->consumable_id ?? $detail->id_consumable ?? null;
                $machineId      = $detail->machine_id ?? $detail->id_machine ?? null;

            $jenis = strtolower(trim($detail->jenis_barang ?? ''));

            if  (($jenis == 'material' || $jenis == 'materials') && $materialId) {
                    $barang = DB::table('materials')->where('id', $materialId)->first();
                    $namaBarang = $barang->nama_material ?? $barang->nama ?? '-';
                }
                elseif (($jenis == 'consumable' || $jenis == 'consumables') && $consumableId) {
                        $barang = DB::table('consumables')->where('id', $consumableId)->first();
                        $namaBarang = $barang->nama_consumable ?? $barang->nama ?? '-';
                }
                elseif (($jenis == 'machine' || $jenis == 'machines') && $machineId) {
                        $barang = DB::table('machine_assets')->where('id', $machineId)->first();
                        $namaBarang = $barang->nama_mesin ?? $barang->nama ?? '-';
                }

            $namaProject = '-';
            if ($received->project_id) {
                $project = DB::table('menu_project')->where('id', $received->project_id)->first();
                $namaProject = $project->nama_project ?? $project->nama ?? '-';
            }

            $reportItems[] = (object) [
                'tanggal_masuk'     => $received->tanggal_masuk,
                'kode_surat_jalan'  => $received->kode_surat_jalan,
                'nama_supplier'     => $received->nama_supplier,
                'nama_barang'       => $namaBarang,
                'jenis_barang'      => $detail->jenis_barang,
                'quantity'          => $detail->quantity,
                'quantity_jenis'    => $detail->quantity_jenis,
                'nama_project'      => $namaProject,
                'status'            => $received->status,
            ];
        }
    }
        $data['reportItems'] = $reportItems;
        $pdf = Pdf::loadView('good_recevied.dashboard-export-good-received', $data);
        return $pdf->download('goods-received-' . now()->format('d-m-Y') . '.pdf');
    }
    public function printSinglePdfGR($id)
    {
        $gr = GoodReceived::with([
        'project',
        'details.material',
        'details.consumable',
        'details.machine',
    ])->where('status', 'received')->findOrFail($id);

        $titleDoc = "GOODS RECEIVED";
    //   dd($gr->details->toArray());
        $pdf = Pdf::loadView('good_recevied.dashboard-single-pdf-good-received', compact('gr', 'titleDoc'))->setPaper('a4', 'portrait');

        return $pdf->stream('GR-' . $gr->id . '-' . now()->format('Ymd') . '.pdf');
    }
}

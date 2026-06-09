<?php

namespace App\Http\Controllers;

use App\Models\ConsumableIssuance;
use App\Http\Controllers\Controller;
use App\Models\ConsumableIssuanceDetail;
use App\Models\Consumables;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsumableIssuanceController extends Controller
{
    public function index()
    {
        $canCreate = true;

        $currentHour = Carbon::now('Asia/Jakarta')->hour;
        if ($currentHour >= 17 || $currentHour < 8) {
            $canCreate = false;
        }

        $lastSubmission = ConsumableIssuance::where('user_id', Auth::id())->where('status', 'submitted')->latest()->first();
        if ($lastSubmission && $canCreate) {
            $nextAllowedTime = Carbon::parse($lastSubmission->submitted_at)->addDay()->setTime(8, 0, 0);
            if (Carbon::now('Asia/Jakarta')->lt($nextAllowedTime)) {
                $canCreate = false;
            }
        }

        $data['canCreate'] = $canCreate;
        $data['title'] = 'Formulir Pengambilan Consumable';
        $data['sub_title'] = 'Pengambilan Consumable';

        if (Auth::user()->role == 'Administrator') {
            $data['datas'] = ConsumableIssuance::with(['user', 'details'])
                ->latest()
                ->get();
        } else {
            $data['datas'] = ConsumableIssuance::with(['user', 'details'])
                ->where('user_id', Auth::user()->id)
                ->latest()
                ->get();
        }

        return view('consumable_issuance.index', $data);
    }

    public function create()
    {
        $currentHour = Carbon::now('Asia/Jakarta')->hour;
        if ($currentHour >= 17 || $currentHour < 8) {
            return redirect()->route('consumable-issuance.index')->with('delete', 'Sistem Ditutup! Pengambilan consumable hanya bisa dilakukan jam 08:00 s/d 17:00.');
        }

        $today = Carbon::today()->toDateString();
        $existingDraft = ConsumableIssuance::where('user_id', Auth::user()->id)
            ->where('status', 'draft')
            ->whereDate('created_at', $today)
            ->first();

        if ($existingDraft) {
            return redirect()->route('consumable-issuance.edit', $existingDraft->id);
        }

        $header = ConsumableIssuance::create([
            'user_id' => Auth::user()->id,
            'kd_consumable_out' => $this->generateKode(),
            'transaction_date_out' => $today,
            'status' => 'draft',
            'submitted' => 'no',
        ]);

        return redirect()->route('consumable-issuance.edit', $header->id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengambilan' => 'required',
            'consumable_id' => 'required|exists:consumables,id',
            'project_id' => 'required|exists:menu_project,id',
            'quantity' => 'required|numeric|min:1',
            'jenis_quantity' => 'required',
            'keterangan_consumable' => 'required',
        ]);
        try {
            ConsumableIssuance::create([
                'tanggal_pengambilan' => $request->tanggal_pengambilan,
                'user_id' => Auth::user()->id,
                'consumable_id' => $request->consumable_id,
                'project_id' => $request->project_id,
                'quantity' => $request->quantity,
                'jenis_quantity' => $request->jenis_quantity,
                'keterangan_consumable' => $request->keterangan_consumable,
            ]);
            return redirect()->route('consumable-issuance.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $header = ConsumableIssuance::with(['details.consumable', 'user'])->findOrFail($id);

        if ($header->user_id !== Auth::user()->id && Auth::user()->role !== 'Administrator') {
            abort(403);
        }

        if ($header->status == 'submitted') {
            return redirect()->route('consumable-issuance.show', $id)->with('editSuccess', 'Transaksi ini sudah submitted, tidak dapat diedit.');
        }

        $data['title'] = 'Form Pengambilan Consumable';
        $data['sub_title'] = 'Pengambilan Consumable';
        $data['header'] = $header;
        $data['consumables'] = Consumables::orderBy('nama_consumable')->get();

        return view('consumable_issuance.create', $data);
    }

    public function addItem(Request $request, $headerId)
    {
        $request->validate([
            'consumable_id'     => 'required|exists:consumables,id',
            'quantity'          => 'required|integer|min:1',
            'type_quantity'     => 'required|string|max:50',
            'description'       => 'nullable|string|max:255',
        ]);

        $header = ConsumableIssuance::findOrFail($headerId);

        if ($header->status == 'submitted') {
            return back()->with('delete', 'Gagal! Transaksi ini sudah ditutup/submitted.');
        }

        if ($header->created_at->format('Y-m-d') !== Carbon::today()->toDateString()) {
            return back()->with('delete', 'Gagal! Anda tidak bisa menambah item pada dokumen hari sebelumnya.');
        }

        $consumable = Consumables::findOrFail($request->consumable_id)->fresh();
        $stokAktif = (int)$consumable->quantity;
        $qtyDiminta = (int)$request->quantity;

        $totalDiBookingDraftLain = ConsumableIssuanceDetail::where('consumable_id', $request->consumable_id)->where('header_id', '!=', $headerId)->whereHas('header', function($query) {
            $query->where('status', 'draft');
            })->sum('quantity');

        $sisaStokAman = $stokAktif - $totalDiBookingDraftLain;

        $existingDetailQty = ConsumableIssuanceDetail::where('header_id', $headerId)->where('consumable_id', $request->consumable_id)->sum('quantity');

        $totalQtyDiminta = $qtyDiminta + $existingDetailQty;

        if ($stokAktif <= 0 || $sisaStokAman <= 0) {
            return back()->with('delete', "Gagal! Stok untuk {$consumable->nama_consumable} sudah habis atau sedang di-booking penuh oleh user lain.");
        }

        if ($sisaStokAman < $totalQtyDiminta) {
            return back()->with('delete', "Gagal! Stok tidak mencukupi karena sebagian sedang di-booking user lain. Sisa stok fisik: {$stokAktif}. Stok aman yang bisa diambil: {$sisaStokAman}. Anda meminta: {$totalQtyDiminta}.");
        }

            $existingDetail = ConsumableIssuanceDetail::where('header_id', $headerId)->where('consumable_id', $request->consumable_id)->first();

        if ($existingDetail) {
            $existingDetail->update([
            'quantity'      => $totalQtyDiminta,
            'description'   => $request->description ?? $existingDetail->description
        ]);
        }else{
            ConsumableIssuanceDetail::create([
                'header_id'         => $headerId,
                'consumable_id'     => $request->consumable_id,
                'quantity'          => $qtyDiminta,
                'type_quantity'     => $request->type_quantity,
                'description'       => $request->description ?? '-',
            ]);
        }
            return back()->with('success', 'Item berhasil ditambahkan.');
    }

    public function removeItem($detailId)
    {
        $detail = ConsumableIssuanceDetail::with('header')->findOrFail($detailId);
        $header = $detail->header;
        if ($header->status == 'submitted' || $header->created_at->format('Y-m-d') !== Carbon::today()->toDateString()) {
            return back()->with('delete', 'Gagal! Item tidak dapat dihapus karena transaksi sudah ditutup.');
        }
        $headerId = $detail->header_id;
        $detail->delete();
        return redirect()->route('consumable-issuance.edit', $headerId)->with('success', 'Item berhasil dihapus.');
    }
    public function submit($id)
    {
        $header = ConsumableIssuance::with('details.consumable')->findOrFail($id);

        if ($header->details->isEmpty()) {
            return back()->with('delete', 'Tidak bisa submit, belum ada item.');
        }
        if ($header->status == 'submitted') {
            return back()->with('delete', 'Transaksi ini sudah disubmit sebelumnya.');
        }

        DB::beginTransaction();
        try {
            foreach ($header->details as $detail) {
                    $consumable = $detail->consumable;

                if ($consumable->quantity < $detail->quantity) {
                    DB::rollBack();
                    return back()->with('delete', "Stok untuk {$consumable->nama_consumable} tidak mencukupi! Sisa stok: {$consumable->quantity}");
                }

            $consumable->decrement('stok', $detail->quantity);
        }

            $header->update([
                'status'    => 'submitted',
                'submitted' => Carbon::now()->toDateTimeString(),
        ]);

        DB::commit();
        return redirect()->route('consumable-issuance.index')->with('success', 'Transaksi berhasil disubmit dan stok telah dikurangi.');

        }catch(\Exception $e) {
            DB::rollBack();
            return back()->with('delete', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $header             = ConsumableIssuance::with(['details.consumable', 'user'])->findOrFail($id);
        $data['title']      = 'Detail Consumable Out';
        $data['sub_title']  = 'Pengambilan Consumable';
        $data['find_id']     = $header;

        return view('consumable_issuance.show', $data);
    }

    public function autoSubmit()
    {
            $drafts = ConsumableIssuance::with('details.consumable')->where('status', 'draft')->whereDate('created_at', Carbon::today()->toDateString())->get();

        foreach ($drafts as $draft) {
            if ($draft->details->isEmpty()) {
                continue;
            }

            DB::beginTransaction();
            try {
                $canSubmit = true;

            foreach ($draft->details as $detail) {
                $consumable = Consumables::where('id', $detail->consumable_id)->lockForUpdate()->first();
                if (!$consumable || (int)$consumable->quantity < (int)$detail->quantity) {
                    $canSubmit = false;
                    break;
                }
            }
            if ($canSubmit) {
                foreach ($draft->details as $detail) {
                    Consumables::where('id', $detail->consumable_id)->decrement('quantity', $detail->quantity);
                }
                $draft->update([
                    'status' => 'submitted',
                    'submitted' => Carbon::now()->toDateTimeString(),
                ]);
                DB::commit();
            }else{
                DB::rollBack();
            }

            }catch(\Exception $e) {
                DB::rollBack();
            }
        }
    }

    private function generateKode()
    {
        $prefix = 'CO';
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $random = strtoupper(substr(uniqid(), -5));

        return "{$prefix}/{$year}/{$month}/{$random}";
    }
}

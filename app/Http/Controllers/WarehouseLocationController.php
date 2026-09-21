<?php

namespace App\Http\Controllers;

use App\Models\WarehouseLocation;
use Illuminate\Http\Request;

class WarehouseLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title']          = 'Warehouse Page';
        $data['sub_title']      = 'Warehouses';
        $data['warehouse_location']   = WarehouseLocation::paginate(5);
        return view('warehouse_location.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|min:3|max:255',
            'type'      => 'required|in:raw_material,wip,finished_goods',
            'address'   => 'required|string|max:255',
            'pic'       => 'required|string|min:3|max:255',
            'is_active' => 'required|in:0,1,true,false',
        ]);

        try {
            WarehouseLocation::create([
                'name'                  => $request->name,
                'type'                  => $request->type,
                'address'               => $request->address,
                'pic'                   => $request->pic,
                'is_active'             => $request->is_active,
            ]);
            return redirect()->route('warehouses.index')->with('success', 'Data added succesfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['sub_title']      = 'Warehouse Page';
        $data['title']          = 'Detail Warehouse Page';
        $data['show_id']        = WarehouseLocation::findOrFail($id);
        return view('warehouse_location.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['sub_title']      = 'Warehouse Page';
        $data['title']          = 'Edit Warehouse Page';
        $data['find_id']        = WarehouseLocation::findOrFail($id);
        return view('warehouse_location.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|min:3|max:255',
            'type'      => 'required|in:raw_material,wip,finished_goods',
            'address'   => 'required|string|max:255',
            'pic'       => 'required|string|min:3|max:255',
            'is_active' => 'required|in:0,1,true,false',
        ]);
        $warehouse                          = WarehouseLocation::findOrFail($id);
        $warehouse->name                    = $request->name;
        $warehouse->type                    = $request->type;
        $warehouse->address                 = $request->address;
        $warehouse->pic                     = $request->pic;
        $warehouse->is_active               = $request->is_active;
        $warehouse->save();
        return redirect()->route('warehouses.index')->with('editSuccess', 'Data updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            WarehouseLocation::findOrFail($id)->delete();
            return redirect()->back()->with('delete', 'Project deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'An error occurred while saving data!');
        }
    }
}

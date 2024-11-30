<?php

namespace App\Http\Controllers;

use App\Models\Machines;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Machine';
        $data['title'] = 'Menu Machine Halaman';
        return view('machines.index',$data);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Machines $machines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machines $machines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Machines $machines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Machines $machines)
    {
        //
    }
}

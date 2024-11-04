<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Tools';
        $data['title'] = 'Menu Tools Halaman';
        return view('Tools.index',$data);

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
    public function show(Tools $tools)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tools $tools)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tools $tools)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tools $tools)
    {
        //
    }
}

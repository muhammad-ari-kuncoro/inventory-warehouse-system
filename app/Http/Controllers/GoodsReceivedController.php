<?php

namespace App\Http\Controllers;

use App\Models\GoodReceived;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodsReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['title'] = 'Menu Barang Masuk';
        $data['sub_title'] = 'Barang Masuk';
        return view('good_recevied.index',$data);

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
    public function show(GoodReceived $goodReceive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodReceived $goodReceive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GoodReceived $goodReceive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoodReceived $goodReceive)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consumables;
use App\Models\Materials;
use App\Models\Tools;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data['sub_title'] = 'Dashboard';
        $data['title'] = 'Dashboard Halaman';
        $data['materialQty'] = Materials::sum('quantity');
        $data['consumableQty'] = Consumables::sum('quantity');
        $data['toolsQty'] = Tools::sum('quantity');
        return view('dashboard.index',$data);
    }

    public function viewProfile()
    {
        $data['sub_title'] = 'View Profile Account';
        $data['title'] = 'Dashboard Halaman';
        return view('dashboard.index',$data);
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');


    }
}

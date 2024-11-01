<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Login Page AJM Warehouses';
        return view('auth.login',$data);
    }

    public function authentication(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|min:5|max:20'
        ]);
        if (Auth::attempt($validateData)) {

            session()->regenerate();
            return redirect()->intended('dashboard');


        }
        return back()->with('loginError','Login Failed');
    }


}

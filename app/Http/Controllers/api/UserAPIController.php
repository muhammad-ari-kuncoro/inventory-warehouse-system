<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAPIController extends Controller
{
    public function login(Request $request)
    {
          // Validasi request
    $validateData = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:5|max:20'
    ]);

    if (Auth::attempt($validateData)) {
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    return response()->json([
        'success' => false,
        'message' => 'Login gagal, email atau password salah!'
    ], 401);
    }

    public function logout(Request $request)
    {
        // Hanya hapus token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function crud()
    {
        try {
            return response()->json([
                'message' => 'Berhasil'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}

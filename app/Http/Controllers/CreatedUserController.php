<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CreatedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $data['title'] = 'Menu Halaman User Halaman';
        $data['sub_title'] = 'Menu User Poduksi';
        $data['data_user'] =  User::where('role', 'produksi')->get();
        return view('user_data.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Validasi
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'username' => 'required|min:3|max:255',
        'email' => 'required|email|min:3|max:255',
        'password' => 'required|min:6|max:255',
        'role' => 'required|min:2|max:255',
        'posisi' => 'required|min:2|max:255',
    ]);

    // dd($request->all()); // Bisa dipakai buat debug data yang dikirim

    try {
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'posisi' => $request->posisi,
        ]);

        return redirect()->route('userData.index')->with('success', 'Data berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_user = User::where('role', 'produksi')->where('id', $id)->first();

        if (!$data_user) {
            // Redirect ke halaman lain atau tampilkan error
            return redirect()->route('dashboard')->with('error', 'User tidak ditemukan.');
        }

        return view('user_data.show', [
            'title' => 'Menu Halaman User Halaman',
            'sub_title' => 'Menu User Produksi',
            'data_user' => $data_user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }
            $filename =  $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('user_images', $filename, 'public');
            $user->image = $filename;


        }

        $user->save();

        return redirect()->back()->with('success', 'Gambar berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

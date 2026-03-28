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
        $data['sub_title'] = 'Created Users';
        $data['data_user'] = User::whereIn('role', ['produksi','warehouse_staff'])->get();
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

        try {
            User::create([
                'username'  => $request->username,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'posisi'    => $request->posisi,
                'role'      => $request->role,
            ]);

            return redirect()->route('userData.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    public function show($id)
    {
        $data_user = User::whereIn('role',['produksi','warehouse_staff'])->where('id', $id)->first();

        if (!$data_user) {
            // Redirect ke halaman lain atau tampilkan error
            return redirect()->route('dashboard')->with('error', 'User tidak ditemukan.');
        }

        $data['title'] = 'Menu Halaman User Halaman';
        $data['sub_title'] = 'Created Users';
        $data['data_user'] = $data_user;

        return view('user_data.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['title'] = 'Halaman Edit User';
        $data['sub_title'] = 'Created Users';
        $data['data_user'] = User::findOrFail($id);
        return view('user_data.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'username' => 'required|min:3|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required|in:admin,produksi,warehouse_staff',
                'posisi' => 'required|min:2|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = User::findOrFail($id);

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika bukan default
                if ($user->image && $user->image !== '1.png' && Storage::exists('public/user_images/' . $user->image)) {
                    Storage::delete('public/user_images/' . $user->image);
                }

                $filename = $request->file('image')->hashName(); // ✅ hindari konflik nama file
                $request->file('image')->storeAs('user_images', $filename, 'public');
                $user->image = $filename;
            }

            // ✅ update data ke $user yang sudah di-find, bukan findOrFail ulang
            $user->username     = $request->username;
            $user->email        = $request->email;
            $user->role         = $request->role;
            $user->posisi       = $request->posisi;
            $user->save();

            return redirect()->route('userData.index')->with('editSuccess', 'Data user berhasil diperbarui!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

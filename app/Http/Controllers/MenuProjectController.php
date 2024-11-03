<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class MenuProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
    // Ambil input pencarian
    $search = $request->input('search');

    // Cek apakah ada input pencarian
    if ($search) {
        // Jika ada, lakukan pencarian di beberapa kolom
        $menu_project = Project::where('nama_project', 'LIKE', '%' . $search . '%')
            ->orWhere('sub_nama_project', 'LIKE', '%' . $search . '%')
            ->orWhere('kategori_project', 'LIKE', '%' . $search . '%')
            ->orWhere('kode_project', 'LIKE', '%' . $search . '%')
            ->orWhere('no_jo_project', 'LIKE', '%' . $search . '%')
            ->paginate(5); // Sesuaikan jumlah data per halaman
    } else {
        // Jika tidak ada pencarian, tampilkan semua data
        $menu_project = Project::paginate(5);
    }

    return view('menu_project.index', [
        'menu_project' => $menu_project,
        'title' => 'Menu Project Halaman',
        'sub_title' => 'Menu Project',
        'search' => $search,
    ]);


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
        //Validasi
        $request->validate([


            'nama_project' => 'required|min:5|max:255',
            'sub_nama_project' => 'required|min:5|max:255',
            'kategori_project' => 'required|min:5|max:255',
            'no_jo_project' => 'required|min:5|max:255'
        ]);

        // Menangani Data
        try {
            Project::create([
                'nama_project' => $request->nama_project,
                'sub_nama_project' => $request->sub_nama_project,
                'kategori_project' => $request->kategori_project,
                'no_jo_project' => $request->no_jo_project,
            ]);
            return redirect()->route('project.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Simpan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Menu halaman';
        $data['sub_title'] = 'Menu Project';
        $data['find_id'] = Project::findOrFail($id);
        return view('menu_project.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //Validasi Update
        $this->validate($request, [
            'nama_project' => 'required|min:5|max:255',
            'sub_nama_project' => 'required|min:5|max:255',
            'kategori_project' => 'required|min:5|max:255',
            'no_jo_project' => 'required|min:5|max:255'
        ]);
        $updateProject = Project::findOrFail($id);
        $updateProject->nama_project = $request->nama_project;
        $updateProject->sub_nama_project = $request->sub_nama_project;
        $updateProject->kategori_project = $request->kategori_project;
        $updateProject->no_jo_project = $request->no_jo_project;
        $updateProject->save();
        // Redirect ke halaman yang diinginkan
        return redirect()->route('project.index')->with('editSuccess', 'Data berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}

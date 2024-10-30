<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class MenuProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['sub_title'] = 'Menu Project';
        $data['menu_project'] = Project::paginate(5);
        return view('menu_project.index',$data);

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

            // $this->validate($request, [
                'nama_project' => 'required|min:5|max:255',
                'sub_nama_project' => 'required|min:5|max:255',
                'kategori_project' => 'required|min:5|max:255',
                'no_jo_project' => 'required|min:5|max:255'
            ]);

            // Menangani Data
            try {
                //code...
                Project::create([
                    'nama_project' => $request->nama_project,
                    'sub_nama_project' => $request->sub_nama_project,
                    'kategori_project' => $request->kategori_project,
                    'no_jo_project' => $request->no_jo_project,
                ]);
                return redirect()->route('index.menu_project')->with('success', 'Data berhasil ditambahkan!');
            } catch (\Exception $e) {
                //throw $th;
                  //throw $th;
            // Simpan pesan error jika terjadi kesalahan
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data!');
            return redirect()->back();
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
        //
        //  $findIdGeneralIndustri = GeneralIndustri::findOrFail($id);
        // $data['find_id'] = Project::findOrFail($id);
        $data['sub_title'] = 'Menu Project';
        return view('menu_project.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}

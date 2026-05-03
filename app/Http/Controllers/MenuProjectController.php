<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class MenuProjectController extends Controller
{
    public function index()
    {
        $data['sub_title']      = 'Main Project';
        $data['title']          = 'Project Page';
        $data['menu_project']   = Project::all();
        return view('menu_project.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_project'          => 'required|min:5|max:255',
            'sub_nama_project'      => 'required|min:5|max:255',
            'kategori_project'      => 'required|min:5|max:255',
            'no_jo_project'         => 'required|min:5|max:255',
            'no_po_project'         => 'required|min:3|max:255',
            'start_date'            => 'required',
            'end_date'              => 'required',
        ]);

        try {
            Project::create([
                'nama_project'          => $request->nama_project,
                'sub_nama_project'      => $request->sub_nama_project,
                'kategori_project'      => $request->kategori_project,
                'no_jo_project'         => $request->no_jo_project,
                'no_po_project'         => $request->no_po_project,
                'start_date'            => $request->start_date,
                'end_date'              => $request->end_date,
            ]);
            return redirect()->route('project.index')->with('success', 'Data added succesfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving data!');
        }
    }

    public function show($id)
    {
        $data['sub_title']      = 'Main Project';
        $data['title']          = 'Details Project Page';
        $data['find_id']        = Project::findOrFail($id);
        return view('menu_project.detail', $data);
    }

    public function edit($id)
    {
        $data['sub_title']      = 'Main Project';
        $data['title']          = 'Edit Project Page';
        $data['find_id']        = Project::findOrFail($id);
        return view('menu_project.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_project'          => 'required|min:5|max:255',
            'sub_nama_project'      => 'required|min:5|max:255',
            'kategori_project'      => 'required|min:5|max:255',
            'no_jo_project'         => 'required|min:5|max:255',
            'no_po_project'         => 'required|min:5|max:255',
            'start_date'            => 'required',
            'end_date'              => 'required',
        ]);
        $updateProject                      = Project::findOrFail($id);
        $updateProject->nama_project        = $request->nama_project;
        $updateProject->sub_nama_project    = $request->sub_nama_project;
        $updateProject->kategori_project    = $request->kategori_project;
        $updateProject->no_jo_project       = $request->no_jo_project;
        $updateProject->no_po_project       = $request->no_po_project;
        $updateProject->start_date          = $request->start_date;
        $updateProject->end_date            = $request->end_date;
        $updateProject->save();
        return redirect()->route('project.index')->with('editSuccess', 'Data updated successfully!!');
    }

    public function destroy($id)
    {
        try {
            Project::findOrFail($id)->delete();
            return redirect()->back()->with('delete', 'Project deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'An error occurred while saving data!');
        }
    }
}

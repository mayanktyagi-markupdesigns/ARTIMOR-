<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialGroup;

class MaterialGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialGroup::orderBy('id', 'desc');
        $data['groups'] = $query->paginate(10)->withQueryString();
        return view('admin.material-group.index', $data);
    }

    public function create()
    {
        return view('admin.material-group.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_groups,name',
            'status' => 'required|in:0,1',
        ]);

        $material_group = new MaterialGroup();

        $material_group->name               = $request->name;       
        $material_group->status             = $request->status;
        $material_group->save();    
       
        return redirect()->route('admin.material.group.list')->with('success', 'Material group created successfully!');
    }

    public function edit($id)
    {
        $data['group'] = MaterialGroup::findOrFail($id);
        return view('admin.material-group.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $group = MaterialGroup::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_groups,name,' . $group->id,
            'status' => 'required|in:0,1',
        ]);

        $group->update($validated);
        return redirect()->route('admin.material.group.list')->with('success', 'Material group updated successfully!');
    }

    public function destroy($id)
    {
        $group = MaterialGroup::findOrFail($id);
        $group->delete();
        return redirect()->route('admin.material.group.list')->with('success', 'Material group deleted successfully.');
    }
}
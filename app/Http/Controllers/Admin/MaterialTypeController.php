<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialType;
use App\Models\MaterialGroup;

class MaterialTypeController extends Controller
{
    //listing MaterialType  with pagination
    public function index(Request $request)
    {        
        $query = MaterialType::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['types'] = $query->paginate(10)->withQueryString();     
        return view('admin.material-type.index', $data);   
    }

    //Add material type
    public function create()
    {        
        $data['group'] = MaterialGroup::where('status', 1)->orderBy('name')->get();
        return view('admin.material-type.add', $data);
    }
    
    //Insert material type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',            
            'material_group_id' => 'required|exists:material_groups,id',
            'status'        => 'required|in:0,1',           
        ]);        

        $type = new MaterialType();

        $type->name                = $request->name;
        $type->material_group_id   = $request->material_group_id;    
        $type->status              = $request->status;
        $type->save();    

        return redirect()->route('admin.material.type.list')->with('success', 'Material type added successfully!');
    }
    
    //Edit material type
    public function edit($id)
    {
        $data['type'] = MaterialType::findOrFail($id);
        $data['group'] = MaterialGroup::where('status', 1)->orderBy('name')->get();
        return view('admin.material-type.edit', $data);
    }

    //Update material type
    public function update(Request $request, $id)
    {
        $material = MaterialType::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'material_group_id' => 'required|exists:material_groups,id',
            'status'        => 'required|in:0,1',
        ]);
        
        $material = MaterialType::findOrFail($id);
        
        $material->name                  = $request->name;
        $material->material_group_id     = $request->material_group_id; 
        $material->status                = $request->status;
        $material->save();

        return redirect()->route('admin.material.type.list')->with('success', 'Material type updated successfully!');
    }
    
    //Delete Material Type
    public function destroy($id)
    {
        $type = MaterialType::findOrFail($id);        
        $type->delete();
        return redirect()->route('admin.material.type.list')->with('success', 'Material type deleted successfully.');
    }
    
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialLayoutGroup;
use App\Models\MaterialLayoutCategory;

class MaterialLayoutGroupController extends Controller
{
    //listing Material Layout Group  with pagination
    public function index(Request $request)
    {        
        $query = MaterialLayoutGroup::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['layout_group'] = $query->paginate(10)->withQueryString();     
        return view('admin.material-layout-group.index', $data);   
    }

    //Add Material Layout Group
    public function create()
    {        
        $data['category'] = MaterialLayoutCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.material-layout-group.add', $data);
    }
    
    //Insert Material Layout Group
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',            
            'layout_category_id' => 'required|exists:material_layout_categories,id',
            'status'        => 'required|in:0,1',           
        ]);        

        $group = new MaterialLayoutGroup();

        $group->name                = $request->name;
        $group->layout_category_id  = $request->layout_category_id;    
        $group->status              = $request->status;
        $group->save();    

        return redirect()->route('admin.material.layout.group.list')->with('success', 'Material layout group added successfully!');
    }
    
    //Edit mMaterial Layout Group
    public function edit($id)
    {
        $data['group'] = MaterialLayoutGroup::findOrFail($id);
        $data['category'] = MaterialLayoutCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.material-layout-group.edit', $data);
    }

    //Update Material Layout Group
    public function update(Request $request, $id)
    {
        $group = MaterialLayoutGroup::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'layout_category_id' => 'required|exists:material_layout_categories,id',
            'status'        => 'required|in:0,1',
        ]);
        
        $group = MaterialLayoutGroup::findOrFail($id);
        
        $group->name                  = $request->name;
        $group->layout_category_id    = $request->layout_category_id; 
        $group->status                = $request->status;
        $group->save();

        return redirect()->route('admin.material.layout.group.list')->with('success', 'Material layout group updated successfully!');
    }
    
    //Delete Material Layout Group
    public function destroy($id)
    {
        $type = MaterialLayoutGroup::findOrFail($id);        
        $type->delete();
        return redirect()->route('admin.material.layout.group.list')->with('success', 'Material layout group deleted successfully.');
    }
    
}

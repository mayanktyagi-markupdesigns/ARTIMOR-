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
            'name'              => 'required|string|max:255',            
            'material_group_id' => 'required|exists:material_groups,id',
            'image'             => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
            'status'            => 'required|in:0,1',           
        ]);     
        
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Folder path
            $folderPath = public_path('uploads/material-type');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $type = new MaterialType();

        $type->name                = $request->name;
        $type->material_group_id   = $request->material_group_id; 
        $type->image               = $imageName;   
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
            'name'              => 'required|string|max:255',
            'material_group_id' => 'required|exists:material_groups,id',
            'image'             => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
            'status'            => 'required|in:0,1',
        ]);

        $imageName = $material->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/material-type');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($shape->image && file_exists($folderPath . '/' . $shape->image)) {
                unlink($folderPath . '/' . $shape->image);
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
        }
        
        $material = MaterialType::findOrFail($id);
        
        $material->name                  = $request->name;
        $material->image                 = $imageName;
        $material->material_group_id     = $request->material_group_id; 
        $material->status                = $request->status;
        $material->save();

        return redirect()->route('admin.material.type.list')->with('success', 'Material type updated successfully!');
    }
    
    //Delete Material Type
    public function destroy($id)
    {
        $type = MaterialType::findOrFail($id);

        // Delete image from folder
        if ($type->image) {
            $imagePath = public_path('uploads/material-type/' . $type->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the Material Layout Shape
        $type->save();
        $type->delete();
        return redirect()->route('admin.material.type.list')->with('success', 'Material type deleted successfully.');
    }
    
}

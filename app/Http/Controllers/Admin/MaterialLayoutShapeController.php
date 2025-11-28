<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialLayoutShape;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\MaterialLayoutGroup;
use Illuminate\Support\Facades\Storage;

class MaterialLayoutShapeController extends Controller
{
    
    //listing Material Layout Shape with pagination
    public function index(Request $request)
    {        
        $query = MaterialLayoutShape::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['shape'] = $query->paginate(10)->withQueryString();     
        return view('admin.material_layout_shapes.index', $data);   
    }

    //Add Material Layout Shape
    public function create()
    {        
        $data['group'] = MaterialLayoutGroup::where('status', 1)->orderBy('name')->get();
        return view('admin.material_layout_shapes.add', $data);
    }
    
    //Insert Material Layout Shape 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',            
            'layout_group_id' => 'required|exists:material_layout_groups,id',
            'status'        => 'required|in:0,1',
            'image'         => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
            'dimension_sides' => 'nullable|array',
            'dimension_sides.*.name' => 'required_with:dimension_sides|string',
            'dimension_sides.*.min' => 'required_with:dimension_sides|numeric',
            'dimension_sides.*.max' => 'required_with:dimension_sides|numeric',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Folder path
            $folderPath = public_path('uploads/layout-shapes');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $shape = new MaterialLayoutShape();

        $shape->name                   = $request->name;
        $shape->layout_group_id        = $request->layout_group_id;    
        $shape->image                  = $imageName;
        $shape->status                 = $request->status;
        $shape->dimension_sides        = $request->dimension_sides;

        $shape->save();    

        return redirect()->route('admin.material.layout.shape.list')->with('success', 'Material layout shape added successfully!');
    }
    
    //Edit Material Layout Shape
    public function edit($id)
    {
        $data['shape'] = MaterialLayoutShape::findOrFail($id);
        $data['group'] = MaterialLayoutGroup::where('status', 1)->orderBy('name')->get();
        return view('admin.material_layout_shapes.edit', $data);
    }

    //Update Material Layout Shape
    public function update(Request $request, $id)
    {
        $shape = MaterialLayoutShape::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'layout_group_id' => 'required|exists:material_layout_groups,id',
            'status'        => 'required|in:0,1',
            'image'         => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
            'dimension_sides' => 'nullable|array',
            'dimension_sides.*.name' => 'required_with:dimension_sides|string',
            'dimension_sides.*.min' => 'required_with:dimension_sides|numeric',
            'dimension_sides.*.max' => 'required_with:dimension_sides|numeric',
        ]);
        
        $imageName = $shape->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/layout-shapes');
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
        $shape = MaterialLayoutShape::findOrFail($id);
        
        $shape->name                  = $request->name;
        $shape->layout_group_id       = $request->layout_group_id; 
        $shape->image                 = $imageName;
        $shape->status                = $request->status;
        $shape->dimension_sides       = $request->dimension_sides;
        $shape->save();

        return redirect()->route('admin.material.layout.shape.list')->with('success', 'Material layout shape updated successfully!');
    }
    
    //Delete Material Layout Shape
    public function destroy($id)
    {
        $shape = MaterialLayoutShape::findOrFail($id);

        // Delete image from folder
        if ($shape->image) {
            $imagePath = public_path('uploads/layout-shapes/' . $shape->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the Material Layout Shape
        $shape->save();
        $shape->delete();

        return redirect()->route('admin.material.layout.shape.list')->with('success', 'Material layout shape deleted successfully.');
    }

    //view
    public function view($id)
    {
        $shape = MaterialLayoutShape::with('layoutGroup')->findOrFail($id);
        return view('admin.material_layout_shapes.view', compact('shape'));
    }


}
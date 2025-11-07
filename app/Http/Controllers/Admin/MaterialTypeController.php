<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialType;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\MaterialTypeCategory;
use Illuminate\Support\Facades\Storage;

class MaterialTypeController extends Controller
{
    //listing Material Type with pagination
    public function index(Request $request)
    {        
        $query = MaterialType::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['materialtype'] = $query->paginate(10)->withQueryString();     
        return view('admin.materialtype.index', $data);   
    }

    //Add material type
    public function create()
    {        
        $data['categories'] = MaterialTypeCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.materialtype.add', $data);
        
    }
    
    //Insert material type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255', 
            'material_type_category_id' => 'required|exists:material_type_categories,id', 
            'status' => 'required|in:0,1',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $folderPath = public_path('uploads/materialtype');

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
        }

        $materialtype = new MaterialType();

        // ✅ Place this line here
        $materialtype->material_type_category_id = $request->material_type_category_id;

        $materialtype->name  = $request->name;
        $materialtype->price = $request->price;
        $materialtype->image = $imageName;
        $materialtype->status = $request->status;
        $materialtype->save();

        return redirect()->route('admin.material.type.list')->with('success', 'Material Type added successfully!');
    }

    //Edit material type
    public function edit($id)
    {
        $data['materialtype'] = MaterialType::findOrFail($id); 
        $data['categories']   = MaterialTypeCategory::where('status', 1)->orderBy('name')->get();       
        return view('admin.materialtype.edit', $data);
    }

    //Update material type
    public function update(Request $request, $id)
    {
        $materialtype = MaterialType::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'material_type_category_id' => 'required|exists:material_type_categories,id',
            'status' => 'required|in:0,1',
            'price' => 'required|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);
        
        $imageName = $materialtype->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/materialtype');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($materialtype->image && file_exists($folderPath . '/' . $materialtype->image)) {
                unlink($folderPath . '/' . $materialtype->image);
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
            $materialtype->image = $imageName;
        }        

        $materialtype->material_type_category_id = $request->material_type_category_id;
        $materialtype->name                      = $request->name;
        $materialtype->price                     = $request->price;
        $materialtype->status                    = $request->status;
        $materialtype->save();

        return redirect()->route('admin.material.type.list')->with('success', 'Material Type updated successfully!');
    }
    
    //Delete material type
    public function destroy($id)
    {
        $materialtype = MaterialType::findOrFail($id);

        // Delete image from folder
        if ($materialtype->image) {
            $imagePath = public_path('uploads/materialtype/' . $materialtype->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the banner
        $materialtype->save();
        $materialtype->delete();

        return redirect()->route('admin.material.type.list')->with('success', 'Material Type deleted successfully.');
    }   
    
}

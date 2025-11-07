<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Storage;


class MaterialController extends Controller
{
    //listing material with pagination
    public function index(Request $request)
    {        
        $query = Material::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['materials'] = $query->paginate(10)->withQueryString();     
        return view('admin.materials.index', $data);   
    }

    //Add material
    public function create()
    {        
        $data['categories'] = MaterialCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.materials.add', $data);
    }
    
    //Insert material 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',            
            'material_category_id' => 'required|exists:material_categories,id',
            'price'         => 'required|numeric|min:0',
            'user_price'    => 'required|numeric|min:0',
            'status'        => 'required|in:0,1',
            'image'         => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Folder path
            $folderPath = public_path('uploads/materials');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $material = new Material();

        $material->name                   = $request->name;
        $material->material_category_id   = $request->material_category_id;    
        $material->price                  = $request->price;
        $material->user_price             = $request->user_price;
        $material->image                  = $imageName;
        $material->status                 = $request->status;
        $material->save();    

        return redirect()->route('admin.material.list')->with('success', 'Material added successfully!');
    }
    
    //Edit material
    public function edit($id)
    {
        $data['materials'] = Material::findOrFail($id);
        $data['categories'] = MaterialCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.materials.edit', $data);
    }

    //Update material
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'material_category_id' => 'required|exists:material_categories,id',
            'price'         => 'required|numeric|min:0',
            'user_price'    => 'required|numeric|min:0',
            'status'        => 'required|in:0,1',
            'image'         => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);
        
        $imageName = $material->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/materials');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($material->image && file_exists($folderPath . '/' . $material->image)) {
                unlink($folderPath . '/' . $material->image);
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
        }
        $material = Material::findOrFail($id);
        
        $material->name                  = $request->name;
        $material->material_category_id  = $request->material_category_id; 
        $material->price                 = $request->price;
        $material->user_price            = $request->user_price;
        $material->image                 = $imageName;
        $material->status                = $request->status;
        $material->save();

        return redirect()->route('admin.material.list')->with('success', 'Material updated successfully!');
    }
    
    //Delete banner
    public function destroy($id)
    {
        $material = Material::findOrFail($id);

        // Delete image from folder
        if ($material->image) {
            $imagePath = public_path('uploads/materials/' . $material->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the banner
        $material->save();
        $material->delete();

        return redirect()->route('admin.material.list')->with('success', 'Material deleted successfully.');
    }

    //Details View
    public function view($id)
    {
        $data['materials'] = Material::findOrFail($id);
        return view('admin.materials.view', $data);
    }

    
}

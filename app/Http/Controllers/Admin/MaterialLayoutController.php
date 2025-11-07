<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialLayout;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\materialLayoutCategory;
use Illuminate\Support\Facades\Storage;

class MaterialLayoutController extends Controller
{
    //listing material with pagination
    public function index(Request $request)
    {
        $query = MaterialLayout::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['layout'] = $query->paginate(10)->withQueryString();     
        return view('admin.material-layout.index', $data);   
    }

    //Add material
    public function create()
    {
        $data['categories'] = materialLayoutCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.material-layout.add', $data);       
    }
    
    //Insert material 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',            
            'material_layout_category_id' => 'required|exists:material_layout_categories,id',
            'status'        => 'required|in:0,1',
            'price'         => 'nullable|numeric|min:0',
            'user_price'    => 'required|numeric|min:0',
            'image'         => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Folder path
            $folderPath = public_path('uploads/material-layout');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $layout = new MaterialLayout();

        $layout->name                         = $request->name;
        $layout->material_layout_category_id  = $request->material_layout_category_id;    
        $layout->image                        = $imageName;
        $layout->price                        = $request->price;
        $layout->user_price                   = $request->user_price;
        $layout->status                       = $request->status;
        $layout->save();    

        return redirect()->route('admin.layout.list')->with('success', 'Material Layout added successfully!');
    }
    
    //Edit material
    public function edit($id)
    {
        $data['layout'] = MaterialLayout::findOrFail($id);   
        $data['categories'] = materialLayoutCategory::where('status', 1)->orderBy('name')->get();     
        return view('admin.material-layout.edit', $data);
    }

    //Update material layout
    public function update(Request $request, $id)
    {
        $layout = MaterialLayout::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'material_layout_category_id' => 'required|exists:material_layout_categories,id',
            'status'        => 'required|in:0,1',
            'price'         => 'nullable|numeric|min:0',
            'user_price'    => 'required|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);
        
        $imageName = $layout->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/material-layout');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($layout->image && file_exists($folderPath . '/' . $layout->image)) {
                unlink($folderPath . '/' . $layout->image);
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
            $layout->image = $imageName;
        }
              
        $layout->name                          = $request->name;
        $layout->material_layout_category_id   = $request->material_layout_category_id;
        $layout->price                         = $request->price;
        $layout->user_price                    = $request->user_price;
        $layout->status                        = $request->status;
        $layout->save();

        return redirect()->route('admin.layout.list')->with('success', 'Material layout updated successfully!');
    }
    
    //Delete banner
    public function destroy($id)
    {
        $layout = MaterialLayout::findOrFail($id);

        // Delete image from folder
        if ($layout->image) {
            $imagePath = public_path('uploads/material-layout/' . $layout->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the banner
        $layout->save();
        $layout->delete();

        return redirect()->route('admin.layout.list')->with('success', 'Material layout deleted successfully.');
    }

    //Details View
    public function view($id)
    {
        $data['layout'] = MaterialLayout::findOrFail($id);
        return view('admin.material-layout.view', $data);
    }
}

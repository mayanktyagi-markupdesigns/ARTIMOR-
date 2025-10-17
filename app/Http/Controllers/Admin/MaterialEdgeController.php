<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialEdge;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class MaterialEdgeController extends Controller
{
    //listing material edge with pagination
    public function index(Request $request)
    {
        $query = MaterialEdge::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['edge'] = $query->paginate(10)->withQueryString();     
        return view('admin.material-edge.index', $data);   
    }

    //Add material edge
    public function create()
    {
        return view('admin.material-edge.add');
    }
    
    //Insert material edge
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',            
            'status'        => 'required|in:0,1',
            'price'         => 'nullable|numeric|min:0',
            'image'         => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Folder path
            $folderPath = public_path('uploads/material-edge');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $edge = new MaterialEdge();

        $edge->name               = $request->name; 
        $edge->price              = $request->price; 
        $edge->image              = $imageName;
        $edge->status             = $request->status;
        $edge->save();    

        return redirect()->route('admin.material.edge.list')->with('success', 'Material edge added successfully!');
    }
    
    //Edit material edge
    public function edit($id)
    {
        $data['edge'] = MaterialEdge::findOrFail($id);        
        return view('admin.material-edge.edit', $data);
    }

    //Update material edge
    public function update(Request $request, $id)
    {
        $edge = MaterialEdge::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'status'        => 'required|in:0,1',
            'price'         => 'nullable|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);
        
        $imageName = $edge->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/material-edge');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($edge->image && file_exists($folderPath . '/' . $edge->image)) {
                unlink($folderPath . '/' . $edge->image);
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
            $edge->image = $imageName;
        }
              
        $edge->name          = $request->name;
        $edge->price         = $request->price;
        $edge->status        = $request->status;
        $edge->save();

        return redirect()->route('admin.material.edge.list')->with('success', 'Material edge updated successfully!');
    }
    
    //Delete material edge
    public function destroy($id)
    {
        $edge = MaterialEdge::findOrFail($id);

        // Delete image from folder
        if ($edge->image) {
            $imagePath = public_path('uploads/material-edge/' . $edge->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the edge
        $edge->save();
        $edge->delete();

        return redirect()->route('admin.material.edge.list')->with('success', 'Material edge deleted successfully.');
    } 
}

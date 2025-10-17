<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackWall;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class BackWallController extends Controller
{
    //listing back wall with pagination
    public function index(Request $request)
    {
        $query = BackWall::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['wall'] = $query->paginate(10)->withQueryString();     
        return view('admin.back-wall.index', $data);   
    }

    //Add back wall
    public function create()
    {
        return view('admin.back-wall.add');
    }
    
    //Insert back wall
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
            $folderPath = public_path('uploads/back-wall');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $wall = new BackWall();

        $wall->name               = $request->name; 
        $wall->price              = $request->price; 
        $wall->image              = $imageName;
        $wall->status             = $request->status;
        $wall->save();    

        return redirect()->route('admin.back.wall.list')->with('success', 'Back wall added successfully!');
    }
    
    //Edit back wall
    public function edit($id)
    {
        $data['wall'] = BackWall::findOrFail($id);        
        return view('admin.back-wall.edit', $data);
    }

    //Update back wall
    public function update(Request $request, $id)
    {
        $wall = BackWall::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'status'        => 'required|in:0,1',
            'price'         => 'nullable|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);
        
        $imageName = $wall->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/back-edge');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($wall->image && file_exists($folderPath . '/' . $wall->image)) {
                unlink($folderPath . '/' . $wall->image);
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
            $wall->image = $imageName;
        }
              
        $wall->name          = $request->name;
        $wall->price         = $request->price;
        $wall->status        = $request->status;
        $wall->save();

        return redirect()->route('admin.back.wall.list')->with('success', 'Material back wall updated successfully!');
    }
    
    //Delete back wall
    public function destroy($id)
    {
        $wall = BackWall::findOrFail($id);

        // Delete image from folder
        if ($wall->image) {
            $imagePath = public_path('uploads/back-wall/' . $wall->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the back wall
        $wall->save();
        $wall->delete();

        return redirect()->route('admin.back.wall.list')->with('success', 'Back wall deleted successfully.');
    } 
}


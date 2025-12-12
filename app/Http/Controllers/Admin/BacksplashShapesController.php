<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BacksplashShapes;  
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BacksplashShapesController extends Controller
{
    // LIST
    public function index()
    {
        $query = BacksplashShapes::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['shapes'] = $query->paginate(10)->withQueryString();     
        return view('admin.backsplash-shapes.index', $data);  
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.backsplash-shapes.add');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'sort_order'       => 'required|integer',
            'image'            => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
            //'dimension_fields' => 'nullable|array',
            'status'           => 'required|in:0,1',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Folder path
            $folderPath = public_path('uploads/backsplash-shape');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $shape = new BacksplashShapes();

        $shape->name              = $request->name;
        $shape->image             = $imageName;
        $shape->sort_order        = $request->sort_order;
        $shape->status            = $request->status;
        //$shape->dimension_fields  = $request->dimension_fields;

        $shape->save();

        return redirect()->route('admin.backsplash.shapes.list')
            ->with('success', 'Backsplash shape created successfully.');
    }

    // EDIT FORM
    public function edit($id)
    {
        $shape = BacksplashShapes::findOrFail($id);
        return view('admin.backsplash-shapes.edit', compact('shape'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $shape = BacksplashShapes::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'sort_order'    => 'required|integer',
            'image'         => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
            'status'        => 'required|in:0,1',
            //'dimension_fields' => 'nullable|array',
        ]);

        $imageName = $shape->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/backsplash-shape');
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

        $shape->name                  = $request->name;
        $shape->image                 = $imageName;
        $shape->sort_order            = $request->sort_order;
        $shape->status                = $request->status;
       // $shape->dimension_fields      = $request->dimension_fields;

        $shape->save();

        return redirect()->route('admin.backsplash.shapes.list')
            ->with('success', 'Backsplash shape updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        $shape = BacksplashShapes::findOrFail($id);

        // Delete image from folder
        if ($shape->image) {
            $imagePath = public_path('uploads/backsplash-shape/' . $shape->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the Material Layout Shape
        $shape->save();
        $shape->delete();
        return redirect()->route('admin.backsplash.shapes.list')->with('success', 'Backsplash shape deleted successfully.');

    }
}

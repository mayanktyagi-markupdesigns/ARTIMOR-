<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Banner;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    //listing banner with pagination
    public function index(Request $request)
    {
        $query = Banner::orderBy('id', 'desc');

        // Paginate the Location, retain the search query on pagination
        $data['banners'] = $query->paginate(10)->withQueryString();     
        return view('admin.banners.index', $data);
                
    }

    //Add banner
    public function create()
    {        
        return view('admin.banners.add');
    }
    
    //Insert banner 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Folder path
            $folderPath = public_path('uploads/banners');

            // Check if folder exists, if not then create it
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive = true
            }

            // Unique image name
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($folderPath, $imageName);
        }

        $banner = new Banner();

        $banner->title                      = $request->title;
        $banner->image                      = $imageName;    
        $banner->description                = $request->description;
        $banner->status                     = $request->status;
        $banner->save();    

        return redirect()->route('admin.banner.list')->with('success', 'Banner added successfully!');
    }
    
    // Edit banner
    public function edit($id)
    {
        $data['banner'] = Banner::findOrFail($id);        
        return view('admin.banners.edit', $data);
    }

    //Update banner
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string',
            'image'  => 'nullable|image|mimes:jpg,jpeg,JPG,svg,png,PNG|max:10024',
        ]);

        $imageName = $banner->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $folderPath = public_path('uploads/banners');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($banner->image && file_exists($folderPath . '/' . $banner->image)) {
                unlink($folderPath . '/' . $banner->image);
            }

            // Upload new image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
        }

        $banner = Banner::findOrFail($id);   
 
        $banner->title              = $request->title;
        $banner->image              = $imageName;    
        $banner->description        = $request->description;
        $banner->status             = $request->status;
        $banner->save();

        return redirect()->route('admin.banner.list')->with('success', 'Banner updated successfully!');
    }

    //Delete banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete image from folder
        if ($banner->image) {
            $imagePath = public_path('uploads/banners/' . $banner->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        // Soft delete the banner
        $banner->save();
        $banner->delete();

        return redirect()->route('admin.banner.list')->with('success', 'Banner deleted successfully.');
    }

    //Details View
    public function view($id)
    {
        $data['banner'] = Banner::findOrFail($id);
        return view('admin.banners.view', $data);
    }
}

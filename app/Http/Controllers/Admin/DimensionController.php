<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dimension;
use Illuminate\Support\Facades\File;

class DimensionController extends Controller
{
    // List all dimensions
    public function index()
    {
        $dimensions = Dimension::orderBy('id', 'desc')->paginate(10);
        return view('admin.dimensions.index', compact('dimensions'));
    }

    // Show create form
    public function create()
    {
        return view('admin.dimensions.add');
    }

    // Store new dimension
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,svg|max:10240',
            'height_cm' => 'required|numeric|min:0',
            'width_cm'  => 'required|numeric|min:0',
            'status'    => 'required|in:0,1',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $folderPath = public_path('uploads/dimensions');
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
        }

        Dimension::create([
            'image'     => $imageName,
            'height_cm' => $request->height_cm,
            'width_cm'  => $request->width_cm,
            'status'    => $request->status,
        ]);

        return redirect()->route('admin.dimension.index')->with('success', 'Dimension created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $dimension = Dimension::findOrFail($id);
        return view('admin.dimensions.edit', compact('dimension'));
    }

    // Update existing dimension
    public function update(Request $request, $id)
    {
        $dimension = Dimension::findOrFail($id);

        $validated = $request->validate([
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,svg|max:10240',
            'height_cm' => 'required|numeric|min:0',
            'width_cm'  => 'required|numeric|min:0',
            'status'    => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $folderPath = public_path('uploads/dimensions');
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            // Delete old image if exists
            if ($dimension->image && File::exists($folderPath . '/' . $dimension->image)) {
                File::delete($folderPath . '/' . $dimension->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);
            $dimension->image = $imageName;
        }

        $dimension->height_cm = $request->height_cm;
        $dimension->width_cm = $request->width_cm;
        $dimension->status = $request->status;
        $dimension->save();

        return redirect()->route('admin.dimension.list')->with('success', 'Dimension updated successfully.');
    }

    // Delete dimension
    public function destroy($id)
    {
        $dimension = Dimension::findOrFail($id);

        if ($dimension->image) {
            $imagePath = public_path('uploads/dimensions/' . $dimension->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $dimension->delete();

        return redirect()->route('admin.dimension.list')->with('success', 'Dimension deleted successfully.');
    }

    // Optional: show details
    public function show($id)
    {
        $dimension = Dimension::findOrFail($id);
        return view('admin.dimensions.show', compact('dimension'));
    }
}

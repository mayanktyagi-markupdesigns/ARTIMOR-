<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BacksplashShapeSides;
use App\Models\BacksplashShapes;
use Illuminate\Support\Facades\File;

class BacksplashShapeSidesController extends Controller
{
    // LIST
    public function index()
    {
        $query = BacksplashShapeSides::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['sides'] = $query->paginate(10)->withQueryString();     
        return view('admin.backsplash-shape-sides.index', $data); 
    }

    // CREATE FORM
    public function create()
    {
        $data['shapes'] = BacksplashShapes::orderBy('name')->get();
        return view('admin.backsplash-shape-sides.add', $data);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'backsplash_shape_id' => 'required|exists:backsplash_shapes,id',
            'side_name'           => 'required|string|max:50',
            'label'               => 'nullable|string|max:255',
            'is_finishable'       => 'required|boolean',
            'sort_order'          => 'required|integer',
            'status'              => 'required|in:0,1',
        ]);

        $side = new BacksplashShapeSides();

        $side->backsplash_shape_id       = $request->backsplash_shape_id;
        $side->side_name                 = $request->side_name;
        $side->label                     = $request->label;
        $side->is_finishable             = $request->is_finishable;
        $side->sort_order                = $request->sort_order;
        $side->status                    = $request->status;

        $side->save();
        return redirect()->route('admin.backsplash.shapes.sides.list')->with('success', 'Backsplash Shape Side created successfully.');
    }

    // EDIT FORM
    public function edit($id)
    {
        $data['side']   = BacksplashShapeSides::findOrFail($id);
        $data['shapes'] = BacksplashShapes::orderBy('name')->get();
        return view('admin.backsplash-shape-sides.edit', $data);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $side = BacksplashShapeSides::findOrFail($id);

        $request->validate([
            'backsplash_shape_id' => 'required|exists:backsplash_shapes,id',
            'side_name'           => 'required|string|max:50',
            'label'               => 'nullable|string|max:255',
            'is_finishable'       => 'required|boolean',
            'sort_order'          => 'required|integer',
            'status'              => 'required|in:0,1',
        ]);

        $side->backsplash_shape_id       = $request->backsplash_shape_id;
        $side->side_name                 = $request->side_name;
        $side->label                     = $request->label;
        $side->is_finishable             = $request->is_finishable;
        $side->sort_order                = $request->sort_order;
        $side->status                    = $request->status;

        $side->save();
        return redirect()->route('admin.backsplash.shapes.sides.list')->with('success', 'Backsplash Shape Side updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        $side = BacksplashShapeSides::findOrFail($id);
        $side->delete();
        return redirect()->route('admin.backsplash.shapes.sides.list')->with('success', 'Backsplash Shape Side deleted successfully.');
    }
}

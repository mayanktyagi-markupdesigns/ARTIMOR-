<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialLayoutCategory;

class MaterialLayoutCaterogyController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialLayoutCategory::orderBy('id', 'desc');
        $data['categories'] = $query->paginate(10)->withQueryString();
        return view('admin.material-layout-category.index', $data);
    }

    public function create()
    {
        return view('admin.material-layout-category.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_layout_categories,name',
            'status' => 'required|in:0,1',
        ]);

        $material_category = new MaterialLayoutCategory();

        $material_category->name               = $request->name;       
        $material_category->status             = $request->status;
        $material_category->save();    
       
        return redirect()->route('admin.material.layout.category.list')->with('success', 'Material layout Category created successfully!');
    }

    public function edit($id)
    {
        $data['category'] = MaterialLayoutCategory::findOrFail($id);
        return view('admin.material-layout-category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $category = MaterialLayoutCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_layout_categories,name,' . $category->id,
            'status' => 'required|in:0,1',
        ]);

        $category->update($validated);
        return redirect()->route('admin.material.layout.category.list')->with('success', 'Material layout Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = MaterialLayoutCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.material.layout.category.list')->with('success', 'Material layout Category deleted successfully.');
    }
}

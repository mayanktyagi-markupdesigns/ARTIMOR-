<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialCategory;

class MaterialCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialCategory::orderBy('id', 'desc');
        $data['categories'] = $query->paginate(10)->withQueryString();
        return view('admin.materialcategory.index', $data);
    }

    public function create()
    {
        return view('admin.materialcategory.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_categories,name',
            'status' => 'required|in:0,1',
        ]);

        $material_category = new MaterialCategory();

        $material_category->name               = $request->name;       
        $material_category->status             = $request->status;
        $material_category->save();    
       
        return redirect()->route('admin.material.category.list')->with('success', 'Material Category created successfully!');
    }

    public function edit($id)
    {
        $data['category'] = MaterialCategory::findOrFail($id);
        return view('admin.materialcategory.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $category = MaterialCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_categories,name,' . $category->id,
            'status' => 'required|in:0,1',
        ]);

        $category->update($validated);
        return redirect()->route('admin.material.category.list')->with('success', 'Material Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = MaterialCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.material.category.list')->with('success', 'Material Category deleted successfully.');
    }
}



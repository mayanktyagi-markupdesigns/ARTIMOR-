<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialTypeCategory;

class MaterialTypeCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialTypeCategory::orderBy('id', 'desc');
        $data['categories'] = $query->paginate(10)->withQueryString();
        return view('admin.material-type-category.index', $data);
    }

    public function create()
    {
        return view('admin.material-type-category.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_type_categories,name',
            'status' => 'required|in:0,1',
        ]);

        $material_category = new MaterialTypeCategory();

        $material_category->name               = $request->name;       
        $material_category->status             = $request->status;
        $material_category->save();    
       
        return redirect()->route('admin.material.type.category.list')->with('success', 'Material type Category created successfully!');
    }

    public function edit($id)
    {
        $data['category'] = MaterialTypeCategory::findOrFail($id);
        return view('admin.material-type-category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $category = MaterialTypeCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_type_categories,name,' . $category->id,
            'status' => 'required|in:0,1',
        ]);

        $category->update($validated);
        return redirect()->route('admin.material.type.category.list')->with('success', 'Material Type Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = MaterialTypeCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.material.type.category.list')->with('success', 'Material type Category deleted successfully.');
    }
}
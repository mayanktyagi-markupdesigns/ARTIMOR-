<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CutOutsCategory;

class CutOutsCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = CutOutsCategory::orderBy('id', 'desc');
        $data['categories'] = $query->paginate(10)->withQueryString();
        return view('admin.cut-outs-category.index', $data);
    }

    public function create()
    {
        return view('admin.cut-outs-category.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cut_outs_categories,name',
            'status' => 'required|in:0,1',
        ]);

        $material_category = new CutOutsCategory();

        $material_category->name               = $request->name;       
        $material_category->status             = $request->status;
        $material_category->save();    
       
        return redirect()->route('admin.cutouts.category.list')->with('success', 'Cut Outs Category created successfully!');
    }

    public function edit($id)
    {
        $data['category'] = CutOutsCategory::findOrFail($id);
        return view('admin.cut-outs-category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $category = CutOutsCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cut_outs_categories,name,' . $category->id,
            'status' => 'required|in:0,1',
        ]);

        $category->update($validated);
        return redirect()->route('admin.cutouts.category.list')->with('success', 'Cut Outs Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = CutOutsCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.cutouts.category.list')->with('success', 'Cut Outs Category deleted successfully.');
    }
}

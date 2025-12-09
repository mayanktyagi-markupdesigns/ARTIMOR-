<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SinkCategory;

class SinkCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = SinkCategory::orderBy('id', 'desc');
        $data['categories'] = $query->paginate(10)->withQueryString();
        return view('admin.sink-category.index', $data);
    }

    public function create()
    {
        return view('admin.sink-category.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_type_categories,name',
            'status' => 'required|in:0,1',
        ]);

        $material_category = new SinkCategory();

        $material_category->name               = $request->name;       
        $material_category->status             = $request->status;
        $material_category->save();    
       
        return redirect()->route('admin.sink.category.list')->with('success', 'Material layout Category created successfully!');
    }

    public function edit($id)
    {
        $data['category'] = SinkCategory::findOrFail($id);
        return view('admin.sink-category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $category = SinkCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_layout_categories,name,' . $category->id,
            'status' => 'required|in:0,1',
        ]);

        $category->update($validated);
        return redirect()->route('admin.sink.category.list')->with('success', 'Material layout Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = SinkCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.sink.category.list')->with('success', 'Material layout Category deleted successfully.');
    }
    
}

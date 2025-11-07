<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $query = Color::orderBy('id', 'desc');
        $data['color'] = $query->paginate(10)->withQueryString();
        return view('admin.color.index', $data);
    }

    public function create()
    {
        return view('admin.color.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255|unique:colors,name',
            'code'   => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $color = new Color();

        $color->name               = $request->name;       
        $color->code               = $request->code;       
        $color->status             = $request->status;
        $color->save();    
       
        return redirect()->route('admin.color.list')->with('success', 'Code created successfully!');
    }

    public function edit($id)
    {
        $data['color'] = Color::findOrFail($id);
        return view('admin.color.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'code'   => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $color->update($validated);
        return redirect()->route('admin.color.list')->with('success', 'Color updated successfully!');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('admin.color.list')->with('success', 'Color deleted successfully.');
    }
}

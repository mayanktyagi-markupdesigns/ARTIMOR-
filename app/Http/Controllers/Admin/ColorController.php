<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\MaterialType;

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
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        return view('admin.color.add', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255|unique:colors,name',
            'material_type_id' => 'required|exists:material_types,id',
            'status' => 'required|in:0,1',
        ]);

        $color = new Color();

        $color->name               = $request->name;       
        $color->material_type_id   = $request->material_type_id;      
        $color->status             = $request->status;
        $color->save();    
       
        return redirect()->route('admin.color.list')->with('success', 'Code created successfully!');
    }

    public function edit($id)
    {
        $data['color'] = Color::findOrFail($id);
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        return view('admin.color.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $material = Color::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'material_type_id' => 'required|exists:material_types,id',
            'status'        => 'required|in:0,1',
        ]);
        
        $color = Color::findOrFail($id);
        
        $color->name                 = $request->name;
        $color->material_type_id     = $request->material_type_id; 
        $color->status               = $request->status;
        $color->save();

        return redirect()->route('admin.color.list')->with('success', 'Material color updated successfully!');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('admin.color.list')->with('success', 'Material color deleted successfully.');
    }
}

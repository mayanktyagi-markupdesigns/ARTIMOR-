<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\MaterialGroup;
use App\Models\MaterialType;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $query = Color::with(['materialGroup', 'materialType'])->orderBy('id', 'desc');
        $data['color'] = $query->paginate(10)->withQueryString();
        return view('admin.color.index', $data);
    }

    public function create()
    {
        $data['groups'] = MaterialGroup::where('status', 1)->orderBy('name')->get();
        return view('admin.color.add', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255|unique:colors,name',
            'material_group_id' => 'required|exists:material_groups,id',
            'material_type_id' => 'required|exists:material_types,id',
            'status' => 'required|in:0,1',
        ]);

        $color = new Color();

        $color->name               = $request->name;
        $color->material_group_id  = $request->material_group_id;       
        $color->material_type_id   = $request->material_type_id;      
        $color->status             = $request->status;
        $color->save();    
       
        return redirect()->route('admin.color.list')->with('success', 'Color created successfully!');
    }

    public function edit($id)
    {
        $data['color'] = Color::findOrFail($id);
        $data['groups'] = MaterialGroup::where('status', 1)->orderBy('name')->get();
        $data['types'] = MaterialType::where('material_group_id', $data['color']->material_group_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();
        return view('admin.color.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255|unique:colors,name,' . $color->id,
            'material_group_id' => 'required|exists:material_groups,id',
            'material_type_id' => 'required|exists:material_types,id',
            'status'        => 'required|in:0,1',
        ]);
        
        $color->name                 = $request->name;
        $color->material_group_id    = $request->material_group_id;
        $color->material_type_id     = $request->material_type_id; 
        $color->status               = $request->status;
        $color->save();

        return redirect()->route('admin.color.list')->with('success', 'Color updated successfully!');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('admin.color.list')->with('success', 'Color deleted successfully.');
    }

    // AJAX: Get Material Types by Material Group ID
    public function getMaterialTypes(Request $request)
    {
        $materialGroupId = $request->get('material_group_id');
        
        if (!$materialGroupId) {
            return response()->json(['types' => []]);
        }

        $types = MaterialType::where('material_group_id', $materialGroupId)
            ->where('status', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['types' => $types]);
    }
}

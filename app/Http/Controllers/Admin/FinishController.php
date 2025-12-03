<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finish;
use App\Models\Color;
use App\Models\MaterialGroup;
use App\Models\MaterialType;

class FinishController extends Controller
{
    // Listing Finish with pagination
    public function index(Request $request)
    {
        $query = Finish::orderBy('id', 'desc');
        $data['finishes'] = $query->paginate(10)->withQueryString();
        return view('admin.finish.index', $data);
    }

    // Add Finish
    public function create()
    {
        $data['color'] = Color::where('status', 1)->orderBy('name')->get();
        $data['groups'] = MaterialGroup::where('status', 1)->orderBy('name')->get();
        return view('admin.finish.add', $data);
    }

    // Insert Finish
    public function store(Request $request)
    {
        $validated = $request->validate([
            'finish_name' => 'required|string|max:255',
            'color_id' => 'required|exists:colors,id',
            'material_group_id' => 'required|exists:material_groups,id',
            'material_type_id' => 'required|exists:material_types,id',
            'status' => 'required|in:0,1',
        ]);

        $finish = new Finish();
        $finish->finish_name = $request->finish_name;
        $finish->color_id = $request->color_id;
        $finish->material_group_id  = $request->material_group_id;       
        $finish->material_type_id   = $request->material_type_id; 
        $finish->status = $request->status;
        $finish->save();

        return redirect()->route('admin.finish.list')->with('success', 'Finish created successfully!');
    }

    public function edit($id)
    {
        $data['finish'] = Finish::findOrFail($id);
        $data['color'] = Color::where('status', 1)->orderBy('name')->get();
        $data['groups'] = MaterialGroup::where('status', 1)->orderBy('name')->get();
        $data['types'] = MaterialType::where('material_group_id', $data['finish']->material_group_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();
        return view('admin.finish.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $finish = Finish::findOrFail($id);

        $validated = $request->validate([
            'finish_name' => 'required|string|max:255',
            'color_id'    => 'required|exists:colors,id',
            'material_group_id' => 'required|exists:material_groups,id',
            'material_type_id' => 'required|exists:material_types,id',
            'status'        => 'required|in:0,1',

        ]);
        
        $finish->finish_name          = $request->finish_name;
        $finish->color_id             = $request->color_id;
        $finish->material_group_id    = $request->material_group_id;
        $finish->material_type_id     = $request->material_type_id; 
        $finish->status               = $request->status;
        $finish->save();

        return redirect()->route('admin.finish.list')->with('success', 'Finish updated successfully!');
    }

    // Delete Finish
    public function destroy($id)
    {
        $finish = Finish::findOrFail($id);
        $finish->delete();
        return redirect()->route('admin.finish.list')->with('success', 'Finish deleted successfully.');
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

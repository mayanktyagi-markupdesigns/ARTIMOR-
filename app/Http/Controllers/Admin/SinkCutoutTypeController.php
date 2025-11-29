<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SinkCutoutType;

class SinkCutoutTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = SinkCutoutType::orderBy('id', 'desc');
        $data['sinksType'] = $query->paginate(10)->withQueryString();
        return view('admin.sink-cutout-type.index', $data);
    }

    public function create()
    {
        return view('admin.sink-cutout-type.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_groups,name',
            'status' => 'required|in:0,1',
        ]);

        $sinksType = new SinkCutoutType();

        $sinksType->name               = $request->name;       
        $sinksType->status             = $request->status;
        $sinksType->save();    
       
        return redirect()->route('admin.sink.cutout.type.list')->with('success', 'Sink cutout type created successfully!');
    }

    public function edit($id)
    {
        $data['sinksType'] = SinkCutoutType::findOrFail($id);
        return view('admin.sink-cutout-type.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $sinksType = SinkCutoutType::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_groups,name,' . $sinksType->id,
            'status' => 'required|in:0,1',
        ]);

        $sinksType->update($validated);
        return redirect()->route('admin.sink.cutout.type.list')->with('success', 'Sink cutout type updated successfully!');
    }

    public function destroy($id)
    {
        $sinksType = SinkCutoutType::findOrFail($id);
        $sinksType->delete();
        return redirect()->route('admin.sink.cutout.type.list')->with('success', 'Sink cutout type deleted successfully.');
    }
}

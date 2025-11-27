<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EdgeProfile;

class EdgeProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = EdgeProfile::orderBy('id', 'desc');
        $data['edge'] = $query->paginate(10)->withQueryString();
        return view('admin.edge-profile.index', $data);
    }

    public function create()
    {
        return view('admin.edge-profile.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|in:0,1',
        ]);

        $edge = new EdgeProfile();

        $edge->name               = $request->name;       
        $edge->status             = $request->status;
        $edge->save();    
       
        return redirect()->route('admin.edge.profile.list')->with('success', 'Edge profile created successfully!');
    }

    public function edit($id)
    {
        $data['edge'] = EdgeProfile::findOrFail($id);
        return view('admin.edge-profile.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $edge = EdgeProfile::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|in:0,1',
        ]);

        $edge->update($validated);
        return redirect()->route('admin.edge.profile.list')->with('success', 'Edge profile updated successfully!');
    }

    public function destroy($id)
    {
        $edge = EdgeProfile::findOrFail($id);
        $edge->delete();
        return redirect()->route('admin.edge.profile.list')->with('success', 'Edge profile deleted successfully.');
    }
}
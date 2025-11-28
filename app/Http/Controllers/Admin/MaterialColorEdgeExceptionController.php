<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialType;
use App\Models\EdgeProfile;
use App\Models\MaterialColorEdgeException;
use App\Models\Thickness;
use App\Models\Color;

class MaterialColorEdgeExceptionController extends Controller
{
    //listing edge profile thickness  with pagination
    public function index(Request $request)
    {        
        $query = MaterialColorEdgeException::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['color_edge_exception'] = $query->paginate(10)->withQueryString();     
        return view('admin.color-edge-exception.index', $data);   
    }

    //Add edge profile thickness
    public function create()
    {        
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        $data['color'] = Color::where('status', 1)->orderBy('name')->get();
        $data['edge'] = EdgeProfile::where('status', 1)->orderBy('name')->get();
        $data['thickness'] = Thickness::where('status', 1)->orderBy('thickness_value')->get();
        return view('admin.color-edge-exception.add', $data);
    }
    
    //Insert edge profile thickness
    public function store(Request $request)
    {
        $validated = $request->validate([      
            'material_type_id' => 'required|exists:material_types,id',
            'color_id'         => 'required|exists:colors,id',
            'edge_profile_id'  => 'required|exists:edge_profiles,id',
            'thickness_id'     => 'required|exists:thicknesses,id',
            'is_allowed'       => 'required|in:true,false',
            'override_price_per_lm'  =>  'nullable|numeric|min:0',
            'status'           => 'required|in:0,1',           
        ]);        
        // Convert true/false string → 1/0
        $isAllowed = filter_var($request->is_allowed, FILTER_VALIDATE_BOOLEAN);

        $color_edge_exception = new MaterialColorEdgeException();

        $color_edge_exception->material_type_id        = $request->material_type_id;
        $color_edge_exception->color_id                = $request->color_id;
        $color_edge_exception->edge_profile_id         = $request->edge_profile_id;
        $color_edge_exception->thickness_id            = $request->thickness_id;    
        $color_edge_exception->is_allowed              = $isAllowed;     
        $color_edge_exception->override_price_per_lm   = $request->override_price_per_lm;
        $color_edge_exception->status                  = $request->status;
        $color_edge_exception->save();    

        return redirect()->route('admin.color.edge.exception.list')->with('success', 'Material color edge exception added successfully!');
    }
    
    //Edit edge profile thickness
    public function edit($id)
    {
        $data['color_edge_exception'] = MaterialColorEdgeException::findOrFail($id);
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        $data['color'] = Color::where('status', 1)->orderBy('name')->get();
        $data['edgeProfiles'] = EdgeProfile::where('status', 1)->orderBy('name')->get();
        $data['thicknesses'] = Thickness::where('status', 1)->orderBy('thickness_value')->get();
        return view('admin.color-edge-exception.edit', $data);
    }

    //Update edge.profile.thickness
    public function update(Request $request, $id)
    {
        $color_edge_exception = MaterialColorEdgeException::findOrFail($id);

        $validated = $request->validate([
            'material_type_id' => 'required|exists:material_types,id',
            'color_id'         => 'required|exists:colors,id',
            'edge_profile_id'  => 'required|exists:edge_profiles,id',
            'thickness_id'     => 'required|exists:thicknesses,id',
            'is_allowed'       => 'required|in:true,false',
            'override_price_per_lm'  =>  'nullable|numeric|min:0',
            'status'          => 'required|in:0,1', 
        ]);
        
        // Convert true/false string → 1/0
        $isAllowed = filter_var($request->is_allowed, FILTER_VALIDATE_BOOLEAN);

        $color_edge_exception = MaterialColorEdgeException::findOrFail($id);
        
        $color_edge_exception->material_type_id        = $request->material_type_id;
        $color_edge_exception->color_id                = $request->color_id;
        $color_edge_exception->edge_profile_id         = $request->edge_profile_id;
        $color_edge_exception->thickness_id            = $request->thickness_id;    
        $color_edge_exception->is_allowed              = $isAllowed;       
        $color_edge_exception->override_price_per_lm   = $request->override_price_per_lm;
        $color_edge_exception->status                  = $request->status;
        $color_edge_exception->save();

        return redirect()->route('admin.color.edge.exception.list')->with('success', 'Material color edge exception updated successfully!');
    }
    
    //Delete edge profile thickness
    public function destroy($id)
    {
        $color_edge_exception = MaterialColorEdgeException::findOrFail($id);        
        $color_edge_exception->delete();
        return redirect()->route('admin.color.edge.exception.list')->with('success', 'Material color edge exception deleted successfully.');
    }
    
}

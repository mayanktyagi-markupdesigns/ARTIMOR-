<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EdgeProfile;
use App\Models\EdgeProfileThicknessRule;
use App\Models\MaterialType;
use App\Models\Thickness;
use Illuminate\Validation\Rule;

class EdgeProfileThicknessController extends Controller
{
    //listing edge profile thickness  with pagination
    public function index(Request $request)
    {        
        $query = EdgeProfileThicknessRule::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['edge_profile_rule'] = $query->paginate(10)->withQueryString();     
        return view('admin.edge-profile-rules.index', $data);   
    }

    //Add edge profile thickness
    public function create()
    {        
        $data['edge'] = EdgeProfile::where('status', 1)->orderBy('name')->get();
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        $data['thickness'] = Thickness::where('status', 1)->orderBy('thickness_value')->get();
        return view('admin.edge-profile-rules.add', $data);
    }
    
    //Insert edge profile thickness
    public function store(Request $request)
    {
        $validated = $request->validate([      
            'edge_profile_id'     => 'required|exists:edge_profiles,id',
            'material_type_id'    => 'required|exists:material_types,id',
            'thickness_id'        => 'required|exists:thicknesses,id',
            'price_per_lm_guest'  =>  'required|numeric|min:0',
            'price_per_lm_business'    => 'required|numeric|min:0',
            'status'              => 'required|in:0,1',           
        ]);        
        // Convert true/false string → 1/0
        $isAllowed = filter_var($request->is_allowed, FILTER_VALIDATE_BOOLEAN);

        $edge_profile_rule = new EdgeProfileThicknessRule();

        $edge_profile_rule->edge_profile_id         = $request->edge_profile_id;
        $edge_profile_rule->material_type_id        = $request->material_type_id;
        $edge_profile_rule->thickness_id            = $request->thickness_id;    
        //$edge_profile_rule->is_allowed              = $isAllowed;   
        $edge_profile_rule->price_per_lm_guest      = $request->price_per_lm_guest;    
        $edge_profile_rule->price_per_lm_business   = $request->price_per_lm_business;    
        $edge_profile_rule->status                  = $request->status;
        $edge_profile_rule->save();    

        return redirect()->route('admin.edge.profile.thickness.list')->with('success', 'Edge profile thickness rule added successfully!');
    }
    
    //Edit edge profile thickness
    public function edit($id)
    {
        $data['rule'] = EdgeProfileThicknessRule::findOrFail($id);
        $data['edgeProfiles'] = EdgeProfile::where('status', 1)->orderBy('name')->get();
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        $data['thicknesses'] = Thickness::where('status', 1)->orderBy('thickness_value')->get();
        return view('admin.edge-profile-rules.edit', $data);
    }

    //Update edge.profile.thickness
    public function update(Request $request, $id)
    {
        $edge_profile_rule = EdgeProfileThicknessRule::findOrFail($id);

        $validated = $request->validate([
            'edge_profile_id'  => 'required|exists:edge_profiles,id',
            'material_type_id' => 'required|exists:material_types,id',
            'thickness_id'     => 'required|exists:thicknesses,id',
            'price_per_lm_guest'    =>  'required|numeric|min:0',
            'price_per_lm_business'    => 'required|numeric|min:0',
            'status'          => 'required|in:0,1', 
        ]);
        
        // Convert true/false string → 1/0
        $isAllowed = filter_var($request->is_allowed, FILTER_VALIDATE_BOOLEAN);

        $edge_profile_rule = EdgeProfileThicknessRule::findOrFail($id);
        
        $edge_profile_rule->edge_profile_id         = $request->edge_profile_id;
        $edge_profile_rule->material_type_id        = $request->material_type_id;
        $edge_profile_rule->thickness_id            = $request->thickness_id;    
        //$edge_profile_rule->is_allowed              = $isAllowed;    
        $edge_profile_rule->price_per_lm_guest      = $request->price_per_lm_guest;    
        $edge_profile_rule->price_per_lm_business   = $request->price_per_lm_business;    
        $edge_profile_rule->status                  = $request->status;
        $edge_profile_rule->save();

        return redirect()->route('admin.edge.profile.thickness.list')->with('success', 'Edge profile thickness rule updated successfully!');
    }
    
    //Delete edge profile thickness
    public function destroy($id)
    {
        $edge_profile_rule = EdgeProfileThicknessRule::findOrFail($id);        
        $edge_profile_rule->delete();
        return redirect()->route('admin.edge.profile.thickness.list')->with('success', 'Edge profile thickness rule deleted successfully.');
    }
    
}

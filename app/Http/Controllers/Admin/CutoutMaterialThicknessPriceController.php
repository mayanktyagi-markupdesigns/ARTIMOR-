<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CutoutMaterialThicknessPrice;
use App\Models\MaterialType;
use App\Models\CutOuts;
use Illuminate\Validation\Rule;

class CutoutMaterialThicknessPriceController extends Controller
{
    //listing edge profile thickness  with pagination
    public function index(Request $request)
    {        
        $query = CutoutMaterialThicknessPrice::orderBy('id', 'desc');
        // Paginate the Location, retain the search query on pagination
        $data['cutout_material_thickness'] = $query->paginate(10)->withQueryString();     
        return view('admin.cutout-material-thickness-prices.index', $data);   
    }

    //Add edge profile thickness
    public function create()
    {        
        $data['cutouts'] = CutOuts::where('status', 1)->orderBy('name')->get();
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        return view('admin.cutout-material-thickness-prices.add', $data);
    }
    
    //Insert edge profile thickness
    public function store(Request $request)
    {
        $validated = $request->validate([      
            'cut_out_id'         => 'required|exists:cut_outs,id',
            'material_type_id'   => 'required|exists:material_types,id',
            'thickness_value'    => 'required|string|max:255',
            'price_guest'        => 'required|numeric|min:0',
            'price_business'     => 'required|numeric|min:0',
            'status'             => 'required|in:0,1',           
        ]);        
       
        $cutout_material_thickness = new CutoutMaterialThicknessPrice();

        $cutout_material_thickness->cut_out_id              = $request->cut_out_id;
        $cutout_material_thickness->material_type_id        = $request->material_type_id;
        $cutout_material_thickness->thickness_value         = $request->thickness_value;      
        $cutout_material_thickness->price_guest             = $request->price_guest;    
        $cutout_material_thickness->price_business          = $request->price_business;    
        $cutout_material_thickness->status                  = $request->status;
        $cutout_material_thickness->save();    

        return redirect()->route('admin.cutout.material.thickness.price.controller.list')->with('success', 'Cutout material thickness price added successfully!');
    }
    
    //Edit edge profile thickness
    public function edit($id)
    {
        $data['cutout_material_thickness'] = CutoutMaterialThicknessPrice::findOrFail($id);
        $data['cutouts'] = CutOuts::where('status', 1)->orderBy('name')->get();
        $data['type'] = MaterialType::where('status', 1)->orderBy('name')->get();
        return view('admin.cutout-material-thickness-prices.edit', $data);
    }

    //Update cutout.material.thickness.price.controller
    public function update(Request $request, $id)
    {
        $cutout_material_thickness = CutoutMaterialThicknessPrice::findOrFail($id);

        $validated = $request->validate([
            'cut_out_id'         => 'required|exists:cut_outs,id',
            'material_type_id'   => 'required|exists:material_types,id',
            'thickness_value'    => 'required|string|max:255',
            'price_guest'        => 'required|numeric|min:0',
            'price_business'     => 'required|numeric|min:0',
            'status'             => 'required|in:0,1', 
        ]);
        
        $cutout_material_thickness = CutoutMaterialThicknessPrice::findOrFail($id);
        
        $cutout_material_thickness->cut_out_id              = $request->cut_out_id;
        $cutout_material_thickness->material_type_id        = $request->material_type_id;
        $cutout_material_thickness->thickness_value         = $request->thickness_value;      
        $cutout_material_thickness->price_guest             = $request->price_guest;    
        $cutout_material_thickness->price_business          = $request->price_business;    
        $cutout_material_thickness->status                  = $request->status;
        $cutout_material_thickness->save();

        return redirect()->route('admin.cutout.material.thickness.price.controller.list')->with('success', 'Cutout material thickness price updated successfully!');
    }
    
    //Delete edge profile thickness
    public function destroy($id)
    {
        $cutout_material_thickness = CutoutMaterialThicknessPrice::findOrFail($id);        
        $cutout_material_thickness->delete();
        return redirect()->route('admin.cutout.material.thickness.price.controller.list')->with('success', 'Cutout material thickness price deleted successfully.');
    }
    
}

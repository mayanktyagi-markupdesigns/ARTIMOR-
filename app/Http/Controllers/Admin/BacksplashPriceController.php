<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BacksplashPrice;
use App\Models\MaterialType;
use App\Models\BacksplashShapes;

class BacksplashPriceController extends Controller
{
    // LIST
    public function index()
    {       
        $query = BacksplashPrice::with('materialType')->orderBy('id','desc');
        // Paginate the Location, retain the search query on pagination
        $data['prices'] = $query->paginate(10)->withQueryString();     
        return view('admin.backsplash-price.index', $data); 
    }

    // CREATE FORM
    public function create()
    {
        $data['backsplashShapes'] = BacksplashShapes::where('status', 1)->get();
        $data['materialTypes'] = MaterialType::where('status', 1)->get();
        return view('admin.backsplash-price.add', $data);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'backsplash_shape_id' => 'required|exists:backsplash_shapes,id',
            'material_type_id' => 'required|exists:material_types,id',
            'price_lm_guest' => 'required|numeric|min:0',
            'finished_side_price_lm_guest' => 'nullable|numeric|min:0',
            'price_lm_business' => 'required|numeric|min:0',
            'finished_side_price_lm_business' => 'nullable|numeric|min:0',
            //'min_height_mm' => 'nullable|integer|min:0',
            //'max_height_mm' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1'
        ]);

        $price = new BacksplashPrice();

        $price->backsplash_shape_id               = $request->backsplash_shape_id ;
        $price->material_type_id                  = $request->material_type_id;
        $price->price_lm_guest                    = $request->price_lm_guest;
        $price->finished_side_price_lm_guest      = $request->finished_side_price_lm_guest;
        $price->price_lm_business                 = $request->price_lm_business;
        $price->finished_side_price_lm_business   = $request->finished_side_price_lm_business;
        //$price->min_height_mm                     = $request->min_height_mm;
        //$price->max_height_mm                     = $request->max_height_mm;
        $price->status                            = $request->status;

        $price->save();
        return redirect()->route('admin.backsplash.price.list')->with('success','Backsplash price added successfully.');
    }

    // EDIT FORM
    public function edit($id)
    {
        $data['price']         = BacksplashPrice::findOrFail($id);
        $data['materialTypes'] = MaterialType::where('status', 1)->get();
        $data['backsplashShapes'] = BacksplashShapes::where('status', 1)->get();
        return view('admin.backsplash-price.edit', $data);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $price = BacksplashPrice::findOrFail($id);

        $request->validate([
            'backsplash_shape_id' => 'required|exists:backsplash_shapes,id',
            'material_type_id' => 'required|exists:material_types,id',
            'price_lm_guest' => 'required|numeric|min:0',
            'finished_side_price_lm_guest' => 'nullable|numeric|min:0',
            'price_lm_business' => 'required|numeric|min:0',
            'finished_side_price_lm_business' => 'nullable|numeric|min:0',
           // 'min_height_mm' => 'nullable|integer|min:0',
            //'max_height_mm' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1'
        ]);

        $price->backsplash_shape_id               = $request->backsplash_shape_id;
        $price->material_type_id                  = $request->material_type_id;
        $price->price_lm_guest                    = $request->price_lm_guest;
        $price->finished_side_price_lm_guest      = $request->finished_side_price_lm_guest;
        $price->price_lm_business                 = $request->price_lm_business;
        $price->finished_side_price_lm_business   = $request->finished_side_price_lm_business;
        //$price->min_height_mm                     = $request->min_height_mm;
        //$price->max_height_mm                     = $request->max_height_mm;
        $price->status                            = $request->status;

        $price->save();
        return redirect()->route('admin.backsplash.price.list')->with('success','Backsplash price updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        $price = BacksplashPrice::findOrFail($id);
        $price->delete();

        return redirect()->route('admin.backsplash.price.list')->with('success','Backsplash price deleted successfully.');
    }
}

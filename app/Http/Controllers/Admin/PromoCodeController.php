<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PromoCode;
use Illuminate\Support\Facades\File;

class PromoCodeController extends Controller
{
    public function index(Request $request)
    {
        $query = PromoCode::orderBy('id', 'desc');

        // Paginate the Location, retain the search query on pagination
        $data['promo'] = $query->paginate(10)->withQueryString();     
        return view('admin.promo-code.index', $data);
                
    }

    //Add Promo Code
    public function create()
    {        
        return view('admin.promo-code.add');
    }
    
    //Insert Promo Code 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:promo_codes,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        
        $code = new PromoCode();

        $code->code                       = $request->code;
        $code->discount_type              = $request->discount_type;    
        $code->discount_value             = $request->discount_value;
        $code->start_date                 = $request->start_date;
        $code->end_date                   = $request->end_date;
        $code->status                     = $request->status;
        $code->status                     = $request->status;
        $code->save();    

        return redirect()->route('admin.promo.code.list')->with('success', 'Promo code added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $promo_code = PromoCode::findOrFail($id);
        return view('admin.promo-code.edit', compact('promo_code'));
    }

    // Update promo code
    public function update(Request $request, $id)
    {
        $promo_code = PromoCode::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|unique:promo_codes,code,' . $promo_code->id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        $promo_code->code           = $request->code;
        $promo_code->discount_type  = $request->discount_type;
        $promo_code->discount_value = $request->discount_value;
        $promo_code->start_date     = $request->start_date;
        $promo_code->end_date       = $request->end_date;
        $promo_code->status         = $request->status;
        $promo_code->save();

        return redirect()->route('admin.promo.code.list')->with('success', 'Promo code updated successfully!');
    }

    // Delete promo code
    public function destroy($id)
    {
        $promo_code = PromoCode::findOrFail($id);
        $promo_code->delete();
        return redirect()->route('admin.promo.code.list')->with('success', 'Promo code deleted successfully!');
    }

    

}

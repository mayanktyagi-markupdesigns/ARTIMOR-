<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Thickness;
use App\Models\Finish;

class ThicknessController extends Controller
{
    // Listing Thickness with pagination
    public function index(Request $request)
    {
        $query = Thickness::orderBy('id', 'desc');
        $data['thicknesses'] = $query->paginate(10)->withQueryString();
        return view('admin.thickness.index', $data);
    }

    // Add Thickness
    public function create()
    {
        $data['finishes'] = Finish::where('status', 1)->orderBy('finish_name')->get();
        return view('admin.thickness.add', $data);
    }    

    public function store(Request $request)
    {
        $request->validate([
            'finish_id' => 'required|exists:finishes,id',
            'thickness_value' => 'required|string|max:50',
            'is_massive' => 'boolean',
            'can_be_laminated' => 'boolean',
            'laminate_min' => 'nullable|integer',
            'laminate_max' => 'nullable|integer',
            'bussiness_price_m2' => 'required|numeric|min:0',
            'guest_price_m2' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        // If lamination not allowed, clear values
        if ($request->can_be_laminated == 0) {
            $request->merge([
                'laminate_min' => null,
                'laminate_max' => null
            ]);
        }

        Thickness::create([
            'finish_id' => $request->finish_id,
            'thickness_value' => $request->thickness_value,
            'is_massive' => $request->is_massive,
            'can_be_laminated' => $request->can_be_laminated,
            'laminate_min' => $request->laminate_min,
            'laminate_max' => $request->laminate_max,
            'bussiness_price_m2' => $request->bussiness_price_m2,
            'guest_price_m2' => $request->guest_price_m2,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.thickness.list')->with('success', 'Thickness added successfully!');
    }

    public function edit($id)
    {
        $thickness = Thickness::findOrFail($id);
        $finishes = Finish::where('status', 1)->orderBy('finish_name')->get();

        return view('admin.thickness.edit', compact('thickness', 'finishes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'finish_id'          => 'required|exists:finishes,id',
            'thickness_value'    => 'required|string|max:255',
            'is_massive'         => 'required|in:0,1',
            'can_be_laminated'   => 'required|in:0,1',
            'laminate_min'       => 'nullable|numeric',
            'laminate_max'       => 'nullable|numeric',
            'bussiness_price_m2' => 'required|numeric|min:0',
            'guest_price_m2'     => 'required|numeric|min:0',
            'status'             => 'required|in:0,1',
        ]);

        $thickness = Thickness::findOrFail($id);

        $thickness->finish_id          = $request->finish_id;
        $thickness->thickness_value    = $request->thickness_value;
        $thickness->is_massive         = $request->is_massive;
        $thickness->can_be_laminated   = $request->can_be_laminated;
        $thickness->laminate_min       = $request->can_be_laminated ? $request->laminate_min : null;
        $thickness->laminate_max       = $request->can_be_laminated ? $request->laminate_max : null;
        $thickness->bussiness_price_m2 = $request->bussiness_price_m2;
        $thickness->guest_price_m2     = $request->guest_price_m2;
        $thickness->status             = $request->status;

        $thickness->save();

        return redirect()->route('admin.thickness.list')
                        ->with('success', 'Thickness updated successfully!');
    }
    
    // Delete Thickness
    public function destroy($id)
    {
        $thickness = Thickness::findOrFail($id);
        $thickness->delete();
        return redirect()->route('admin.thickness.list')->with('success', 'Thickness deleted successfully.');
    }

    public function show($id)
    {
        $thickness = Thickness::with('finish')->findOrFail($id);
        return view('admin.thickness.show', compact('thickness'));
    }

}

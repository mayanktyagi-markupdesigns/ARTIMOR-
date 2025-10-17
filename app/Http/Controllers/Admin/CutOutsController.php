<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CutOuts;
use App\Models\CutOutsImage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class CutOutsController extends Controller
{
    public function index(Request $request)
    {
        $query = CutOuts::orderBy('id', 'desc');
        $data['outs'] = $query->paginate(10)->withQueryString();
        return view('admin.cut-outs.index', $data);
    }

    public function create()
    {
        return view('admin.cut-outs.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price'         => 'nullable|numeric|min:0',
            'series_type' => ['required', Rule::in([
                'Lorreine r series',
                'LORREINE SUPERPLUG SERIES',
                'LORREINE BLACK QUARTZ SERIES',
                'LORREINE ROYAL SERIES',
            ])],            
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpg,jpeg,png,svg|max:10240',
        ]);

        // Create cut outs record first
        $outs = CutOuts::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'series_type' => $validated['series_type'],            
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        // Ensure folder exists
        $folderPath = public_path('uploads/cut-outs');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Save each image with outs ID
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);

            CutOutsImage::create([
                'cut_out_id' => $outs->id, 
                'image' => $imageName,
                'status' => 1,
            ]);
        }

        return redirect()->route('admin.cut.outs.list')->with('success', 'Cut outs added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $outs = CutOuts::with('images')->findOrFail($id);
        return view('admin.cut-outs.edit', compact('outs'));
    }

    // Update cut outs
    public function update(Request $request, $id)
    {
        $outs = CutOuts::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price'         => 'nullable|numeric|min:0',
            'series_type' => ['required', Rule::in([
                'Lorreine r series',
                'LORREINE SUPERPLUG SERIES',
                'LORREINE BLACK QUARTZ SERIES',
                'LORREINE ROYAL SERIES',
            ])],
           'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:10240',
        ]);

        $outs->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'series_type' => $validated['series_type'],            
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        // Handle new images if uploaded
        if ($request->hasFile('images')) {
            $folderPath = public_path('uploads/cut-outs');
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($folderPath, $imageName);

                CutOutsImage::create([
                    'cut_out_id' => $outs->id, 
                    'image' => $imageName,
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('admin.cut.outs.list')->with('success', 'Cut outs updated successfully!');
    }
    
    //Show single cut-outs details (View)
    public function view($id)
    {
        $outs = CutOuts::with('images')->findOrFail($id);
        return view('admin.cut-outs.view', compact('outs'));
    }

    public function destroy($id)
    {
        $cutOut = CutOuts::with('images')->findOrFail($id);

        // Delete associated images from filesystem
        foreach ($cutOut->images as $image) {
            $imagePath = public_path('uploads/cut-outs/' . $image->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $image->delete(); // Delete image record from DB
        }
        // Delete main cutOut record
        $cutOut->delete();
        return redirect()->route('admin.cut.outs.list')->with('success', 'Cut out and associated images deleted successfully!');
    }

}

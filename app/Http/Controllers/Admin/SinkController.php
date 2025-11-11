<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sink;
use App\Models\SinkImage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\SinkCategory;
use Illuminate\Support\Facades\Storage;

class SinkController extends Controller
{
    public function index(Request $request)
    {
        $query = Sink::orderBy('id', 'desc');
        $data['sink'] = $query->paginate(10)->withQueryString();
        return view('admin.sink.index', $data);
    }

    public function create()
    {
        $data['categories'] = SinkCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.sink.add', $data);       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'user_price'         => 'required|numeric|min:0',
            'sink_categorie_id' => 'required|exists:sink_categories,id',
            'internal_dimensions' => 'nullable|string|max:255',
            'external_dimensions' => 'nullable|string|max:255',
            'depth' => 'nullable|string|max:255',
            'radius' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpg,jpeg,png,svg|max:10240',
        ]);

        // Create Sink record first
        $sink = Sink::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'user_price' => $validated['user_price'],
            'sink_categorie_id' => $validated['sink_categorie_id'],
            'internal_dimensions' => $validated['internal_dimensions'] ?? null,
            'external_dimensions' => $validated['external_dimensions'] ?? null,
            'depth' => $validated['depth'] ?? null,
            'radius' => $validated['radius'] ?? null,
            'status' => $validated['status'],
        ]);

        // Ensure folder exists
        $folderPath = public_path('uploads/sinks');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Save each image with sink_id
        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($folderPath, $imageName);

            SinkImage::create([
                'sink_id' => $sink->id, 
                'image' => $imageName,
                'status' => 1,
            ]);
        }

        return redirect()->route('admin.sink.list')->with('success', 'Sink added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $data['sink'] = Sink::with('images')->findOrFail($id); 
        $data['categories'] = SinkCategory::where('status', 1)->orderBy('name')->get();      
        $data['existingImages'] = $data['sink']->images->pluck('image')->toArray(); // ✅ Add this line
        return view('admin.sink.edit', $data);
    }

    // Update sink
    public function update(Request $request, $id)
    {
        $sink = Sink::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'user_price'         => 'required|numeric|min:0',
            'sink_categorie_id' => 'required|exists:sink_categories,id',
            'internal_dimensions' => 'nullable|string|max:255',
            'external_dimensions' => 'nullable|string|max:255',
            'depth' => 'nullable|string|max:255',
            'radius' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:10240',
        ]);

        $sink->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'user_price' => $validated['user_price'],
            'sink_categorie_id' => $validated['sink_categorie_id'],
            'internal_dimensions' => $validated['internal_dimensions'] ?? null,
            'external_dimensions' => $validated['external_dimensions'] ?? null,
            'depth' => $validated['depth'] ?? null,
            'radius' => $validated['radius'] ?? null,
            'status' => $validated['status'],
        ]);

        // Handle new images if uploaded
        if ($request->hasFile('images')) {
            $folderPath = public_path('uploads/sinks');
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($folderPath, $imageName);

                SinkImage::create([
                    'sink_id' => $sink->id,
                    'image' => $imageName,
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('admin.sink.list')->with('success', 'Sink updated successfully!');
    }
    
    //Show single sink details (View)
    public function view($id)
    {
        $sink = Sink::with('images')->findOrFail($id);
        return view('admin.sink.view', compact('sink'));
    }

    public function destroy($id)
    {
        $sink = Sink::with('images')->findOrFail($id);

        // Delete associated images from filesystem and DB
        foreach ($sink->images as $image) {
            $imagePath = public_path('uploads/sinks/' . $image->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $image->delete();
        }
        // Delete main sink record
        $sink->delete();
        return redirect()->route('admin.sink.list')->with('success', 'Sink and associated images deleted successfully!');
    }
    
}

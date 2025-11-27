<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finish;
use App\Models\Color;

class FinishController extends Controller
{
    // Listing Finish with pagination
    public function index(Request $request)
    {
        $query = Finish::orderBy('id', 'desc');
        $data['finishes'] = $query->paginate(10)->withQueryString();
        return view('admin.finish.index', $data);
    }

    // Add Finish
    public function create()
    {
        $data['color'] = Color::where('status', 1)->orderBy('name')->get();
        return view('admin.finish.add', $data);
    }

    // Insert Finish
    public function store(Request $request)
    {
        $validated = $request->validate([
            'finish_name' => 'required|string|max:255',
            'color_id' => 'required|exists:colors,id',
            'status' => 'required|in:0,1',
        ]);

        $finish = new Finish();
        $finish->finish_name = $request->finish_name;
        $finish->color_id = $request->color_id;
        $finish->status = $request->status;
        $finish->save();

        return redirect()->route('admin.finish.list')->with('success', 'Finish created successfully!');
    }


    // Delete Finish
    public function destroy($id)
    {
        $finish = Finish::findOrFail($id);
        $finish->delete();
        return redirect()->route('admin.finish.list')->with('success', 'Finish deleted successfully.');
    }

}

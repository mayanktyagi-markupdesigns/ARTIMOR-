<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\MasterProduct;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\MaterialLayout;
use App\Models\MaterialEdge;
use App\Models\MaterialCategory;
use App\Models\MaterialTypeCategory;
use App\Models\MaterialLayoutCategory;
use App\Models\BackWall;
use App\Models\SinkCategory;
use App\Models\CutOutsCategory;
use App\Models\Sink;
use App\Models\CutOuts;
use App\Models\Color;


class MasterProductController extends Controller
{
    public function index()
    {
        $data['products'] = MasterProduct::with([
                'material',
                'materialType',
                'materialLayout',
                'materialEdge',
                'backWall',
                'sink',
                'cutOut',
                'color',
            ])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.masterproduct.index', $data);
    }

    public function getMaterialsByCategory($category_id)
    {
        $materials = Material::where('material_category_id', $category_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return response()->json($materials);
    }

    public function getMaterialTypesByCategory($category_id)
    {        
        $types = MaterialType::where('material_type_category_id', $category_id)
        ->where('status', 1)
        ->orderBy('name')
        ->get(['id', 'name']);

        return response()->json($types);
    }

    public function getMaterialLayoutsByCategory($category_id)
    {
        $layouts = MaterialLayout::where('material_layout_category_id', $category_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($layouts);
    }

    public function getSinksByCategory($category_id)
    {
        $sinks = Sink::where('sink_categorie_id', $category_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($sinks);
    }

    public function getCutOutsByCategory($category_id)
    {
        $cutOuts = CutOuts::where('cut_outs_category_id', $category_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cutOuts);
    }
    
    public function create()
    {
        return view('admin.masterproduct.add', [
            'materialCategories' => MaterialCategory::where('status', 1)->orderBy('name')->get(),
            'typeCategories' => MaterialTypeCategory::where('status', 1)->orderBy('name')->get(),
            'layoutCategories' => MaterialLayoutCategory::where('status', 1)->orderBy('name')->get(),
            'edges' => MaterialEdge::where('status', 1)->orderBy('name')->get(),
            'backWalls' => BackWall::where('status', 1)->orderBy('name')->get(),
            'sinkCategories' => SinkCategory::where('status', 1)->orderBy('name')->get(),
            'cutOutsCategories' => CutOutsCategory::where('status', 1)->orderBy('name')->get(),
            'colors' => Color::where('status', 1)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'material_id' => 'required|exists:materials,id',
            'material_type_id' => 'required|exists:material_types,id',
            'material_layout_id' => 'required|exists:material_layouts,id',
            'material_edge_id' => 'required|exists:material_edges,id',
            'back_wall_id' => 'required|exists:back_walls,id',
            'sink_id' => 'required|exists:sinks,id',
            'cut_outs_id' => 'required|exists:cut_outs,id',
            'color_id' => 'required|exists:colors,id',
            'status' => 'required|in:0,1',
        ]);

        MasterProduct::create($validated);

        return redirect()->route('admin.masterproduct.list')->with('success', 'Master Product created successfully!');
    }


}
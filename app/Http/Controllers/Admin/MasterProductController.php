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


    public function edit($id)
    {
        $product = MasterProduct::with([
                'material',
                'materialType',
                'materialLayout',
                'materialEdge',
                'backWall',
                'sink',
                'cutOut',
                'color',
            ])->findOrFail($id);

        $materialCategoryId = optional($product->material)->material_category_id;
        $materialTypeCategoryId = optional($product->materialType)->material_type_category_id;
        $layoutCategoryId = optional($product->materialLayout)->material_layout_category_id;
        $sinkCategoryId = optional($product->sink)->sink_categorie_id;
        $cutOutsCategoryId = optional($product->cutOut)->cut_outs_category_id;

        $materials = $materialCategoryId
            ? Material::where('material_category_id', $materialCategoryId)->where('status', 1)->orderBy('name')->get(['id', 'name'])
            : collect();

        $materialTypes = $materialTypeCategoryId
            ? MaterialType::where('material_type_category_id', $materialTypeCategoryId)->where('status', 1)->orderBy('name')->get(['id', 'name'])
            : collect();

        $materialLayouts = $layoutCategoryId
            ? MaterialLayout::where('material_layout_category_id', $layoutCategoryId)->where('status', 1)->orderBy('name')->get(['id', 'name'])
            : collect();

        $sinks = $sinkCategoryId
            ? Sink::where('sink_categorie_id', $sinkCategoryId)->where('status', 1)->orderBy('name')->get(['id', 'name'])
            : collect();

        $cutOuts = $cutOutsCategoryId
            ? CutOuts::where('cut_outs_category_id', $cutOutsCategoryId)->where('status', 1)->orderBy('name')->get(['id', 'name'])
            : collect();

        return view('admin.masterproduct.edit', [
            'product' => $product,
            'materialCategories' => MaterialCategory::where('status', 1)->orderBy('name')->get(),
            'typeCategories' => MaterialTypeCategory::where('status', 1)->orderBy('name')->get(),
            'layoutCategories' => MaterialLayoutCategory::where('status', 1)->orderBy('name')->get(),
            'edges' => MaterialEdge::where('status', 1)->orderBy('name')->get(),
            'backWalls' => BackWall::where('status', 1)->orderBy('name')->get(),
            'sinkCategories' => SinkCategory::where('status', 1)->orderBy('name')->get(),
            'cutOutsCategories' => CutOutsCategory::where('status', 1)->orderBy('name')->get(),
            'colors' => Color::where('status', 1)->orderBy('name')->get(),
            'materials' => $materials,
            'materialTypes' => $materialTypes,
            'materialLayouts' => $materialLayouts,
            'sinks' => $sinks,
            'cutOuts' => $cutOuts,
            'selectedCategories' => [
                'material' => $materialCategoryId,
                'material_type' => $materialTypeCategoryId,
                'layout' => $layoutCategoryId,
                'sink' => $sinkCategoryId,
                'cut_outs' => $cutOutsCategoryId,
            ],
        ]);
    }


    public function update(Request $request, $id)
    {
        $product = MasterProduct::findOrFail($id);

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

        $product->update($validated);

        return redirect()->route('admin.masterproduct.list')->with('success', 'Master Product updated successfully!');
    }


    public function view($id)
    {
        $product = MasterProduct::with([
                'material.category',
                'materialType.category',
                'materialLayout.category',
                'materialEdge',
                'backWall',
                'sink.category',
                'cutOut.category',
                'color',
            ])->findOrFail($id);

        return view('admin.masterproduct.view', [
            'product' => $product,
        ]);
    }


    public function destroy($id)
    {
        $product = MasterProduct::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.masterproduct.list')->with('success', 'Master Product deleted successfully!');
    }


}
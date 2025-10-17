<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\MaterialLayout;
use App\Models\MaterialEdge;
use App\Models\BackWall;
use App\Models\Sink;
use App\Models\CutOuts;

class QuotationController extends Controller
{
    
    public function index()
    {
        $quotations = Quotation::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.quotations.index', compact('quotations'));
    }

    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Fetch related data
        $material = $quotation->material_id ? Material::find($quotation->material_id) : null;
        $materialType = $quotation->material_type_id ? MaterialType::find($quotation->material_type_id) : null;
        $layout = $quotation->layout_id ? MaterialLayout::find($quotation->layout_id) : null;
        $edge = $quotation->edge_id ? MaterialEdge::find($quotation->edge_id) : null;
        $wall = $quotation->back_wall_id ? BackWall::find($quotation->back_wall_id) : null;
        $sink = $quotation->sink_id ? Sink::with('images')->find($quotation->sink_id) : null;
        $cutout = $quotation->cutout_id ? CutOuts::with('images')->find($quotation->cutout_id) : null;

        // Decode JSON fields
        $dimensions = json_decode($quotation->dimensions, true) ?? ['blad1' => ['width' => '', 'height' => '']];
        $edgeSelectedEdges = json_decode($quotation->edge_selected_edges, true) ?? [];
        $backWallSelectedEdges = json_decode($quotation->back_wall_selected_edges, true) ?? [];

        return view('admin.quotations.view', compact(
            'quotation',
            'material',
            'materialType',
            'layout',
            'edge',
            'wall',
            'sink',
            'cutout',
            'dimensions',
            'edgeSelectedEdges',
            'backWallSelectedEdges'
        ));
    }
}

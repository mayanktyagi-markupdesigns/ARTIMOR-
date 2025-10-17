<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\MaterialLayout;
use App\Models\Dimension;
use App\Models\MaterialEdge;
use App\Models\BackWall;
use App\Models\Sink;
use App\Models\CutOuts;
use Illuminate\Support\Facades\Session;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\UserOverviewConfirmationMail;
use App\Mail\AdminOverviewNotificationMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

public function index()
{
    session(['selected_material_id' => null]);
    session(['selected_layout_id' => null]);
    session(['dimensions' => null]);
    session(['edge_finishing' => null]);
    session(['back_wall' => null]);
    session(['sink_selection' => null]);
    session(['cutout_selection' => null]);
    session(['user_details' => null]);


    $materials = Material::where('status', 1)->get();
    return view('front.index', compact('materials'));
}

public function selectMaterial(Request $request)
{
    Session::put('selected_material_id', $request->material_id);
    return response()->json(['success' => true]);
}

public function type()
{
    $materialTypes = MaterialType::where('status', 1)->get();
    return view('front.typeof', compact('materialTypes'));
}

public function selectType(Request $request)
{
    Session::put('selected_type', $request->type);
    return response()->json(['success' => true]);
}

public function layout()
{
    return view('front.layout');
}

public function getMaterials(Request $request)
{
    $type = $request->query('type');
    $materials = Material::where('material_type', str_replace('-', ' ', ucfirst($type)))->get();
    return view('front.material-content', compact('materials'))->render();
}
     

public function getCalculatorSteps(Request $request)
{
    $step = $request->input('step');

    // Store material_id in session if provided
    if ($request->has('material_id')) {
        session(['selected_material_id' => $request->input('material_id')]);
    }

    // Store layout_id in session if provided
    if ($request->has('layout_id')) {
        session(['selected_layout_id' => $request->input('layout_id')]);
    }

    // Store dimensions in session if provided
    if ($request->has('dimensions')) {
        session(['dimensions' => $request->input('dimensions')]);
    }

    // Store edge finishing data in session if provided
    if ($request->has('edge_finishing')) {
        session(['edge_finishing' => $request->input('edge_finishing')]);
    }

    // Store back wall data in session if provided
    if ($request->has('back_wall')) {
        session(['back_wall' => $request->input('back_wall')]);
    }

    // Store sink selection data in session if provided
    if ($request->has('sink_selection')) {
        session(['sink_selection' => $request->input('sink_selection')]);
    }

    // Store cut-out selection data in session if provided
    if ($request->has('cutout_selection')) {
        session(['cutout_selection' => $request->input('cutout_selection')]);
    }

    // Store user details in session if provided
    if ($request->has('user_details')) {
        session(['user_details' => $request->input('user_details')]);
        return response()->json(['success' => true]);
    }

    switch ($step) {
        case 1:
            $materials = \App\Models\Material::where('status', 1)->get();
            return view('front.index', compact('materials'))->render();
        case 2:
            $materialTypes = \App\Models\MaterialType::where('status', 1)->get();
            return view('front.typeof', compact('materialTypes'))->render();
        case 3:
            $layouts = \App\Models\MaterialLayout::where('status', 1)->get();
            return view('front.layout', compact('layouts'))->render();
        case 4:
            // Initialize dimensions in session if not set
            if (!session()->has('dimensions')) {
                session(['dimensions' => ['blad1' => ['width' => '', 'height' => '']]]);
            }
            return view('front.dimensions')->render();
        case 5:
            $edge = \App\Models\MaterialEdge::where('status', 1)->get();
            return view('front.edge-finishing', compact('edge'))->render();
        case 6:
            $wall = \App\Models\BackWall::where('status', 1)->get();
            return view('front.back-wall', compact('wall'))->render();
        case 7:
            $sinks = \App\Models\Sink::with('images')->where('status', 1)->get();
            $series = $sinks->pluck('series_type')->unique()->values();
            return view('front.sink', compact('sinks', 'series'))->render();
        case 8:
            $cutOuts = \App\Models\CutOuts::with('images')->where('status', 1)->get();
            $grouped = $cutOuts->groupBy('series_type');
            return view('front.cut-outs', compact('grouped'))->render();
        case 9:
            // Fetch data for overview
            $material = session('selected_material_id') ? \App\Models\Material::find(session('selected_material_id')) : null;
            $layout = session('selected_layout_id') ? \App\Models\MaterialLayout::find(session('selected_layout_id')) : null;
            $edge = session('edge_finishing.edge_id') ? \App\Models\MaterialEdge::find(session('edge_finishing.edge_id')) : null;
            $wall = session('back_wall.wall_id') ? \App\Models\BackWall::find(session('back_wall.wall_id')) : null;
            $sink = session('sink_selection.sink_id') ? \App\Models\Sink::with('images')->find(session('sink_selection.sink_id')) : null;
            $cutout = session('cutout_selection.cutout_id') ? \App\Models\CutOuts::with('images')->find(session('cutout_selection.cutout_id')) : null;
            return view('front.overview', compact('material', 'layout', 'edge', 'wall', 'sink', 'cutout'))->render();
        default:
            return response()->json(['error' => 'Invalid step'], 400);
    }
}

public function submitQuote(Request $request)
    {
        try {
            // Validate user details
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'delivery_option' => 'required|string|max:255',
                'measurement_time' => 'required|string|max:255',
                'promo_code' => 'nullable|string|max:50',
            ]);

            // Retrieve session data
            $materialId = session('selected_material_id');
            $materialTypeId = session('selected_material_type_id');
            $layoutId = session('selected_layout_id');
            $dimensions = session('dimensions', ['blad1' => ['width' => '', 'height' => '']]);
            $edgeFinishing = session('edge_finishing', ['edge_id' => null, 'thickness' => null, 'selected_edges' => []]);
            $backWall = session('back_wall', ['wall_id' => null, 'thickness' => null, 'selected_edges' => []]);
            $sinkSelection = session('sink_selection', ['sink_id' => null, 'cutout' => null, 'number' => null]);
            $cutoutSelection = session('cutout_selection', ['cutout_id' => null, 'recess_type' => null]);

            // Log session data for debugging
            Log::info('SubmitQuote Session Data', [
                'material_id' => $materialId,
                'material_type_id' => $materialTypeId,
                'layout_id' => $layoutId,
                'dimensions' => $dimensions,
                'edge_finishing' => $edgeFinishing,
                'back_wall' => $backWall,
                'sink_selection' => $sinkSelection,
                'cutout_selection' => $cutoutSelection,
                'user_details' => $validated,
            ]);

            // Fetch records for price calculation
            $material = Material::find($materialId);
            $materialType = MaterialType::find($materialTypeId);
            $layout = MaterialLayout::find($layoutId);
            $edge = MaterialEdge::find($edgeFinishing['edge_id']);
            $wall = BackWall::find($backWall['wall_id']);
            $sink = Sink::find($sinkSelection['sink_id']);
            $cutout = CutOuts::find($cutoutSelection['cutout_id']);

            // Calculate area in square meters
            $blad1 = isset($dimensions['blad1']) ? $dimensions['blad1'] : ['width' => '', 'height' => ''];
            $area = (!empty($blad1['width']) && !empty($blad1['height']) && is_numeric($blad1['width']) && is_numeric($blad1['height']))
                ? ($blad1['width'] * $blad1['height']) / 10000
                : 0;

            // Calculate total price
            $totalPrice = 0;
            if ($material && $material->price) {
                $totalPrice += $material->price * $area;
            }
            if ($materialType && $materialType->price) {
                $totalPrice += $materialType->price * $area;
            }
            if ($layout && $layout->price) {
                $totalPrice += $layout->price * $area;
            }
            if ($edge && $edge->price) {
                $totalPrice += $edge->price * $area;
            }
            if ($wall && $wall->price) {
                $totalPrice += $wall->price * $area;
            }
            if ($sink && $sink->price) {
                $totalPrice += $sink->price * ($sinkSelection['number'] ?? 1);
            }
            if ($cutout && $cutout->price) {
                $totalPrice += $cutout->price;
            }

            // Prepare data for saving
            $quotationData = [
                'material_id' => $materialId,
                'material_type_id' => $materialTypeId,
                'layout_id' => $layoutId,
                'dimensions' => json_encode($dimensions),
                'edge_id' => $edgeFinishing['edge_id'],
                'edge_thickness' => $edgeFinishing['thickness'],
                'edge_selected_edges' => json_encode($edgeFinishing['selected_edges']),
                'back_wall_id' => $backWall['wall_id'],
                'back_wall_thickness' => $backWall['thickness'],
                'back_wall_selected_edges' => json_encode($backWall['selected_edges']),
                'sink_id' => $sinkSelection['sink_id'],
                'sink_cutout' => $sinkSelection['cutout'],
                'sink_number' => $sinkSelection['number'],
                'cutout_id' => $cutoutSelection['cutout_id'],
                'cutout_recess_type' => $cutoutSelection['recess_type'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'],
                'delivery_option' => $validated['delivery_option'],
                'measurement_time' => $validated['measurement_time'],
                'promo_code' => $validated['promo_code'],
                'total_price' => $totalPrice,
            ];

            // Log data before saving
            Log::info('Quotation Data to Save', $quotationData);

            // Save to quotations table
            $quotation = Quotation::create($quotationData);

            // Log success
            Log::info('Quotation Saved', ['id' => $quotation->id]);

            // Clear session after saving
            session()->forget([
                'selected_material_id',
                'selected_material_type_id',
                'selected_layout_id',
                'dimensions',
                'edge_finishing',
                'back_wall',
                'sink_selection',
                'cutout_selection',
                'user_details',
            ]);

            // // Send email to user
            Mail::to($validated['email'])->send(new UserOverviewConfirmationMail($validated));

            // // Send email to admin
            Mail::to('qatest02md@gmail.com')->send(new AdminOverviewNotificationMail($validated));
            return response()->json(['success' => true, 'message' => 'Quotation submitted successfully']);
        } catch (\Exception $e) {
            Log::error('Error in submitQuote', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to submit quotation: ' . $e->getMessage()], 500);
        }
    }


    public function thankYou()
    {
        return view('front.thank-you');
        
    }
}
<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialGroup;
use App\Models\MaterialType;
use App\Models\MaterialLayout;
use App\Models\Dimension;
use App\Models\MaterialEdge;
use App\Models\BackWall;
use App\Models\SinkCategory;
use App\Models\Sink;
use App\Models\CutOuts;
use App\Models\MasterProduct;
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


    $materialStepData = $this->getMaterialPriceStepData();
    $materialStepData['selectedMaterialTypeId'] = session('selected_material_type_id');

    return view('front.index', $materialStepData);
}

// protected function getMaterialPriceStepData(): array
// {
//     $products = MasterProduct::with([
//             'material.category',
//             'materialType.category',
//             'materialLayout.category',
//         ])
//         ->where('status', 1)
//         ->whereHas('material', function ($query) {
//             $query->where('status', 1);
//         })
//         ->get();

//     $materialsByCategory = $products
//         ->filter(function ($product) {
//             return $product->material && $product->material->status == 1;
//         })
//         ->groupBy(function ($product) {
//             return optional(optional($product->material)->category)->name ?? 'Other';
//         })
//         ->map(function ($group) {
//             return $group->pluck('material')->filter()->unique('id')->values();
//         })
//         ->filter(function ($materials) {
//             return $materials->isNotEmpty();
//         });

//     $materialCategories = $materialsByCategory->keys();
//     $productsByMaterial = $products->groupBy('material_id');

//     return [
//         'materialsByCategory' => $materialsByCategory,
//         'materialCategories' => $materialCategories,
//         'productsByMaterial' => $productsByMaterial,
//         'selectedMaterialId' => session('selected_material_id'),
//         'selectedMaterialTypeId' => session('selected_material_type_id'),
//     ];
// }

protected function getMaterialPriceStepData(): array
{
    // 1. Get all active groups
   $groups = MaterialGroup::where('status', 1)
    ->with([
        'types' => function ($q) {
            $q->where('status', 1)
              ->with(['colors', 'finishes', 'thicknesses']);
        }
    ])
    ->get();
    // 2. Prepare arrays
    $materialGroups = $groups;
    $materialTypesByGroup = $groups->mapWithKeys(function ($group) {
        return [
            $group->id => $group->types
        ];
    });

    return [
        'materialGroups' => $materialGroups,
        'materialTypesByGroup' => $materialTypesByGroup,
        'selectedGroupId' => session('selected_group_id'),
        'selectedTypeId' => session('selected_type_id'),
    ];
}

protected function getMaterialTypeStepData(?int $materialId): array
{
    $selectedMaterialTypeId = session('selected_material_type_id');

    if (!$materialId) {
        return [
            'materialTypes' => collect(),
            'productsByMaterialType' => collect(),
            'selectedMaterialTypeId' => $selectedMaterialTypeId,
            'selectedMaterialId' => $materialId,
        ];
    }

    $products = MasterProduct::with([
            'materialType' => function ($query) {
                $query->where('status', 1)->with('category');
            },
            'materialLayout' => function ($query) {
                $query->where('status', 1);
            },
        ])
        ->where('status', 1)
        ->where('material_id', $materialId)
        ->whereHas('materialType', function ($query) {
            $query->where('status', 1);
        })
        ->get();

    $materialTypes = $products->pluck('materialType')->filter()->unique('id')->values();
    $productsByMaterialType = $products->groupBy('material_type_id');

    return [
        'materialTypes' => $materialTypes,
        'productsByMaterialType' => $productsByMaterialType,
        'selectedMaterialTypeId' => $selectedMaterialTypeId,
        'selectedMaterialId' => $materialId,
    ];
}

protected function getLayoutStepData(?int $materialId, ?int $materialTypeId): array
{
    $selectedLayoutId = session('selected_layout_id');

    if (!$materialId || !$materialTypeId) {
        return [
            'layoutsByType' => collect(),
            'layoutTypes' => collect(),
            'productsByLayout' => collect(),
            'selectedLayoutId' => $selectedLayoutId,
        ];
    }

    $products = MasterProduct::with([
            'material' => function ($query) {
                $query->where('status', 1);
            },
            'materialType' => function ($query) {
                $query->where('status', 1);
            },
            'materialLayout' => function ($query) {
                $query->where('status', 1)->with('category');
            },
        ])
        ->where('status', 1)
        ->where('material_id', $materialId)
        ->where('material_type_id', $materialTypeId)
        ->whereHas('material', function ($query) {
            $query->where('status', 1);
        })
        ->whereHas('materialType', function ($query) {
            $query->where('status', 1);
        })
        ->whereHas('materialLayout', function ($query) {
            $query->where('status', 1);
        })
        ->get();

    $layouts = $products->pluck('materialLayout')->filter()->unique('id')->values();

    $layoutsByType = $layouts
        ->groupBy(function ($layout) {
            return optional($layout->category)->name ?? 'Other';
        })
        ->sortKeys();

    $layoutTypes = $layoutsByType->keys();
    $productsByLayout = $products->groupBy('material_layout_id');

    return [
        'layoutsByType' => $layoutsByType,
        'layoutTypes' => $layoutTypes,
        'productsByLayout' => $productsByLayout,
        'selectedLayoutId' => $selectedLayoutId,
    ];
}

protected function getEdgeStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    if (!$materialId || !$materialTypeId || !$layoutId) {
        return collect();
    }

    $products = MasterProduct::with([
            'materialEdge' => function ($query) {
                $query->where('status', 1);
            },
        ])
        ->where('status', 1)
        ->where('material_id', $materialId)
        ->where('material_type_id', $materialTypeId)
        ->where('material_layout_id', $layoutId)
        ->whereHas('materialEdge', function ($query) {
            $query->where('status', 1);
        })
        ->get();

    return $products->pluck('materialEdge')->filter()->unique('id')->values();
}

protected function getBackWallStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    if (!$materialId || !$materialTypeId || !$layoutId) {
        return collect();
    }

    $products = MasterProduct::with([
            'backWall' => function ($query) {
                $query->where('status', 1);
            },
        ])
        ->where('status', 1)
        ->where('material_id', $materialId)
        ->where('material_type_id', $materialTypeId)
        ->where('material_layout_id', $layoutId)
        ->whereHas('backWall', function ($query) {
            $query->where('status', 1);
        })
        ->get();

    return $products->pluck('backWall')->filter()->unique('id')->values();
}

protected function getSinkStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    if (!$materialId || !$materialTypeId || !$layoutId) {
        return collect();
    }

    $products = MasterProduct::with([
            'sink' => function ($query) {
                $query->where('status', 1)->with(['category', 'images']);
            },
        ])
        ->where('status', 1)
        ->where('material_id', $materialId)
        ->where('material_type_id', $materialTypeId)
        ->where('material_layout_id', $layoutId)
        ->whereHas('sink', function ($query) {
            $query->where('status', 1);
        })
        ->get();

    $sinks = $products->pluck('sink')->filter()->unique('id')->values();
    // Re-fetch unique sinks with relations to avoid losing eager loads after pluck/unique
    if ($sinks->isEmpty()) {
        return $sinks;
    }
    $uniqueSinkIds = $sinks->pluck('id')->filter()->unique()->values();
    return Sink::with(['category', 'images'])->whereIn('id', $uniqueSinkIds)->get();
}

protected function getCutOutsStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    if (!$materialId || !$materialTypeId || !$layoutId) {
        return collect();
    }

    $products = MasterProduct::with([
            'cutOut' => function ($query) {
                $query->where('status', 1)->with(['category', 'images']);
            },
        ])
        ->where('status', 1)
        ->where('material_id', $materialId)
        ->where('material_type_id', $materialTypeId)
        ->where('material_layout_id', $layoutId)
        ->whereHas('cutOut', function ($query) {
            $query->where('status', 1);
        })
        ->get();

    return $products->pluck('cutOut')->filter()->unique('id')->values();
}

public function selectMaterial(Request $request)
{
    Session::put('selected_material_id', $request->material_id);
    Session::put('selected_material_type_id', null);
    Session::put('selected_layout_id', null);
    Session::put('edge_finishing', null);
    Session::put('back_wall', null);
    Session::put('sink_selection', null);
    return response()->json(['success' => true]);
}

public function type()
{
    $selectedMaterialId = session('selected_material_id');
    $typeStepData = $this->getMaterialTypeStepData($selectedMaterialId);
    return view('front.typeof', $typeStepData);
}

public function selectType(Request $request)
{
    Session::put('selected_material_type_id', $request->type_id);
    Session::put('selected_layout_id', null);
    Session::put('edge_finishing', null);
    Session::put('back_wall', null);
    Session::put('sink_selection', null);
    return response()->json(['success' => true]);
}

public function layout()
{
    $selectedMaterialId = session('selected_material_id');
    $selectedMaterialTypeId = session('selected_material_type_id');
    $layoutStepData = $this->getLayoutStepData($selectedMaterialId, $selectedMaterialTypeId);

    return view('front.layout', $layoutStepData);
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
    //dd($request);
    // Store material_id in session if provided
    if ($request->has('material_id')) {
        $newMaterialId = $request->input('material_id');
        $previousMaterialId = session('selected_material_id');
        if ($previousMaterialId && (string)$previousMaterialId !== (string)$newMaterialId) {
            session([
                'selected_material_type_id' => null,
                'selected_layout_id' => null,
            ]);
        }
        session(['selected_material_id' => $newMaterialId]);
    }

    // Store material_type_id in session if provided
    if ($request->has('material_type_id')) {
        $newMaterialTypeId = $request->input('material_type_id');
        $previousMaterialTypeId = session('selected_material_type_id');
        if ($previousMaterialTypeId && (string)$previousMaterialTypeId !== (string)$newMaterialTypeId) {
            session([
                'selected_layout_id' => null,
                'edge_finishing' => null,
                'back_wall' => null,
                'sink_selection' => null,
            ]);
        }
        session(['selected_material_type_id' => $newMaterialTypeId]);
    }

    // Store layout_id in session if provided
    if ($request->has('layout_id')) {
        session([
            'selected_layout_id' => $request->input('layout_id'),
            'edge_finishing' => null,
            'back_wall' => null,
            'sink_selection' => null,
        ]);
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
            $materialStepData = $this->getMaterialPriceStepData();
            return view('front.partials.material-price', $materialStepData)->render();
        case 2:
            $selectedMaterialId = session('selected_material_id');
            $selectedMaterialTypeId = session('selected_material_type_id');
            $layoutStepData = $this->getLayoutStepData($selectedMaterialId, $selectedMaterialTypeId);
            
            return view('front.layout', $layoutStepData)->render();
        case 3:
            // Initialize dimensions in session if not set
            if (!session()->has('dimensions')) {
                session(['dimensions' => ['blad1' => ['width' => '', 'height' => '']]]);
            }
            return view('front.dimensions')->render();
        case 4:
            $selectedMaterialId = session('selected_material_id');
            $selectedMaterialTypeId = session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            $edge = $this->getEdgeStepData($selectedMaterialId, $selectedMaterialTypeId, $selectedLayoutId);
            return view('front.edge-finishing', compact('edge'))->render();
        case 5:
            $selectedMaterialId = session('selected_material_id');
            $selectedMaterialTypeId = session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            $wall = $this->getBackWallStepData($selectedMaterialId, $selectedMaterialTypeId, $selectedLayoutId);
            return view('front.back-wall', compact('wall'))->render();
        case 6:
            $selectedMaterialId = session('selected_material_id');
            $selectedMaterialTypeId = session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            $sinks = $this->getSinkStepData($selectedMaterialId, $selectedMaterialTypeId, $selectedLayoutId);
            return view('front.sink', compact('sinks'))->render();
        case 7:
            $selectedMaterialId = session('selected_material_id');
            $selectedMaterialTypeId = session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            $cutOuts = $this->getCutOutsStepData($selectedMaterialId, $selectedMaterialTypeId, $selectedLayoutId);
            // Group cut-outs by category name with fallback to 'Other'
            $grouped = $cutOuts->groupBy(function ($cutout) {
                return optional($cutout->category)->name ?: 'Other';
            });
            return view('front.cut-outs', compact('grouped'))->render();
        case 8:
            // Fetch data for overview
            $material = session('selected_material_id') ? \App\Models\Material::find(session('selected_material_id')) : null;
            $layout = session('selected_layout_id') ? \App\Models\MaterialLayout::find(session('selected_layout_id')) : null;
            $edge = session('edge_finishing.edge_id') ? \App\Models\MaterialEdge::find(session('edge_finishing.edge_id')) : null;
            $wall = session('back_wall.wall_id') ? \App\Models\BackWall::find(session('back_wall.wall_id')) : null;
            $sink = session('sink_selection.sink_id') ? \App\Models\Sink::with(['images', 'category'])->find(session('sink_selection.sink_id')) : null;
            $cutout = session('cutout_selection.cutout_id') ? \App\Models\CutOuts::with(['images', 'category'])->find(session('cutout_selection.cutout_id')) : null;
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

            //Send email to user
            Mail::to($validated['email'])->send(new UserOverviewConfirmationMail($validated));

            //Send email to admin
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
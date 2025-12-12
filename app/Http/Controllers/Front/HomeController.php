<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialGroup;
use App\Models\MaterialType;
use App\Models\MaterialLayout;
use App\Models\MaterialLayoutShape;
use App\Models\Dimension;
use App\Models\MaterialEdge;
use App\Models\BackWall;
use App\Models\SinkCategory;
use App\Models\Sink;
use App\Models\CutOuts;
use Illuminate\Support\Facades\Session;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\UserOverviewConfirmationMail;
use App\Mail\AdminOverviewNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\EdgeProfileThicknessRule;

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
    $materialCategories = $groups;
    $materialsByCategory = $groups->mapWithKeys(function ($group) {
        return [
            $group->id => $group->types
        ];
    });

    return [
        'materialCategories' => $materialCategories,
        'materialsByCategory' => $materialsByCategory,
        'selectedMaterialId' => session('selected_material_id'),
        'selectedMaterialTypeId' => session('selected_material_type_id'),
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

    // 1. Load categories with groups & shapes
    $categories = \App\Models\MaterialLayoutCategory::with([
        'groups' => function ($q) {
            $q->where('status', 1)->with([
                'shapes' => function ($q2) {
                    $q2->where('status', 1);
                }
            ]);
        }
    ])
    ->where('status', 1)
    ->get();

    // 2. Build layoutsByType as: Category Name => Category Model
    $layoutsByType = collect();

    foreach ($categories as $category) {
        if ($category->groups->isNotEmpty()) {
            $layoutsByType[$category->name ?? 'Other'] = $category;
        }
    }

    // THIS WAS MISSING (VERY IMPORTANT)
    $layoutTypes = $layoutsByType->keys();

    // 3. Fake productsByLayout (kept for blade compatibility)
    $productsByLayout = collect();
    foreach ($layoutsByType as $category) {
        foreach ($category->groups as $group) {
            foreach ($group->shapes as $layout) {
                $productsByLayout[$layout->id] = collect([$layout]);
            }
        }
    }

    // 4. Return ALL required variables
    return [
        'layoutsByType'     => $layoutsByType,
        'layoutTypes'      => $layoutTypes,     // ✅ REQUIRED BY TABS
        'productsByLayout' => $productsByLayout,
        'selectedLayoutId' => $selectedLayoutId,
    ];
}


protected function getEdgeStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    // If materialTypeId and layoutId are provided, return edge profiles
    // For now, return all active edge profiles
    if (!$materialTypeId || !$layoutId) {
        return collect();
    }

    // Return all active edge profiles
    return \App\Models\EdgeProfile::where('status', 1)->get();
}

protected function getBackWallStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    // Return all active backsplash shapes
    return \App\Models\BacksplashShapes::where('status', 1)->orderBy('sort_order')->get();
}

protected function getSinkStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    // If materialTypeId and layoutId are provided, return sinks
    if (!$materialTypeId || !$layoutId) {
        return collect();
    }

    // Return all active sinks
    return Sink::with(['category', 'images'])->where('status', 1)->get();
}

protected function getCutOutsStepData(?int $materialId, ?int $materialTypeId, ?int $layoutId)
{
    // If materialTypeId and layoutId are provided, return cutouts
    if (!$materialTypeId || !$layoutId) {
        return collect();
    }

    // Return all active cutouts
    return CutOuts::with(['category', 'images'])->where('status', 1)->get();
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
    // Accept both JSON payload and normal form-encoded payloads
    $data = $request->isJson() ? $request->json()->all() : $request->all();
    $step = $data['step'] ?? null;
    
    if (isset($data['material_config'])) {
        $newConfig = $data['material_config'];

        // If config changed, reset dependent steps
        $previousConfig = session('material_config', null);
        if ($previousConfig !== $newConfig) {
            session([
                'selected_layout_id' => null,
                'dimensions' => null,
                'edge_finishing' => null,
                'back_wall' => null,
                'sink_selection' => null,
                'cutout_selection' => null,
            ]);
        }

        // Save config + ensure selected_material_type_id remains in sync for compatibility
        session([
            'material_config' => $newConfig,
            'selected_material_type_id' => $newConfig['material_type_id'] ?? null,
        ]);
    }

    // ------------------------
    // Backwards-compatible: material_id (optional / deprecated)
    // ------------------------
    if (isset($data['material_id']) && !isset($data['material_config'])) {
        $newMaterialId = $data['material_id'];
        $previousMaterialId = session('selected_material_id');

        if ($previousMaterialId && (string)$previousMaterialId !== (string)$newMaterialId) {
            session([
                'selected_material_type_id' => null,
                'selected_layout_id' => null,
            ]);
        }

        session(['selected_material_id' => $newMaterialId]);
    }

    // ------------------------
    // Backwards-compatible: material_type_id (optional)
    // ------------------------
    if (isset($data['material_type_id']) && !isset($data['material_config'])) {
        $newMaterialTypeId = $data['material_type_id'];
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

    // layout id
    if (isset($data['layout_id'])) {
        session([
            'selected_layout_id' => $data['layout_id'],
            'edge_finishing' => null,
            'back_wall' => null,
            'sink_selection' => null,
        ]);
    }

    // dimensions
    if (isset($data['dimensions'])) {
        session(['dimensions' => $data['dimensions']]);
    }

    // edge finishing
    if (isset($data['edge_finishing'])) {
        session(['edge_finishing' => $data['edge_finishing']]);
    }

    // back wall
    if (isset($data['back_wall'])) {
        session(['back_wall' => $data['back_wall']]);
    }

    // sink selection
    if (isset($data['sink_selection'])) {
        session(['sink_selection' => $data['sink_selection']]);
    }

    // cutout selection
    if (isset($data['cutout_selection'])) {
        session(['cutout_selection' => $data['cutout_selection']]);
    }

    // user details (final save)
    if (isset($data['user_details'])) {
        session(['user_details' => $data['user_details']]);
        return response()->json(['success' => true]);
    }

    // ------------------------
    // Render steps
    // ------------------------
    switch ($step) {
        case 1:
            $materialStepData = $this->getMaterialPriceStepData();
            return view('front.partials.material-price', $materialStepData)->render();

        case 2:
            // IMPORTANT: prefer material_config -> material_type_id, fallback to old session key
            $materialConfig = session('material_config', []);
            $selectedMaterialTypeId = $materialConfig['material_type_id'] ?? session('selected_material_type_id');
            // call getLayoutStepData with materialType (we don't require material_id anymore)
            $layoutStepData = $this->getLayoutStepData(null, $selectedMaterialTypeId);
            return view('front.layout', $layoutStepData)->render();

        case 3:
            if (!session()->has('dimensions')) {
                session(['dimensions' => ['blad1' => ['width' => '', 'height' => '']]]);
            }
            return view('front.dimensions')->render();

        case 4:
            $materialConfig = session('material_config', []);
            $selectedMaterialTypeId = $materialConfig['material_type_id'] ?? session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            
            // Get all edge profiles
            $edgeProfiles = \App\Models\EdgeProfile::where('status', 1)->orderBy('name')->get();

            // Get all color based on material type, ignoring edge_id
            $colors = \App\Models\MaterialColorEdgeException::where('status', 1)
                ->with('color')
                ->get()
                ->pluck('color')
                ->filter(fn($t) => $t && $t->status == 1)
                ->unique('name') // remove duplicates by value
                ->values();

            // Get all thickness based on material type, ignoring edge_id
            $thickness = \App\Models\EdgeProfileThicknessRule::where('status', 1)
                ->with('thickness')
                ->get()
                ->pluck('thickness')
                ->filter(fn($t) => $t && $t->status == 1)
                ->unique('thickness_value') // remove duplicates by value
                ->values();

            
            // Get edge finishing from session
            $edgeFinishing = session('edge_finishing', [
                'edge_id' => null,
                'thickness_id' => null,
                'color_id' => null,
                'selected_edges' => []
            ]);
            
            return view('front.edge-finishing', compact('edgeProfiles', 'selectedMaterialTypeId', 'edgeFinishing', 'colors', 'thickness'))->render();

        case 5:
            $materialConfig = session('material_config', []);
            $selectedMaterialTypeId = $materialConfig['material_type_id'] ?? session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            $wall = $this->getBackWallStepData(null, $selectedMaterialTypeId, $selectedLayoutId);
            return view('front.back-wall', compact('wall'))->render();

        case 6:
            $materialConfig = session('material_config', []);
            $selectedMaterialTypeId = $materialConfig['material_type_id'] ?? session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            $sinks = $this->getSinkStepData(null, $selectedMaterialTypeId, $selectedLayoutId);
            return view('front.sink', compact('sinks'))->render();

        case 7:
            $materialConfig = session('material_config', []);
            $selectedMaterialTypeId = $materialConfig['material_type_id'] ?? session('selected_material_type_id');
            $selectedLayoutId = session('selected_layout_id');
            $cutOuts = $this->getCutOutsStepData(null, $selectedMaterialTypeId, $selectedLayoutId);
            $grouped = $cutOuts->groupBy(function ($cutout) {
                return optional($cutout->category)->name ?: 'Other';
            });
            return view('front.cut-outs', compact('grouped'))->render();

        case 8:
        // Overview: read from material_config (preferred) or fall back to legacy keys
        $materialConfig = session('material_config', null);
        $materialType = !empty($materialConfig['material_type_id'])
            ? \App\Models\MaterialType::find($materialConfig['material_type_id'])
            : (session('selected_material_type_id') ? \App\Models\MaterialType::find(session('selected_material_type_id')) : null);

        $layout = session('selected_layout_id') ? \App\Models\MaterialLayoutShape::find(session('selected_layout_id')) : null;

        // Edge removed
        $edge = null; // session('edge_finishing.edge_id') ? \App\Models\MaterialEdge::find(session('edge_finishing.edge_id')) : null;

        $wall = session('back_wall.wall_id') ? \App\Models\BacksplashShapes::find(session('back_wall.wall_id')) : null;
        $sink = session('sink_selection.sink_id') ? \App\Models\Sink::with(['images', 'category'])->find(session('sink_selection.sink_id')) : null;
        $cutout = session('cutout_selection.cutout_id') ? \App\Models\CutOuts::with(['images', 'category'])->find(session('cutout_selection.cutout_id')) : null;

        return view('front.overview', compact('materialType', 'layout', 'edge', 'wall', 'sink', 'cutout'))->render();


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
            $layout = MaterialLayoutShape::find($layoutId);
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

    /**
     * Get thicknesses for edge profile based on material type
     */
    public function getEdgeThicknesses(Request $request)
    {
        $edgeProfileId = $request->get('edge_profile_id');
        $materialTypeId = $request->get('material_type_id');
        
        if (!$edgeProfileId || !$materialTypeId) {
            return response()->json(['thicknesses' => []]);
        }

        // Get thicknesses from edge_profile_thickness_rules
        $rules = \App\Models\EdgeProfileThicknessRule::where('edge_profile_id', $edgeProfileId)
            ->where('material_type_id', $materialTypeId)
            ->where('is_allowed', true)
            ->where('status', 1)
            ->with('thickness')
            ->get();

        $thicknesses = $rules->map(function ($rule) {
            return [
                'id' => $rule->thickness_id,
                'value' => $rule->thickness->thickness_value ?? '',
                'price_per_lm_guest' => $rule->price_per_lm_guest,
                'price_per_lm_business' => $rule->price_per_lm_business,
            ];
        })->filter(function ($item) {
            return !empty($item['value']);
        })->values();

        return response()->json(['thicknesses' => $thicknesses]);
    }

    /**
     * Get colors for edge profile based on material type and thickness
     */
    public function getEdgeColors(Request $request)
    {
        $edgeProfileId = $request->get('edge_profile_id');
        $materialTypeId = $request->get('material_type_id');
        $thicknessId = $request->get('thickness_id');
        
        if (!$edgeProfileId || !$materialTypeId || !$thicknessId) {
            return response()->json(['colors' => []]);
        }

        // Get colors from material_color_edge_exceptions
        $exceptions = \App\Models\MaterialColorEdgeException::where('edge_profile_id', $edgeProfileId)
            ->where('material_type_id', $materialTypeId)
            ->where('thickness_id', $thicknessId)
            ->where('is_allowed', true)
            ->where('status', 1)
            ->with('color')
            ->get();

        $colors = $exceptions->map(function ($exception) {
            return [
                'id' => $exception->color_id,
                'name' => $exception->color->name ?? '',
                'override_price' => $exception->override_price_per_lm,
            ];
        })->filter(function ($item) {
            return !empty($item['name']);
        })->values();

        return response()->json(['colors' => $colors]);
    }
}
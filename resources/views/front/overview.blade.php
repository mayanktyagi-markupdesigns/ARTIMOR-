@php
    // Session data
    $materialConfig   = session('material_config', []);
    $layoutId         = session('selected_layout_id');
    $dimensions       = session('dimensions', []);
    $edgeFinishing    = session('edge_finishing', []);
    $backWall         = session('back_wall', []);
    $sinkSelection    = session('sink_selection', []);
    $cutoutSelection  = session('cutout_selection', []);

    // Fetch selected database records
    $materialType   = $materialConfig['material_type_id'] ? \App\Models\MaterialType::find($materialConfig['material_type_id']) : null;
    $color          = $materialConfig['color'] ? \App\Models\Color::find($materialConfig['color']) : null;
    $finish         = $materialConfig['finish'] ? \App\Models\Finish::find($materialConfig['finish']) : null;
    $thickness      = $materialConfig['thickness'] ? \App\Models\Thickness::find($materialConfig['thickness']) : null;

    $layout         = $layoutId ? \App\Models\MaterialLayoutShape::find($layoutId) : null;
    $edgeProfile    = $edgeFinishing['edge_id'] ?? null ? \App\Models\EdgeProfile::find($edgeFinishing['edge_id']) : null;
    $edgeThickness  = $edgeFinishing['thickness_id'] ?? null ? \App\Models\Thickness::find($edgeFinishing['thickness_id']) : null;
    $edgeColor      = $edgeFinishing['color_id'] ?? null ? \App\Models\Color::find($edgeFinishing['color_id']) : null;

    $backsplash     = $backWall['wall_id'] ?? null ? \App\Models\BacksplashShapes::find($backWall['wall_id']) : null;
    $sink           = $sinkSelection['sink_id'] ?? null ? \App\Models\Sink::find($sinkSelection['sink_id']) : null;
    $cutout         = $cutoutSelection['cutout_id'] ?? null ? \App\Models\CutOuts::find($cutoutSelection['cutout_id']) : null;

    // Dimensions
    $blad1 = $dimensions['blad1'] ?? ['width' => 0, 'height' => 0];
    $area = ($blad1['width'] && $blad1['height']) ? ($blad1['width'] * $blad1['height']) / 10000 : 0; // in m²
@endphp

<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold">Your Selected Configuration</h2>

    <div class="row g-5">
        <!-- Left: Selected Items -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 p-4">

                {{-- Material --}}
                @if($materialType)
                    <h5 class="fw-bold text-primary mb-3">Material & Finish</h5>
                    <div class="row align-items-center mb-4">
                        <div class="col-3 text-center">
                            <img src="{{ asset('uploads/material-type/' . ($materialType->image ?? 'default.jpg')) }}" class="img-fluid rounded" style="max-height:100px;">
                        </div>
                        <div class="col-9">
                            <p><strong>Type:</strong> {{ $materialType->name }}</p>
                            <p><strong>Color:</strong> {{ $color?->name ?? '—' }}</p>
                            <p><strong>Finish:</strong> {{ $finish?->finish_name ?? '—' }}</p>
                            <p><strong>Thickness:</strong> {{ $thickness?->thickness_value ?? '—' }}</p>
                        </div>
                    </div>
                @endif

                {{-- Layout --}}
                @if($layout)
                    <h5 class="fw-bold text-primary mb-3">Layout</h5>
                    <div class="text-center mb-4">
                        <img src="{{ asset('uploads/layout-shapes/' . ($layout->image ?? 'default.jpg')) }}" class="img-fluid rounded" style="max-height:120px;">
                        <p class="fw-bold mt-2">{{ $layout->name }}</p>
                    </div>
                @endif

                {{-- Dimensions --}}
                @if($blad1['width'] && $blad1['height'])
                    <h5 class="fw-bold text-primary mb-3">Dimensions (Blad 01)</h5>
                    <p><strong>Width:</strong> {{ $blad1['width'] }} cm</p>
                    <p><strong>Height:</strong> {{ $blad1['height'] }} cm</p>
                    <p class="fw-bold text-success">Total Area: {{ number_format($area,3) }} m²</p>
                @endif

                {{-- Edge Finishing --}}
                @if($edgeProfile)
                    <h5 class="fw-bold text-primary mb-3">Edge Finishing</h5>
                    <p><strong>Profile:</strong> {{ $edgeProfile->name }}</p>
                    <p><strong>Thickness:</strong> {{ $edgeThickness?->thickness_value ?? '—' }}</p>
                    <p><strong>Color:</strong> {{ $edgeColor?->name ?? '—' }}</p>
                    <p><strong>Selected Edges:</strong> 
                        @if(!empty($edgeFinishing['selected_edges']))
                            {{ implode(', ', array_map('ucfirst', $edgeFinishing['selected_edges'])) }}
                        @else
                            Standard (Green edges)
                        @endif
                    </p>
                @endif

                {{-- Back Wall --}}
                @if($backsplash)
                    <h5 class="fw-bold text-primary mb-3">Back Wall / Backsplash</h5>
                    <div class="text-center mb-2">
                        <img src="{{ asset('uploads/backsplash-shape/' . ($backsplash->image ?? 'default.jpg')) }}" class="img-fluid rounded" style="max-height:120px;">
                    </div>
                    <p class="fw-bold text-center">{{ $backsplash->name }}</p>
                    @if(!empty($backWall['selected_edges']))
                        <p><strong>Finished Sides:</strong> {{ implode(', ', array_map('ucfirst', $backWall['selected_edges'])) }}</p>
                    @endif
                @endif

                {{-- Sink --}}
                @if($sink)
                    <h5 class="fw-bold text-primary mb-3">Sink</h5>
                    <div class="row align-items-center mb-4">
                        <div class="col-4 text-center">
                            <img src="{{ asset('uploads/sinks/' . ($sink->images->first()->image ?? 'default.jpg')) }}" class="img-fluid rounded" style="max-height:80px;">
                        </div>
                        <div class="col-8">
                            <p class="fw-bold">{{ $sink->name }}</p>
                            <p><strong>Cutout:</strong> {{ ucfirst(str_replace('_',' ',$sinkSelection['cutout'] ?? '')) }}</p>
                            <p><strong>Quantity:</strong> {{ $sinkSelection['number'] ?? 1 }}</p>
                        </div>
                    </div>
                @endif

                {{-- Cutout --}}
                @if($cutout)
                    <h5 class="fw-bold text-primary mb-3">Cutout / Hob</h5>
                    <div class="row align-items-center">
                        <div class="col-4 text-center">
                            <img src="{{ asset('uploads/cut-outs/' . ($cutout->images->first()->image ?? 'default.jpg')) }}" class="img-fluid rounded" style="max-height:80px;">
                        </div>
                        <div class="col-8">
                            <p class="fw-bold">{{ $cutout->name }}</p>
                            <p><strong>Recess Type:</strong> {{ ucfirst($cutoutSelection['recess_type'] ?? '') }}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- Right: User Form (unchanged) --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Complete Your Request</h5>
                </div>
                <div class="card-body">
                    {{-- Your existing form code here --}}
                </div>
            </div>
        </div>
    </div>
</div>

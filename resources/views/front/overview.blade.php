@php

$userDetails = session('user_details', [
    'first_name' => '',
    'last_name' => '',
    'phone_number' => '',
    'email' => '',
    'delivery_option' => '',
    'measurement_time' => '',
    'promo_code' => ''
]);

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

<div class="materials bg-white">
    <!-- Nav Tabs -->
    <div class="d-flex align-items-center justify-content-center">
        <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="personaldata-tab" data-bs-toggle="tab"
                    data-bs-target="#personaldata" type="button" role="tab">Personal Data</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button"
                    role="tab">Overview</button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="materialsTabContent">
        <!-- Personal Data Tab -->
        <div class="tab-pane fade show active" id="personaldata" role="tabpanel" aria-labelledby="personaldata-tab">
            <div class="row">
                <div class="col-lg-5">
                    <figure class="pb-5">
                        <img class="img-fluid" src="{{ asset('assets/front/img/image2-home1.jpg') }}"
                            alt="Personal Data" />
                    </figure>
                </div>
                <div class="col-lg-7 pt-5 d-flex">
                    <div class="verticale-lign"></div>
                    <form action="#" method="POST" class="pb-5 ps-0 ps-md-5 custom-form" id="customForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-5 position-relative">
                                <div class="inputfild-box">
                                    <label class="form-label">First Name<sup>*</sup></label>
                                    <input type="text" id="firstName" name="first_name" class="form-control"
                                        placeholder="e.g. Johan" value="" required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-5 position-relative">
                                <div class="inputfild-box">
                                    <label class="form-label">Last Name<sup>*</sup></label>
                                    <input type="text" id="lastName" name="last_name" class="form-control"
                                        placeholder="e.g. Sans" value="" required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-5 position-relative">
                                <div class="inputfild-box">
                                    <label class="form-label">Phone Number<sup>*</sup></label>
                                    <input type="text" id="phoneNumber" name="phone_number" class="form-control"
                                        placeholder="e.g. +32 4 9720 4041" value=""
                                        required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-5 position-relative">
                                <div class="inputfild-box">
                                    <label class="form-label">Email ID<sup>*</sup></label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="e.g. Johan@artimordesgns.com" value=""
                                        required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-5 position-relative">
                                <div class="inputfild-box">
                                    <label class="form-label">Delivery/Installation<sup>*</sup></label>
                                    <select class="form-select" id="deliveryOption" name="delivery_option" required>
                                        <option value="">Select the option</option>
                                        <option value="square">
                                            Square
                                        </option>
                                        <option value="round">
                                            Round
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5 position-relative">
                                <div class="inputfild-box">
                                    <label class="form-label">Estimated Time For Measurement<sup>*</sup></label>
                                    <select class="form-select" id="measurementTime" name="measurement_time" required>
                                        <option value="">Select the option</option>
                                        <option value="square">
                                            Square
                                        </option>
                                        <option value="round">
                                            Round
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5 position-relative">
                                <div class="inputfild-box">
                                    <label class="form-label">Promo Code</label>
                                    <input type="text" id="promoCode" name="promo_code" class="form-control"
                                        placeholder="Write your coupon code" value="" />
                                </div>
                            </div>
                            <div class="text-center my-5 d-flex align-items-center justify-content-start gap-4">
                                <button type="submit" class="btn btn-dark btn-primary px-4">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quotation Overview -->
            <div class="row">
                <div class="col-md-12">
                    <div class="result-box">
                        <!-- Material -->
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
            </div>
        </div>

        <!-- Overview Tab -->
        <div class="tab-pane fade" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row">
                <div class="col-md-12">
                    <h3>Summary of Your Selections</h3>
                    <p>This section provides a comprehensive overview of all your selections made during the configuration process.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.result-box {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.result-head h3 {
    margin-bottom: 10px;
    font-weight: bold;
}

.result-gride {
    align-items: flex-start;
}

.inputfild-box {
    margin-bottom: 15px;
}

.inputfild-box label {
    font-weight: 500;
}

.form-control,
.form-select {
    border-radius: 4px;
}
</style>
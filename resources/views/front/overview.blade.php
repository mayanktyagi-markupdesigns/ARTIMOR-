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
$materialConfig = session('material_config', []);
$layoutId = session('selected_layout_id');
$dimensions = session('dimensions', []);
$edgeFinishing = session('edge_finishing', []);
$backWall = session('back_wall', []);
$sinkSelection = session('sink_selection', []);
$cutoutSelection = session('cutout_selection', []);

// Fetch selected database records
$materialType = $materialConfig['material_type_id'] ?
\App\Models\MaterialType::find($materialConfig['material_type_id']) : null;
$color = $materialConfig['color'] ? \App\Models\Color::find($materialConfig['color']) : null;
$finish = $materialConfig['finish'] ? \App\Models\Finish::find($materialConfig['finish']) : null;
$thickness = $materialConfig['thickness'] ? \App\Models\Thickness::find($materialConfig['thickness']) : null;

$layout = $layoutId ? \App\Models\MaterialLayoutShape::find($layoutId) : null;
$edgeProfile = $edgeFinishing['edge_id'] ?? null ? \App\Models\EdgeProfile::find($edgeFinishing['edge_id']) : null;
$edgeThickness = $edgeFinishing['thickness_id'] ?? null ? \App\Models\Thickness::find($edgeFinishing['thickness_id']) :
null;
$edgeColor = $edgeFinishing['color_id'] ?? null ? \App\Models\Color::find($edgeFinishing['color_id']) : null;

$backsplash = $backWall['wall_id'] ?? null ? \App\Models\BacksplashShapes::find($backWall['wall_id']) : null;
$sink = $sinkSelection['sink_id'] ?? null ? \App\Models\Sink::find($sinkSelection['sink_id']) : null;
$cutout = $cutoutSelection['cutout_id'] ?? null ? \App\Models\CutOuts::find($cutoutSelection['cutout_id']) : null;

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
            <form action="{{ route('calculator.submit') }}" method="POST" class="pb-5 ps-0 ps-md-5 custom-form"
                id="customForm">
                @csrf
                <div class="row">
                    <div class="col-lg-5">
                        <figure class="pb-5">
                            <img class="img-fluid" src="{{ asset('assets/front/img/image2-home1.jpg') }}"
                                alt="Personal Data" />
                        </figure>
                    </div>
                    <div class="col-lg-7 pt-5 d-flex">
                        <div class="verticale-lign"></div>
                        <div class="w-100">
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
                                            placeholder="e.g. +32 4 9720 4041" value="" required />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 position-relative">
                                    <div class="inputfild-box">
                                        <label class="form-label">Email ID<sup>*</sup></label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="e.g. Johan@artimordesgns.com" value="" required />
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
                                        <select class="form-select" id="measurementTime" name="measurement_time"
                                            required>
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quotation Overview -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="result-box">
                            {{-- Material --}}
                            @if($materialType)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Material <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        @if($materialType->image)
                                        <figure class="me-4">
                                            <img width="160"
                                                src="{{ asset('uploads/material-type/' . ($materialType->image ?? 'default.jpg')) }}"
                                                alt="" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Type:</strong> {{ $materialType->name }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Color:</strong> {{ $color?->name ?? '—' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Finish:</strong> {{ $finish?->finish_name ?? '—' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Thickness:</strong> {{ $thickness?->thickness_value ?? '—' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Layout -->
                            @if($layout)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Layout <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        @if($layout->image)
                                        <figure class="me-4">
                                            <img width="160"
                                                src="{{ asset('uploads/layout-shapes/' . ($layout->image ?? 'default.jpg')) }}"
                                                alt="" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Layout:</strong> {{ $layout->name }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> €{{ number_format($layout->price, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Dimensions -->
                            @if($blad1['width'] || $blad1['height'])
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Dimensions <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Width:</strong> {{ $blad1['width'] ?: 'N/A' }} cm
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Height:</strong> {{ $blad1['height'] ?: 'N/A' }} cm
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Area:</strong> {{ number_format($area, 2) }} m²
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Edge Finishing --}}
                            @if($edgeProfile)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Edge Finishing <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Profile:</strong> {{ $edgeProfile->name }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Thickness:</strong>
                                                {{ $edgeThickness?->thickness_value ?? '—' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Color:</strong> {{ $edgeColor?->name ?? '—' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Selected Edges::</strong>
                                                @if(!empty($edgeFinishing['selected_edges']))
                                                {{ implode(', ', array_map('ucfirst', $edgeFinishing['selected_edges'])) }}
                                                @else
                                                Standard (Green edges)
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Back Wall / Backsplash -->
                            @if($backsplash)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Back Wall / Backsplash <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        @if($backsplash->image)
                                        <figure class="me-4">
                                            <img width="160"
                                                src="{{ asset('uploads/backsplash-shape/' . ($backsplash->image ?? 'default.jpg')) }}"
                                                alt="" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Name:</strong> {{ $backsplash->name ?? 'N/A' }}
                                            </div>
                                            @if(!empty($backWall['selected_edges']))
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Finished Sides:</strong>
                                                {{ implode(', ', array_map('ucfirst', $backWall['selected_edges'])) }}
                                            </div>
                                            @endif
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> €{{ $priceDetails['backsplash'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Sink -->
                                @if($sink)
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-5">
                                        <div class="result-head">
                                            <h3 class="fs-4">Sink <span></span></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="result-gride d-flex">
                                            @if($sink->images->first())
                                            <figure class="me-4">
                                                <img width="160"
                                                    src="{{ asset('uploads/sinks/' . $sink->images->first()->image) }}"
                                                    alt="{{ $sink->name }}" />
                                            </figure>
                                            @endif
                                            <div class="w-100">
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Model:</strong> {{ $sink->name ?? 'N/A' }}
                                                </div>
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Category:</strong>
                                                    {{ optional($sink->category)->name ?? 'N/A' }}
                                                </div>
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Type:</strong>
                                                    {{ ucfirst($sinkSelection['cutout']) ?? 'N/A' }}
                                                </div>
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Number:</strong> {{ $sinkSelection['number'] ?? 'N/A' }}
                                                </div>
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Price:</strong> €{{ $priceDetails['sink'] ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Cutout -->
                                @if($cutout)
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-5">
                                        <div class="result-head">
                                            <h3 class="fs-4">Cutouts <span></span></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="result-gride d-flex">
                                            @if($cutout->images->first())
                                            <figure class="me-4">
                                                <img width="160"
                                                    src="{{ asset('uploads/cut-outs/' . ($cutout->images->first()->image ?? 'default.jpg')) }}"
                                                    alt="" />
                                            </figure>
                                            @endif
                                            <div class="w-100">
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Kind:</strong> {{ $cutout->name ?? 'N/A' }}
                                                </div>
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Category:</strong>
                                                    {{ optional($cutout->category)->name ?? 'N/A' }}
                                                </div>
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Type:</strong>
                                                    {{ ucfirst($cutoutSelection['recess_type']) ?? 'N/A' }}
                                                </div>
                                                <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                    <strong>Price:</strong> €{{ $priceDetails['cutout'] ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Total Price -->
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Total Price <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Total:</strong> €
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center my-5 d-flex align-items-center justify-content-start gap-4">
                                <button type="submit" class="btn btn-dark btn-primary px-4">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Overview Tab -->
        <div class="tab-pane fade" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row">
                <div class="col-md-12">
                    <h3>Summary of Your Selections</h3>
                    <ul>
                        @if($materialType && $color && $finish && $thickness)
                        <li><strong>Type:</strong> {{ $materialType->name }} (Color: {{ $color->name ?? 'N/A' }},
                            Finish: {{ $finish->finish_name ?? 'N/A' }}, Thickness: {{ $thickness?->thickness_value ?? '—' }})
                        </li>
                        @endif

                        @if($layout)
                        <li><strong>Layout:</strong> {{ $layout->name }} (Price:
                            €{{ number_format($layout->price, 2) }})</li>
                        @endif
                        
                        @if($blad1['width'] || $blad1['height'])
                        <li><strong>Dimensions:</strong> Width: {{ $blad1['width'] ?: 'N/A' }} cm, Height:
                            {{ $blad1['height'] ?: 'N/A' }} cm, Area: {{ number_format($area, 2) }} m²</li>
                        @endif

                        @if($edgeProfile)
                        <li><strong>Profile:</strong> {{ $edgeProfile->name }} (Thickness:
                            {{ $edgeThickness?->thickness_value ?? '—' }}, Color:
                            {{ $edgeColor?->name ?? '—' }})</li>
                        @endif

                        @if($backsplash)
                        <li><strong>Back Wall:</strong> {{ $backsplash->name ?? 'N/A' }} </li>
                        @endif
                        @if($sink)
                        <li><strong>Sink:</strong> {{ $sink->name }} (Category:
                            {{ optional($sink->category)->name ?? 'N/A' }}, Type:
                            {{ ucfirst($sinkSelection['cutout']) ?? 'N/A' }}, Number:
                            {{ $sinkSelection['number'] ?? 'N/A' }}, Price: €{{ $priceDetails['sink'] ?? 'N/A' }})</li>
                        @endif
                        @if($cutout)
                        <li><strong>Cut-Out:</strong> {{ $cutout->name ?? 'N/A' }} (Category:
                            {{ optional($cutout->category)->name ?? 'N/A' }}, Type:
                            {{ ucfirst($cutoutSelection['recess_type']) ?? 'N/A' }}, Price:
                            €{{ $priceDetails['cutout'] ?? 'N/A' }})</li>
                        @endif
                        <li><strong>Total Price:</strong> €</li>
                    </ul>
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

@php
// Retrieve session data
$materialId = session('selected_material_id');
$materialTypeId = session('selected_material_type_id');
$layoutId = session('selected_layout_id');
$dimensions = session('dimensions', ['blad1' => ['width' => '', 'height' => '']]);
$edgeFinishing = session('edge_finishing', ['edge_id' => null, 'thickness' => null, 'selected_edges' => []]);
$backWall = session('back_wall', ['wall_id' => null, 'thickness' => null, 'selected_edges' => []]);
$sinkSelection = session('sink_selection', ['sink_id' => null, 'cutout' => null, 'number' => null]);
$cutoutSelection = session('cutout_selection', ['cutout_id' => null, 'recess_type' => null]);
$userDetails = session('user_details', [
    'first_name' => '',
    'last_name' => '',
    'phone_number' => '',
    'email' => '',
    'delivery_option' => '',
    'measurement_time' => '',
    'promo_code' => ''
]);

// Fetch database records
$material = $materialId ? \App\Models\Material::find($materialId) : null;
$materialType = $materialTypeId ? \App\Models\MaterialType::find($materialTypeId) : null;
$layout = $layoutId ? \App\Models\MaterialLayout::find($layoutId) : null;
$edge = $edgeFinishing['edge_id'] ? \App\Models\MaterialEdge::find($edgeFinishing['edge_id']) : null;
$wall = $backWall['wall_id'] ? \App\Models\BackWall::find($backWall['wall_id']) : null;
$sink = $sinkSelection['sink_id'] ? \App\Models\Sink::with('images')->find($sinkSelection['sink_id']) : null;
$cutout = $cutoutSelection['cutout_id'] ? \App\Models\CutOuts::with('images')->find($cutoutSelection['cutout_id']) : null;

// Safely access dimensions
$blad1 = isset($dimensions['blad1']) ? $dimensions['blad1'] : ['width' => '', 'height' => ''];

// Calculate area in square meters (width and height in cm, so divide by 10000 to convert to m²)
$area = (!empty($blad1['width']) && !empty($blad1['height']) && is_numeric($blad1['width']) && is_numeric($blad1['height']))
    ? ($blad1['width'] * $blad1['height']) / 10000
    : 0;

// Calculate prices
$totalPrice = 0;
$priceDetails = [];

if ($material && $material->price) {
    $materialPrice = $material->price * $area;
    $totalPrice += $materialPrice;
    $priceDetails['material'] = number_format($materialPrice, 2);
}
if ($materialType && $materialType->price) {
    $materialTypePrice = $materialType->price * $area;
    $totalPrice += $materialTypePrice;
    $priceDetails['material_type'] = number_format($materialTypePrice, 2);
}
if ($layout && $layout->price) {
    $layoutPrice = $layout->price * $area;
    $totalPrice += $layoutPrice;
    $priceDetails['layout'] = number_format($layoutPrice, 2);
}
if ($edge && $edge->price) {
    $edgePrice = $edge->price * $area;
    $totalPrice += $edgePrice;
    $priceDetails['edge'] = number_format($edgePrice, 2);
}
if ($wall && $wall->price) {
    $wallPrice = $wall->price * $area;
    $totalPrice += $wallPrice;
    $priceDetails['wall'] = number_format($wallPrice, 2);
}
if ($sink && $sink->price) {
    $sinkPrice = $sink->price * ($sinkSelection['number'] ?? 1);
    $totalPrice += $sinkPrice;
    $priceDetails['sink'] = number_format($sinkPrice, 2);
}
if ($cutout && $cutout->price) {
    $cutoutPrice = $cutout->price;
    $totalPrice += $cutoutPrice;
    $priceDetails['cutout'] = number_format($cutoutPrice, 2);
}

$totalPrice = number_format($totalPrice, 2);
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
            <form action="{{ route('calculator.submit') }}" method="POST" class="pb-5 ps-0 ps-md-5 custom-form" id="customForm">
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
                                            <option value="square" >
                                                Square
                                            </option>
                                            <option value="round" >
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
                                            <option value="round" >
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
                            <!-- Material -->
                            @if($material)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Material <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        @if($material->image)
                                        <figure class="me-4">
                                            <img width="160" src="{{ asset('Uploads/materials/' . $material->image) }}"
                                                alt="{{ $material->name }}" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Material:</strong> {{ $material->name ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> ₹{{ $priceDetails['material'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Material Type -->
                            @if($materialType)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Material Type <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        @if($materialType->image)
                                        <figure class="me-4">
                                            <img width="160" src="{{ asset('Uploads/material-types/' . $materialType->image) }}"
                                                alt="{{ $materialType->name }}" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Type:</strong> {{ $materialType->name ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> ₹{{ $priceDetails['material_type'] ?? 'N/A' }}
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
                                            <img width="160" src="{{ asset('Uploads/material-layout/' . $layout->image) }}"
                                                alt="{{ $layout->name }}" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Layout:</strong> {{ $layout->name ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> ₹{{ $priceDetails['layout'] ?? 'N/A' }}
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

                            <!-- Edge Finishing -->
                            @if($edge)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Edge Finishing <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        @if($edge->image)
                                        <figure class="me-4">
                                            <img width="160" src="{{ asset('Uploads/material-edge/' . $edge->image) }}"
                                                alt="{{ $edge->name }}" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Kind:</strong> {{ $edge->name ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Thickness:</strong> {{ $edgeFinishing['thickness'] ?? 'N/A' }} cm
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Edges to be Finished:</strong> {{ implode(', ', $edgeFinishing['selected_edges']) ?: 'None' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> ₹{{ $priceDetails['edge'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Back Wall -->
                            @if($wall)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <div class="result-head">
                                        <h3 class="fs-4">Back Wall <span></span></h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="result-gride d-flex">
                                        @if($wall->image)
                                        <figure class="me-4">
                                            <img width="160" src="{{ asset('Uploads/back-wall/' . $wall->image) }}"
                                                alt="{{ $wall->name }}" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Kind:</strong> {{ $wall->name ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Thickness:</strong> {{ $backWall['thickness'] ?? 'N/A' }} cm
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Sides to be Finished:</strong> {{ implode(', ', $backWall['selected_edges']) ?: 'None' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> ₹{{ $priceDetails['wall'] ?? 'N/A' }}
                                            </div>
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
                                            <img width="160" src="{{ asset('Uploads/sinks/' . $sink->images->first()->image) }}"
                                                alt="{{ $sink->name }}" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Model:</strong> {{ $sink->name ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Type:</strong> {{ ucfirst($sinkSelection['cutout']) ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Number:</strong> {{ $sinkSelection['number'] ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> ₹{{ $priceDetails['sink'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Cut-Outs -->
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
                                            <img width="160" src="{{ asset('Uploads/cut-outs/' . $cutout->images->first()->image) }}"
                                                alt="{{ $cutout->name }}" />
                                        </figure>
                                        @endif
                                        <div class="w-100">
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Kind:</strong> {{ $cutout->name ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Type:</strong> {{ ucfirst($cutoutSelection['recess_type']) ?? 'N/A' }}
                                            </div>
                                            <div class="fs-5 mb-4 d-flex justify-content-between flex-wrap">
                                                <strong>Price:</strong> ₹{{ $priceDetails['cutout'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

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
                                                <strong>Total:</strong> ₹{{ $totalPrice }}
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
                        @if($material)
                        <li><strong>Material:</strong> {{ $material->name }} (Brand: {{ $material->brand ?? 'N/A' }},
                            Color: {{ $material->color ?? 'N/A' }}, Price: ₹{{ $priceDetails['material'] ?? 'N/A' }})</li>
                        @endif
                        @if($materialType)
                        <li><strong>Material Type:</strong> {{ $materialType->name }} (Price: ₹{{ $priceDetails['material_type'] ?? 'N/A' }})</li>
                        @endif
                        @if($layout)
                        <li><strong>Layout:</strong> {{ $layout->name }} (Price: ₹{{ $priceDetails['layout'] ?? 'N/A' }})</li>
                        @endif
                        @if($blad1['width'] || $blad1['height'])
                        <li><strong>Dimensions:</strong> Width: {{ $blad1['width'] ?: 'N/A' }} cm, Height: {{ $blad1['height'] ?: 'N/A' }} cm, Area: {{ number_format($area, 2) }} m²</li>
                        @endif
                        @if($edge)
                        <li><strong>Edge Finishing:</strong> {{ $edge->name }} (Thickness: {{ $edgeFinishing['thickness'] ?? 'N/A' }} cm, Edges: {{ implode(', ', $edgeFinishing['selected_edges']) ?: 'None' }}, Price: ₹{{ $priceDetails['edge'] ?? 'N/A' }})</li>
                        @endif
                        @if($wall)
                        <li><strong>Back Wall:</strong> {{ $wall->name }} (Thickness: {{ $backWall['thickness'] ?? 'N/A' }} cm, Sides: {{ implode(', ', $backWall['selected_edges']) ?: 'None' }}, Price: ₹{{ $priceDetails['wall'] ?? 'N/A' }})</li>
                        @endif
                        @if($sink)
                        <li><strong>Sink:</strong> {{ $sink->name }} (Type: {{ ucfirst($sinkSelection['cutout']) ?? 'N/A' }}, Number: {{ $sinkSelection['number'] ?? 'N/A' }}, Price: ₹{{ $priceDetails['sink'] ?? 'N/A' }})</li>
                        @endif
                        @if($cutout)
                        <li><strong>Cut-Out:</strong> {{ $cutout->name }} (Type: {{ ucfirst($cutoutSelection['recess_type']) ?? 'N/A' }}, Price: ₹{{ $priceDetails['cutout'] ?? 'N/A' }})</li>
                        @endif
                        <li><strong>Total Price:</strong> ₹{{ $totalPrice }}</li>
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

<!-- <script>
document.getElementById('customForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Quotation submitted successfully!');
            document.querySelector('#overview-tab').click();
        } else {
            alert('Submission failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});
</script> -->

@php
// Retrieve session data
$materialId = session('selected_material_id');
$materialTypeId = session('selected_material_type_id');
$layoutId = session('selected_layout_id');
$dimensions = session('dimensions', ['blad1' => ['width' => '', 'height' => '']]);
$edgeFinishing = session('edge_finishing', ['edge_id' => null, 'thickness_id' => null, 'color_id' => null, 'selected_edges' => []]);
$backWall = session('back_wall', ['wall_id' => null, 'selected_edges' => []]);
$sinkSelection = session('sink_selection', ['sink_id' => null, 'cutout' => null, 'number' => null]);
$cutoutSelection = session('cutout_selection', ['cutout_id' => null, 'recess_type' => null]);
$materialConfig = session('material_config', []);
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
$layout = $layoutId ? \App\Models\MaterialLayoutShape::find($layoutId) : null;
$edge = $edgeFinishing['edge_id'] ? \App\Models\EdgeProfile::find($edgeFinishing['edge_id']) : null;
$edgeThickness = $edgeFinishing['thickness_id'] ? \App\Models\Thickness::find($edgeFinishing['thickness_id']) : null;
$edgeColor = $edgeFinishing['color_id'] ? \App\Models\Color::find($edgeFinishing['color_id']) : null;
$wall = $backWall['wall_id'] ? \App\Models\BacksplashShapes::find($backWall['wall_id']) : null;
$sink = $sinkSelection['sink_id'] ? \App\Models\Sink::with('images')->find($sinkSelection['sink_id']) : null;
$cutout = $cutoutSelection['cutout_id'] ? \App\Models\CutOuts::with('images')->find($cutoutSelection['cutout_id']) : null;
$selectedColor = isset($materialConfig['color']) ? \App\Models\Color::find($materialConfig['color']) : null;
$selectedFinish = (isset($materialConfig['finish']) && class_exists('\\App\\Models\\Finish')) ? \App\Models\Finish::find($materialConfig['finish']) : null;
$selectedThickness = isset($materialConfig['thickness']) ? \App\Models\Thickness::find($materialConfig['thickness']) : null;

// Safely access dimensions
$blad1 = isset($dimensions['blad1']) ? $dimensions['blad1'] : ['width' => '', 'height' => ''];

// Calculate area in square meters (width and height in cm, so divide by 10000 to convert to m²)
$area = (!empty($blad1['width']) && !empty($blad1['height']) && is_numeric($blad1['width']) && is_numeric($blad1['height']))
    ? ($blad1['width'] * $blad1['height']) / 10000
    : 0;

// Price calculation skipped for now (models may not contain price fields for all selections)
$totalPrice = null;
$priceDetails = [];
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
                                            placeholder="e.g. Johan" value="{{ auth()->check() ? (explode(' ', auth()->user()->name ?? '')[0] ?? '') : '' }}" required />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 position-relative">
                                    <div class="inputfild-box">
                                        <label class="form-label">Last Name<sup>*</sup></label>
                                        <input type="text" id="lastName" name="last_name" class="form-control"
                                            placeholder="e.g. Sans" value="{{ auth()->check() ? (trim(implode(' ', array_slice(explode(' ', auth()->user()->name ?? ''), 1))) ) : '' }}" required />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 position-relative">
                                    <div class="inputfild-box">
                                        <label class="form-label">Phone Number<sup>*</sup></label>
                                        <input type="text" id="phoneNumber" name="phone_number" class="form-control"
                                            placeholder="e.g. +32 4 9720 4041" value="{{ auth()->check() ? (auth()->user()->mobile ?? '') : '' }}"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 position-relative">
                                    <div class="inputfild-box">
                                        <label class="form-label">Email ID<sup>*</sup></label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="e.g. Johan@artimordesgns.com" value="{{ auth()->check() ? (auth()->user()->email ?? '') : '' }}"
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
                            

                            <!-- Submit Button -->
                            <div class="text-center my-5 d-flex align-items-center justify-content-start gap-4">
                                <button type="submit" class="btn btn-dark btn-primary px-4">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
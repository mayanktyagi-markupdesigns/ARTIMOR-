@php
$backWall = session('back_wall', [
    'wall_id' => null,
    'thickness' => null,
    'selected_edges' => []
]) ?? [];
$selectedWallId = $backWall['wall_id'] ?? null;
$selectedThickness = $backWall['thickness'] ?? null;
$selectedEdges = $backWall['selected_edges'] ?? [];
@endphp

<div class="materials">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @foreach($wall as $index => $w)
                <div class="col-md-4 mb-4">
                    <div class="p-0 card border-0 rounded-0 position-relative product-col wall-card {{ $selectedWallId == $w->id ? 'selected' : '' }}"
                        data-id="{{ $w->id }}">
                        <img src="{{ asset('Uploads/back-wall/' . $w->image) }}" class="card-img-top" alt="{{ $w->name }}" />
                        <div class="p-0 card-body text-center">
                            <div class="cursor titleoverlay" data-tab="#tab{{ $index + 1 }}">
                                <div>
                                    <span>{{ sprintf("%02d", $index + 1) }}.</span> {{ strtoupper($w->name) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-12 mt-4 back-wall-tab mt-5">
            <hr>
            <div class="tab-contents pt-5">
                <div id="tab2" class="tab-content" style="display: block;">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="tabheader d-flex align-items-start mb-4">
                                <figure class="me-3 pr-s-img">
                                    <img src="assets/img/18.png" width="50">
                                </figure>
                                <div>
                                    <h3 class="fs-4 fw-bold mb-1">Select Sides for Back Wall Finishing</h3>
                                    <p class="text-success small">The Green Sides Are Delivered Finished As Standard.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-5">
                            <div class="row g-5">
                                <div class="col-lg-6">
                                    <div class="border-btm-green edges-check-box d-flex align-items-center justify-content-center position-relative me-0 me-md-4">
                                        Blad 01
                                        <span class="left-11-cir edge-circle {{ in_array('left', $selectedEdges) ? 'selected' : '' }}"
                                            data-edge="left"></span>
                                        <span class="right-11-cir edge-circle {{ in_array('right', $selectedEdges) ? 'selected' : '' }}"
                                            data-edge="right"></span>
                                        <span class="top-11-cir edge-circle {{ in_array('top', $selectedEdges) ? 'selected' : '' }}"
                                            data-edge="top"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 my-5">
                            <hr>
                        </div>
                        <div class="col-lg-12 d-flex">
                            <div class="inputfild-box w-100">
                                <label class="form-label">Back Wall Thickness<sup>*</sup></label>
                                <select class="form-select" id="wall-thickness">
                                    <option value="">Select</option>
                                    @foreach(range(1, 9) as $value)
                                    <option value="{{ $value }}" {{ $selectedThickness == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="ms-2 btn btn-primary btn-normal">Cm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.wall-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.wall-card:hover {
    transform: scale(1.02);
}
.wall-card.selected {
    border: 3px solid #007bff;
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.5);
    position: relative;
}
.wall-card.selected::after {
    content: "✔ Selected";
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #007bff;
    color: white;
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 4px;
    font-weight: bold;
}
.edge-circle {
    cursor: pointer;
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #ccc;
    position: absolute;
}
.edge-circle.selected {
    background-color: #28a745;
}
.left-11-cir { left: -30px; }
.right-11-cir { right: -30px; }
.top-11-cir { top: -30px; }
</style>
@php
$edgeFinishing = session('edge_finishing', [
    'edge_id' => null,
    'thickness' => null,
    'selected_edges' => []
]) ?? [];

$selectedEdgeId = $edgeFinishing['edge_id'] ?? null;
$selectedThickness = $edgeFinishing['thickness'] ?? null;
$selectedEdges = $edgeFinishing['selected_edges'] ?? [];
@endphp
<div class="materials">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @foreach($edge as $index => $e)
                <div class="col-md-4 mb-4">
                    <div class="p-0 card border-0 rounded-0 position-relative product-col edge-card {{ $selectedEdgeId == $e->id ? 'selected' : '' }}"
                        data-id="{{ $e->id }}">
                        <img src="{{ asset('Uploads/material-edge/' . $e->image) }}" class="card-img-top" alt="{{ $e->name }}" />
                        <div class="p-0 card-body text-center">
                            <div class="cursor titleoverlay" data-tab="#tab{{ $index + 1 }}">
                                <div>
                                    <span>{{ sprintf("%02d", $index + 1) }}.</span> {{ strtoupper($e->name) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-12 mt-4 edge-finishing-tab mt-5">
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
                                    <h3 class="fs-4 fw-bold mb-1">02 Check The Edges You Also Want To Have Finished.</h3>
                                    <p class="text-success small">The Green Edges Are Delivered Finished As Standard.</p>
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
                                <label class="form-label">Edge Thickness<sup>*</sup></label>
                                <select class="form-select" id="edge-thickness">
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
.edge-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.edge-card:hover {
    transform: scale(1.02);
}
.edge-card.selected {
    border: 3px solid #007bff;
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.5);
    position: relative;
}
.edge-card.selected::after {
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
<!-- @php
$edgeFinishing = $edgeFinishing ?? session('edge_finishing', [
'edge_id' => null,
'thickness_id' => null,
'color_id' => null,
'selected_edges' => []
]);

$selectedEdgeId = $edgeFinishing['edge_id'] ?? null;
$selectedThicknessId = $edgeFinishing['thickness_id'] ?? null;
$selectedColorId = $edgeFinishing['color_id'] ?? null;
$selectedEdges = $edgeFinishing['selected_edges'] ?? [];

$edgeProfiles = $edgeProfiles ?? collect();
$materialConfig = session('material_config', []);
$selectedMaterialTypeId = $selectedMaterialTypeId ?? ($materialConfig['material_type_id'] ??
session('selected_material_type_id'));
@endphp -->

@php
$materialConfig = session('material_config', []);

$edgeFinishing = session('edge_finishing', [
    'edge_id' => null,
    'thickness_id' => $materialConfig['thickness'] ?? null,
    'color_id' => $materialConfig['color'] ?? null,
    'selected_edges' => []
]);

$selectedEdgeId = $edgeFinishing['edge_id'];
$selectedEdges = $edgeFinishing['selected_edges'];
$selectedThicknessId = $edgeFinishing['thickness_id'];
$selectedColorId = $edgeFinishing['color_id'];

$edgeProfiles = $edgeProfiles ?? collect();

$selectedMaterialTypeId =
$selectedMaterialTypeId
?? $materialConfig['material_type_id']
?? session('selected_material_type_id');

$thicknessName = !empty($materialConfig['thickness'])
? \App\Models\Thickness::find($materialConfig['thickness'])?->thickness_value
: null;

$colorName = !empty($materialConfig['color'])
? \App\Models\Color::find($materialConfig['color'])?->name
: null;
@endphp

<div class="materials">
    <!-- Step 1: Select Edge Profile -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <h4 class="mb-4 fw-bold">Select Edge Profile</h4>
            <div class="row" id="edge-profiles-list">
                @forelse($edgeProfiles as $index => $edge)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="p-0 card border rounded position-relative edge-profile-card {{ $selectedEdgeId == $edge->id ? 'selected' : '' }}"
                        data-id="{{ $edge->id }}" data-name="{{ $edge->name }}">
                        <div class="card-body text-center p-3">
                            <div class="edge-profile-icon mb-2">
                                <i class="fas fa-border-style fa-3x text-primary"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">{{ $edge->name }}</h6>
                            <small class="text-muted">Click to select</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning">No edge profiles available.</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Step 2 & 3: Thickness & Color (Read Only) -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <hr class="my-4">
            <h4 class="mb-4 fw-bold">Thickness & Color</h4>

            <div class="row">
                <!-- Thickness -->
                <div class="col-md-6">
                    <div class="inputfild-box">
                        <label class="form-label fw-bold">
                            Thickness
                            <small class="text-muted">(From Material)</small>
                        </label>
                        <div class="form-control form-control-lg bg-light">
                            {{ $thicknessName }}
                        </div>
                    </div>
                </div>

                <!-- Color -->
                <div class="col-md-6">
                    <div class="inputfild-box">
                        <label class="form-label fw-bold">
                            Color
                            <small class="text-muted">(From Material)</small>
                        </label>
                        <div class="form-control form-control-lg bg-light">
                            {{ $colorName  }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 4: Select Edges (shown after color is selected) -->
    <div class="row mb-5" id="edges-selection-section">
        <div class="col-lg-12">
            <hr class="my-4">
            <h4 class="mb-4 fw-bold">Select Edges to Finish</h4>
            <div class="row">
                <div class="col-lg-12 mb-4">

                </div>
                <div class="col-lg-6">
                    <div class="border-btm-green edges-check-box d-flex align-items-center justify-content-center position-relative p-4"
                        style="min-height: 200px;">
                        <div class="text-center">
                            <h5 class="mb-3">Blad 01</h5>
                            <span
                                class="left-11-cir edge-circle {{ in_array('left', $selectedEdges) ? 'selected' : '' }}"
                                data-edge="left" title="Left Edge"></span>
                            <span
                                class="right-11-cir edge-circle {{ in_array('right', $selectedEdges) ? 'selected' : '' }}"
                                data-edge="right" title="Right Edge"></span>
                            <span class="top-11-cir edge-circle {{ in_array('top', $selectedEdges) ? 'selected' : '' }}"
                                data-edge="top" title="Top Edge"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    setTimeout(() => {

        // ✅ READONLY values from material
        const selectedThicknessId = @json($selectedThicknessId);
        const selectedColorId = @json($selectedColorId);
        const selectedEdgesFromSession = @json($selectedEdges);
        let selectedEdgeId = @json($selectedEdgeId);

        // ✅ GLOBAL OBJECT (single source of truth)
        window.edgeFinishing = {
            edge_id: selectedEdgeId,
            thickness_id: selectedThicknessId,
            color_id: selectedColorId,
            selected_edges: Array.isArray(selectedEdgesFromSession) ?
                selectedEdgesFromSession : []
        };

        /* ==========================
           EDGE PROFILE SELECTION
        ========================== */
        document.querySelectorAll('.edge-profile-card').forEach(card => {
            card.addEventListener('click', () => {
                selectedEdgeId = card.dataset.id;

                document.querySelectorAll('.edge-profile-card')
                    .forEach(c => c.classList.remove('selected'));

                card.classList.add('selected');

                window.edgeFinishing.edge_id = selectedEdgeId;

                saveEdgeFinishing();
            });
        });

        /* ==========================
           EDGE SIDE SELECTION
        ========================== */
        document.querySelectorAll('.edge-circle').forEach(circle => {
            circle.addEventListener('click', () => {
                const edge = circle.dataset.edge;
                if (!edge) return;

                circle.classList.toggle('selected');

                if (window.edgeFinishing.selected_edges.includes(edge)) {
                    window.edgeFinishing.selected_edges =
                        window.edgeFinishing.selected_edges.filter(e => e !== edge);
                } else {
                    window.edgeFinishing.selected_edges.push(edge);
                }

                saveEdgeFinishing();
            });
        });

        /* ==========================
           SAVE TO SESSION
        ========================== */
        function saveEdgeFinishing() {
            fetch("{{ route('calculator.steps') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    step: 5,
                    edge_finishing: window.edgeFinishing
                })
            });
        }

        /* ==========================
           RESTORE UI FROM SESSION
        ========================== */
        if (selectedEdgeId) {
            document
                .querySelector(`.edge-profile-card[data-id="${selectedEdgeId}"]`)
                ?.classList.add('selected');
        }

        window.edgeFinishing.selected_edges.forEach(edge => {
            document
                .querySelector(`.edge-circle[data-edge="${edge}"]`)
                ?.classList.add('selected');
        });

    }, 50);
})();
</script>

<style>
.edge-profile-card {
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.edge-profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.edge-profile-card.selected {
    border: 3px solid #28a745 !important;
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.5) !important;
    background-color: #f8fff9;
}

.edge-profile-card.selected::after {
    content: "✓ Selected";
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #28a745;
    color: white;
    padding: 4px 8px;
    font-size: 11px;
    border-radius: 4px;
    font-weight: bold;
    z-index: 5;
}

.edge-profile-icon {
    color: #007bff;
}

.edge-profile-card.selected .edge-profile-icon {
    color: #28a745;
}

.edge-circle {
    cursor: pointer;
    display: inline-block;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background-color: #ccc;
    position: absolute;
    border: 2px solid #fff;
    transition: all 0.3s ease;
}

.edge-circle:hover {
    transform: scale(1.2);
    border-color: #28a745;
}

.edge-circle.selected {
    background-color: #28a745;
    border-color: #28a745;
    box-shadow: 0 0 8px rgba(40, 167, 69, 0.6);
}

.left-11-cir {
    left: -35px;
    top: 50%;
    transform: translateY(-50%);
}

.right-11-cir {
    right: -35px;
    top: 50%;
    transform: translateY(-50%);
}

.top-11-cir {
    top: -35px;
    left: 50%;
    transform: translateX(-50%);
}

.form-select.is-invalid {
    border-color: #dc3545;
}

.form-select.is-valid {
    border-color: #28a745;
}

.border-btm-green {
    border: 2px solid #28a745;
    border-radius: 8px;
    background: #f8fff9;
}

#selection-summary {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
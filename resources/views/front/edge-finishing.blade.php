@php
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
$selectedMaterialTypeId = $selectedMaterialTypeId ?? ($materialConfig['material_type_id'] ?? session('selected_material_type_id'));
@endphp

<div class="materials">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="mb-4">Select Edge Profile</h4>
            <div class="row">
                @foreach($edgeProfiles as $index => $edge)
                <div class="col-md-4 mb-4">
                    <div class="p-0 card border-0 rounded-0 position-relative product-col edge-card {{ $selectedEdgeId == $edge->id ? 'selected' : '' }}"
                        data-id="{{ $edge->id }}">
                        <img src="{{ asset('assets/front/img/product-circle.jpg') }}" class="card-img-top" alt="{{ $edge->name }}" />
                        <div class="p-0 card-body text-center">
                            <div class="titleoverlay">
                                <div>
                                    <span>{{ sprintf("%02d", $index + 1) }}.</span> {{ strtoupper($edge->name) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Thickness and Color Selection (shown after edge profile is selected) -->
        @if($selectedEdgeId)
        <div class="col-lg-12 mt-5" id="edge-options-section">
            <hr>
            <div class="row">
                <!-- Thickness Dropdown -->
                <div class="col-md-6 mb-4">
                    <div class="inputfild-box">
                        <label class="form-label">Thickness<sup>*</sup></label>
                        <select class="form-select" id="edge-thickness-select">
                            <option value="">Select Thickness</option>
                            <!-- Will be populated via AJAX -->
                        </select>
                        <div class="invalid-feedback">Please select a thickness.</div>
                    </div>
                </div>

                <!-- Color Dropdown (shown after thickness is selected) -->
                <div class="col-md-6 mb-4" id="edge-color-section" style="display: none;">
                    <div class="inputfild-box">
                        <label class="form-label">Color<sup>*</sup></label>
                        <select class="form-select" id="edge-color-select">
                            <option value="">Select Color</option>
                            <!-- Will be populated via AJAX -->
                        </select>
                        <div class="invalid-feedback">Please select a color.</div>
                    </div>
                </div>
            </div>

            <!-- Edge Selection -->
            <div class="col-lg-12 mt-4">
                <hr>
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <div class="tabheader d-flex align-items-start mb-4">
                            <figure class="me-3 pr-s-img">
                                <img src="assets/img/18.png" width="50">
                            </figure>
                            <div>
                                <h3 class="fs-4 fw-bold mb-1">Check The Edges You Also Want To Have Finished.</h3>
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
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const materialTypeId = @json($selectedMaterialTypeId);
    let selectedEdgeId = @json($selectedEdgeId);
    let selectedThicknessId = @json($selectedThicknessId);
    let selectedColorId = @json($selectedColorId);
    
    // Sync with global edgeFinishing object
    if (typeof edgeFinishing !== 'undefined') {
        edgeFinishing.edge_id = selectedEdgeId;
        edgeFinishing.thickness_id = selectedThicknessId;
        edgeFinishing.color_id = selectedColorId;
        edgeFinishing.selected_edges = @json($selectedEdges);
    }

            // Edge Profile Selection
            document.querySelectorAll('.edge-card').forEach(card => {
                card.addEventListener('click', function() {
                    const edgeId = this.getAttribute('data-id');
                    if (!edgeId) return;

                    selectedEdgeId = edgeId;
                    selectedThicknessId = null;
                    selectedColorId = null;
                    
                    // Update UI
                    document.querySelectorAll('.edge-card').forEach(c => {
                        if (c && c.classList) {
                            c.classList.remove('selected');
                        }
                    });
                    
                    if (this && this.classList) {
                        this.classList.add('selected');
                    }

                    // Update global object
                    if (typeof edgeFinishing !== 'undefined') {
                        edgeFinishing.edge_id = edgeId;
                        edgeFinishing.thickness_id = null;
                        edgeFinishing.color_id = null;
                    }

                    // Show options section
                    const optionsSection = document.getElementById('edge-options-section');
                    if (optionsSection) {
                        optionsSection.style.display = 'block';
                    }

                    // Reset dropdowns
                    const thicknessSelect = document.getElementById('edge-thickness-select');
                    const colorSelect = document.getElementById('edge-color-select');
                    const colorSection = document.getElementById('edge-color-section');
                    
                    if (thicknessSelect) {
                        thicknessSelect.innerHTML = '<option value="">Select Thickness</option>';
                        thicknessSelect.classList.remove('is-valid', 'is-invalid');
                    }
                    if (colorSelect) {
                        colorSelect.innerHTML = '<option value="">Select Color</option>';
                        colorSelect.classList.remove('is-valid', 'is-invalid');
                    }
                    if (colorSection) {
                        colorSection.style.display = 'none';
                    }

                    // Load thicknesses
                    loadThicknesses(edgeId, materialTypeId);
                    
                    // Save to session
                    saveEdgeFinishingToSession();
                });
            });

    // Load Thicknesses
    function loadThicknesses(edgeProfileId, materialTypeId) {
        if (!edgeProfileId || !materialTypeId) return;

        const thicknessSelect = document.getElementById('edge-thickness-select');
        if (!thicknessSelect) return;

        thicknessSelect.innerHTML = '<option value="">Loading...</option>';
        thicknessSelect.disabled = true;

        fetch(`{{ route('calculator.edge.thicknesses') }}?edge_profile_id=${edgeProfileId}&material_type_id=${materialTypeId}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            thicknessSelect.innerHTML = '<option value="">Select Thickness</option>';
            
            if (data.thicknesses && data.thicknesses.length > 0) {
                data.thicknesses.forEach(thickness => {
                    const option = document.createElement('option');
                    option.value = thickness.id;
                    option.textContent = thickness.value;
                    if (selectedThicknessId == thickness.id) {
                        option.selected = true;
                    }
                    thicknessSelect.appendChild(option);
                });
            }
            
            thicknessSelect.disabled = false;
            thicknessSelect.classList.remove('is-invalid');
            
            // If thickness was previously selected, load colors
            if (selectedThicknessId) {
                loadColors(edgeProfileId, materialTypeId, selectedThicknessId);
            }
        })
        .catch(error => {
            console.error('Error loading thicknesses:', error);
            thicknessSelect.innerHTML = '<option value="">Error loading thicknesses</option>';
            thicknessSelect.disabled = false;
        });
    }

    // Thickness Selection
    const thicknessSelect = document.getElementById('edge-thickness-select');
    if (thicknessSelect) {
        thicknessSelect.addEventListener('change', function() {
            selectedThicknessId = this.value;
            selectedColorId = null;
            
            // Update global object
            if (typeof edgeFinishing !== 'undefined') {
                edgeFinishing.thickness_id = this.value;
                edgeFinishing.color_id = null;
            }
            
            if (this.value) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                
                // Reset color dropdown
                const colorSelect = document.getElementById('edge-color-select');
                if (colorSelect) {
                    colorSelect.innerHTML = '<option value="">Select Color</option>';
                    colorSelect.classList.remove('is-valid', 'is-invalid');
                }
                
                // Load colors
                loadColors(selectedEdgeId, materialTypeId, this.value);
            } else {
                this.classList.remove('is-valid');
                const colorSection = document.getElementById('edge-color-section');
                if (colorSection) {
                    colorSection.style.display = 'none';
                }
            }
            
            // Save to session
            saveEdgeFinishingToSession();
        });
    }

    // Load Colors
    function loadColors(edgeProfileId, materialTypeId, thicknessId) {
        if (!edgeProfileId || !materialTypeId || !thicknessId) return;

        const colorSelect = document.getElementById('edge-color-select');
        const colorSection = document.getElementById('edge-color-section');
        
        if (!colorSelect || !colorSection) return;

        colorSelect.innerHTML = '<option value="">Loading...</option>';
        colorSelect.disabled = true;
        colorSection.style.display = 'block';

        fetch(`{{ route('calculator.edge.colors') }}?edge_profile_id=${edgeProfileId}&material_type_id=${materialTypeId}&thickness_id=${thicknessId}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            colorSelect.innerHTML = '<option value="">Select Color</option>';
            
            if (data.colors && data.colors.length > 0) {
                data.colors.forEach(color => {
                    const option = document.createElement('option');
                    option.value = color.id;
                    option.textContent = color.name;
                    if (selectedColorId == color.id) {
                        option.selected = true;
                    }
                    colorSelect.appendChild(option);
                });
            }
            
            colorSelect.disabled = false;
            colorSelect.classList.remove('is-invalid');
        })
        .catch(error => {
            console.error('Error loading colors:', error);
            colorSelect.innerHTML = '<option value="">Error loading colors</option>';
            colorSelect.disabled = false;
        });
    }

    // Color Selection
    const colorSelect = document.getElementById('edge-color-select');
    if (colorSelect) {
        colorSelect.addEventListener('change', function() {
            selectedColorId = this.value;
            
            // Update global object
            if (typeof edgeFinishing !== 'undefined') {
                edgeFinishing.color_id = this.value;
            }
            
            if (this.value) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
            
            // Save to session
            saveEdgeFinishingToSession();
        });
    }

    // Edge Circle Selection
    document.querySelectorAll('.edge-circle').forEach(circle => {
        circle.addEventListener('click', function() {
            const edge = this.getAttribute('data-edge');
            if (!edge) return;

            if (!edgeFinishing.selected_edges) {
                edgeFinishing.selected_edges = [];
            }

            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                edgeFinishing.selected_edges = edgeFinishing.selected_edges.filter(e => e !== edge);
            } else {
                this.classList.add('selected');
                edgeFinishing.selected_edges.push(edge);
            }
            
            // Save to session
            saveEdgeFinishingToSession();
        });
    });
    
    // Save edge finishing to session
    function saveEdgeFinishingToSession() {
        const data = {
            edge_id: selectedEdgeId,
            thickness_id: selectedThicknessId,
            color_id: selectedColorId,
            selected_edges: edgeFinishing.selected_edges || []
        };
        
        fetch("{{ route('calculator.steps') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                step: 4,
                edge_finishing: data
            })
        }).catch(err => console.error('Failed to save edge finishing:', err));
    }

    // Initialize if edge is already selected
    if (selectedEdgeId) {
        const selectedCard = document.querySelector(`.edge-card[data-id="${selectedEdgeId}"]`);
        if (selectedCard) {
            selectedCard.click();
        }
    }
});
</script>

<style>
.edge-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.edge-card:hover {
    transform: scale(1.02);
}
.edge-card.selected {
    border: 3px solid #28a745 !important;
    box-shadow: 0 0 12px rgba(40, 167, 69, 0.6) !important;
    position: relative;
}
.edge-card.selected::after {
    content: "✔ Selected";
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #28a745;
    color: white;
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 4px;
    font-weight: bold;
    z-index: 5;
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
.form-select.is-invalid {
    border-color: #dc3545;
}
.form-select.is-valid {
    border-color: #28a745;
}
</style>

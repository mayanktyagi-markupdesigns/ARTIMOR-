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
    <!-- Step 1: Select Edge Profile -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <h4 class="mb-4 fw-bold">Step 1: Select Edge Profile</h4>
            <div class="row" id="edge-profiles-list">
                @forelse($edgeProfiles as $index => $edge)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="p-0 card border rounded position-relative edge-profile-card {{ $selectedEdgeId == $edge->id ? 'selected' : '' }}"
                        data-id="{{ $edge->id }}"
                        data-name="{{ $edge->name }}">
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

    <!-- Step 2: Select Thickness (shown after edge profile is selected) -->
    <div class="row mb-5" id="thickness-section" style="display: none;">
        <div class="col-lg-12">
            <hr class="my-4">
            <h4 class="mb-4 fw-bold">Step 2: Select Thickness</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="inputfild-box">
                        <label class="form-label fw-bold">Thickness<sup class="text-danger">*</sup></label>
                        <select class="form-select form-select-lg" id="edge-thickness-select" required>
                            <option value="">-- Select Thickness --</option>
                            <!-- Will be populated via AJAX -->
                        </select>
                        <div class="invalid-feedback">Please select a thickness.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="alert alert-info mb-0 w-100">
                        <small><i class="fas fa-info-circle"></i> Thickness will be loaded based on selected Edge Profile.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3: Select Color (shown after thickness is selected) -->
    <div class="row mb-5" id="color-section" style="display: none;">
        <div class="col-lg-12">
            <hr class="my-4">
            <h4 class="mb-4 fw-bold">Step 3: Select Color</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="inputfild-box">
                        <label class="form-label fw-bold">Color<sup class="text-danger">*</sup></label>
                        <select class="form-select form-select-lg" id="edge-color-select" required>
                            <option value="">-- Select Color --</option>
                            <!-- Will be populated via AJAX -->
                        </select>
                        <div class="invalid-feedback">Please select a color.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="alert alert-info mb-0 w-100">
                        <small><i class="fas fa-info-circle"></i> Colors will be loaded based on selected Edge Profile and Thickness.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 4: Select Edges (shown after color is selected) -->
    <div class="row mb-5" id="edges-selection-section" style="display: none;">
        <div class="col-lg-12">
            <hr class="my-4">
            <h4 class="mb-4 fw-bold">Step 4: Select Edges to Finish (Optional)</h4>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <strong>Note:</strong> The Green Edges Are Delivered Finished As Standard.
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="border-btm-green edges-check-box d-flex align-items-center justify-content-center position-relative p-4" style="min-height: 200px;">
                        <div class="text-center">
                            <h5 class="mb-3">Blad 01</h5>
                            <span class="left-11-cir edge-circle {{ in_array('left', $selectedEdges) ? 'selected' : '' }}"
                                data-edge="left" title="Left Edge"></span>
                            <span class="right-11-cir edge-circle {{ in_array('right', $selectedEdges) ? 'selected' : '' }}"
                                data-edge="right" title="Right Edge"></span>
                            <span class="top-11-cir edge-circle {{ in_array('top', $selectedEdges) ? 'selected' : '' }}"
                                data-edge="top" title="Top Edge"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="w-100">
                        <h6 class="mb-3">Selected Edges:</h6>
                        <div id="selected-edges-list">
                            @if(count($selectedEdges) > 0)
                                @foreach($selectedEdges as $edge)
                                    <span class="badge bg-success me-2 mb-2">{{ ucfirst($edge) }}</span>
                                @endforeach
                            @else
                                <p class="text-muted">No edges selected yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Selection Summary -->
    <div class="row" id="selection-summary" style="display: none;">
        <div class="col-lg-12">
            <hr class="my-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fas fa-check-circle text-success"></i> Selection Summary</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Edge Profile:</strong> <span id="summary-edge-profile">-</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Thickness:</strong> <span id="summary-thickness">-</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Color:</strong> <span id="summary-color">-</span>
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
    
    // Wait a bit for DOM to be ready (especially when loaded via AJAX)
    setTimeout(function() {
        let materialTypeId = @json($selectedMaterialTypeId);
        let selectedEdgeId = @json($selectedEdgeId);
        let selectedThicknessId = @json($selectedThicknessId);
        let selectedColorId = @json($selectedColorId);
        let selectedEdgeName = '';
        let selectedThicknessValue = '';
        let selectedColorName = '';
        
        // Try to get materialTypeId from session/material config if not available
        if (!materialTypeId) {
            // Try to get from material config in session
            const materialConfig = @json(session('material_config', []));
            if (materialConfig && materialConfig.material_type_id) {
                materialTypeId = materialConfig.material_type_id;
            }
            // Try to get from global variable
            if (!materialTypeId && typeof window.materialSelection !== 'undefined' && window.materialSelection.material_type_id) {
                materialTypeId = window.materialSelection.material_type_id;
            }
        }
        
        console.log('Edge Finishing Initialized:', {
            materialTypeId: materialTypeId,
            selectedEdgeId: selectedEdgeId,
            selectedThicknessId: selectedThicknessId,
            selectedColorId: selectedColorId
        });
        
        // Sync with global edgeFinishing object (from parent scope)
        if (typeof window.edgeFinishing !== 'undefined') {
            window.edgeFinishing.edge_id = selectedEdgeId;
            window.edgeFinishing.thickness_id = selectedThicknessId;
            window.edgeFinishing.color_id = selectedColorId;
            window.edgeFinishing.selected_edges = @json($selectedEdges);
        }
        
        // Also sync with local edgeFinishing if exists
        if (typeof edgeFinishing !== 'undefined') {
            edgeFinishing.edge_id = selectedEdgeId;
            edgeFinishing.thickness_id = selectedThicknessId;
            edgeFinishing.color_id = selectedColorId;
            edgeFinishing.selected_edges = @json($selectedEdges);
        }

        // Edge Profile Selection - Remove old listeners first by cloning
        const edgeProfileCards = document.querySelectorAll('.edge-profile-card');
        if (edgeProfileCards.length === 0) {
            console.warn('No edge profile cards found');
            return;
        }
        
        edgeProfileCards.forEach(card => {
            const newCard = card.cloneNode(true);
            if (card.parentNode) {
                card.parentNode.replaceChild(newCard, card);
            }
        });

        // Add fresh event listeners to edge profile cards
        document.querySelectorAll('.edge-profile-card').forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const edgeId = this.getAttribute('data-id');
                const edgeName = this.getAttribute('data-name');
                if (!edgeId) {
                    console.error('Edge ID not found');
                    return;
                }

                console.log('Edge Profile clicked:', {
                    edgeId: edgeId,
                    edgeName: edgeName
                });

                selectedEdgeId = edgeId;
                selectedEdgeName = edgeName || '';
                
                // Update UI - Remove selected class from all cards
                document.querySelectorAll('.edge-profile-card').forEach(c => {
                    if (c && c.classList) {
                        c.classList.remove('selected');
                    }
                });
                
                // Add selected class to clicked card
                if (this && this.classList) {
                    this.classList.add('selected');
                }

                // Update global object (must be defined in parent scope)
                if (typeof window.edgeFinishing !== 'undefined') {
                    window.edgeFinishing.edge_id = edgeId;
                }
                
                // Also update local edgeFinishing if exists
                if (typeof edgeFinishing !== 'undefined') {
                    edgeFinishing.edge_id = edgeId;
                }

                // Hide thickness, color and edges sections for now
                const thicknessSection = document.getElementById('thickness-section');
                const colorSection = document.getElementById('color-section');
                const edgesSection = document.getElementById('edges-selection-section');
                const summarySection = document.getElementById('selection-summary');
                if (thicknessSection) thicknessSection.style.display = 'none';
                if (colorSection) colorSection.style.display = 'none';
                if (edgesSection) edgesSection.style.display = 'none';
                if (summarySection) summarySection.style.display = 'none';
                
                // Update summary
                updateSummary();
                
                // Save to session
                saveEdgeFinishingToSession();
                
                console.log('Edge Profile selected:', edgeId);
            });
        });

        // Load Thicknesses
        function loadThicknesses(edgeProfileId, materialTypeId) {
            console.log('loadThicknesses called with:', { edgeProfileId, materialTypeId });
            
            if (!edgeProfileId || !materialTypeId) {
                console.error('Missing parameters:', { edgeProfileId, materialTypeId });
                alert('Missing required parameters. Please refresh and try again.');
                return;
            }

            const thicknessSelect = document.getElementById('edge-thickness-select');
            if (!thicknessSelect) {
                console.error('Thickness select element not found');
                return;
            }

            thicknessSelect.innerHTML = '<option value="">Loading...</option>';
            thicknessSelect.disabled = true;

            const url = `{{ route('calculator.edge.thicknesses') }}?edge_profile_id=${edgeProfileId}&material_type_id=${materialTypeId}`;
            console.log('Fetching thicknesses from:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Thicknesses data received:', data);
                thicknessSelect.innerHTML = '<option value="">-- Select Thickness --</option>';
                
                if (data.thicknesses && data.thicknesses.length > 0) {
                    console.log('Adding thicknesses:', data.thicknesses.length);
                    data.thicknesses.forEach(thickness => {
                        const option = document.createElement('option');
                        option.value = thickness.id;
                        option.textContent = thickness.value || `Thickness ${thickness.id}`;
                        if (selectedThicknessId == thickness.id) {
                            option.selected = true;
                            selectedThicknessValue = thickness.value;
                        }
                        thicknessSelect.appendChild(option);
                    });
                    console.log('Thicknesses loaded successfully');
                } else {
                    console.warn('No thicknesses found');
                    thicknessSelect.innerHTML = '<option value="">No thicknesses available for this combination</option>';
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
                thicknessSelect.innerHTML = '<option value="">Error loading thicknesses. Please try again.</option>';
                thicknessSelect.disabled = false;
                alert('Error loading thicknesses. Please check console for details.');
            });
        }

        // Thickness Selection
        const thicknessSelect = document.getElementById('edge-thickness-select');
        if (thicknessSelect) {
            thicknessSelect.addEventListener('change', function() {
                selectedThicknessId = this.value;
                selectedThicknessValue = this.options[this.selectedIndex]?.textContent || '';
                selectedColorId = null;
                selectedColorName = '';
                
            // Update global object
            if (typeof window.edgeFinishing !== 'undefined') {
                window.edgeFinishing.thickness_id = this.value;
                window.edgeFinishing.color_id = null;
            }
            if (typeof edgeFinishing !== 'undefined') {
                edgeFinishing.thickness_id = this.value;
                edgeFinishing.color_id = null;
            }
                
                if (this.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    
                    // Show color section
                    const colorSection = document.getElementById('color-section');
                    if (colorSection) {
                        colorSection.style.display = 'block';
                    }
                    
                    // Hide edges section
                    const edgesSection = document.getElementById('edges-selection-section');
                    const summarySection = document.getElementById('selection-summary');
                    if (edgesSection) edgesSection.style.display = 'none';
                    if (summarySection) summarySection.style.display = 'none';
                    
                    // Reset color dropdown
                    const colorSelect = document.getElementById('edge-color-select');
                    if (colorSelect) {
                        colorSelect.innerHTML = '<option value="">-- Select Color --</option>';
                        colorSelect.classList.remove('is-valid', 'is-invalid');
                        colorSelect.value = '';
                    }
                    
                    // Load colors
                    loadColors(selectedEdgeId, materialTypeId, this.value);
                } else {
                    this.classList.remove('is-valid');
                    const colorSection = document.getElementById('color-section');
                    const edgesSection = document.getElementById('edges-selection-section');
                    const summarySection = document.getElementById('selection-summary');
                    if (colorSection) colorSection.style.display = 'none';
                    if (edgesSection) edgesSection.style.display = 'none';
                    if (summarySection) summarySection.style.display = 'none';
                }
                
                // Update summary
                updateSummary();
                
                // Save to session
                saveEdgeFinishingToSession();
            });
        }

        // Load Colors
        function loadColors(edgeProfileId, materialTypeId, thicknessId) {
            if (!edgeProfileId || !materialTypeId || !thicknessId) return;

            const colorSelect = document.getElementById('edge-color-select');
            const colorSection = document.getElementById('color-section');
            
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
                colorSelect.innerHTML = '<option value="">-- Select Color --</option>';
                
                if (data.colors && data.colors.length > 0) {
                    data.colors.forEach(color => {
                        const option = document.createElement('option');
                        option.value = color.id;
                        option.textContent = color.name;
                        if (selectedColorId == color.id) {
                            option.selected = true;
                            selectedColorName = color.name;
                        }
                        colorSelect.appendChild(option);
                    });
                } else {
                    colorSelect.innerHTML = '<option value="">No colors available</option>';
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
                selectedColorName = this.options[this.selectedIndex]?.textContent || '';
                
            // Update global object
            if (typeof window.edgeFinishing !== 'undefined') {
                window.edgeFinishing.color_id = this.value;
            }
            if (typeof edgeFinishing !== 'undefined') {
                edgeFinishing.color_id = this.value;
            }
                
                if (this.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    
                    // Show edges section and summary
                    const edgesSection = document.getElementById('edges-selection-section');
                    const summarySection = document.getElementById('selection-summary');
                    if (edgesSection) edgesSection.style.display = 'block';
                    if (summarySection) summarySection.style.display = 'block';
                } else {
                    this.classList.remove('is-valid');
                    const edgesSection = document.getElementById('edges-selection-section');
                    const summarySection = document.getElementById('selection-summary');
                    if (edgesSection) edgesSection.style.display = 'none';
                    if (summarySection) summarySection.style.display = 'none';
                }
                
                // Update summary
                updateSummary();
                
                // Save to session
                saveEdgeFinishingToSession();
            });
        }

        // Edge Circle Selection
        document.querySelectorAll('.edge-circle').forEach(circle => {
            circle.addEventListener('click', function() {
                const edge = this.getAttribute('data-edge');
                if (!edge) return;

            const selectedEdges = (window.edgeFinishing && window.edgeFinishing.selected_edges) || 
                                   (edgeFinishing && edgeFinishing.selected_edges) || [];
            
            if (!selectedEdges) {
                if (window.edgeFinishing) window.edgeFinishing.selected_edges = [];
                if (edgeFinishing) edgeFinishing.selected_edges = [];
            }

            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                if (window.edgeFinishing && window.edgeFinishing.selected_edges) {
                    window.edgeFinishing.selected_edges = window.edgeFinishing.selected_edges.filter(e => e !== edge);
                }
                if (edgeFinishing && edgeFinishing.selected_edges) {
                    edgeFinishing.selected_edges = edgeFinishing.selected_edges.filter(e => e !== edge);
                }
            } else {
                this.classList.add('selected');
                if (window.edgeFinishing) {
                    if (!window.edgeFinishing.selected_edges) window.edgeFinishing.selected_edges = [];
                    window.edgeFinishing.selected_edges.push(edge);
                }
                if (edgeFinishing) {
                    if (!edgeFinishing.selected_edges) edgeFinishing.selected_edges = [];
                    edgeFinishing.selected_edges.push(edge);
                }
            }
            
            // Update selected edges display
            updateSelectedEdgesDisplay();
            
            // Save to session
            saveEdgeFinishingToSession();
            });
        });
        
        // Update selected edges display
        function updateSelectedEdgesDisplay() {
            const selectedEdgesList = document.getElementById('selected-edges-list');
            if (!selectedEdgesList) return;
            
            const selectedEdges = (window.edgeFinishing && window.edgeFinishing.selected_edges) || 
                                   (edgeFinishing && edgeFinishing.selected_edges) || [];
            
            if (selectedEdges && selectedEdges.length > 0) {
                selectedEdgesList.innerHTML = selectedEdges.map(edge => 
                    `<span class="badge bg-success me-2 mb-2">${edge.charAt(0).toUpperCase() + edge.slice(1)}</span>`
                ).join('');
            } else {
                selectedEdgesList.innerHTML = '<p class="text-muted">No edges selected yet.</p>';
            }
        }
        
        // Update summary
        function updateSummary() {
            const summaryEdge = document.getElementById('summary-edge-profile');
            const summaryThickness = document.getElementById('summary-thickness');
            const summaryColor = document.getElementById('summary-color');
            
            if (summaryEdge) summaryEdge.textContent = selectedEdgeName || '-';
            if (summaryThickness) summaryThickness.textContent = selectedThicknessValue || '-';
            if (summaryColor) summaryColor.textContent = selectedColorName || '-';
        }
        
        // Save edge finishing to session
        function saveEdgeFinishingToSession() {
            const selectedEdges = (window.edgeFinishing && window.edgeFinishing.selected_edges) || 
                                   (edgeFinishing && edgeFinishing.selected_edges) || [];
            
            const data = {
                edge_id: selectedEdgeId,
                thickness_id: selectedThicknessId,
                color_id: selectedColorId,
                selected_edges: selectedEdges
            };
            
            // Update global object
            if (typeof window.edgeFinishing !== 'undefined') {
                window.edgeFinishing.edge_id = selectedEdgeId;
                window.edgeFinishing.thickness_id = selectedThicknessId;
                window.edgeFinishing.color_id = selectedColorId;
                window.edgeFinishing.selected_edges = selectedEdges;
            }
            
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
            const selectedCard = document.querySelector(`.edge-profile-card[data-id="${selectedEdgeId}"]`);
            if (selectedCard) {
                selectedCard.click();
            }
        }
        
        // Initialize selected edges display
        updateSelectedEdgesDisplay();
        updateSummary();
    }, 100); // Small delay to ensure DOM is ready
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
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>


@php
$backWall = session('back_wall', [
'wall_id' => null,
'selected_edges' => []
]) ?? [];
$selectedWallId = $backWall['wall_id'] ?? null;
$selectedEdges = $backWall['selected_edges'] ?? [];

// Shapes list (coming from backsplash_shapes)
$backsplashShapes = $wall ?? collect();
@endphp

<div class="materials">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="mb-4 fw-bold">Select Back Wall Shape</h4>
            <div class="row">
                @forelse($backsplashShapes as $index => $shape)
                <div class="col-md-4 mb-4">
                    <div class="p-0 card border rounded position-relative wall-card {{ $selectedWallId == $shape->id ? 'selected' : '' }}"
                        data-id="{{ $shape->id }}" data-name="{{ $shape->name }}">
                        @if($shape->image)
                        <img src="{{ asset('uploads/backsplash-shape/' . $shape->image) }}" class="card-img-top"
                            alt="{{ $shape->name }}" style="height: 200px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                        @endif
                        <div class="card-body text-center p-3">
                            <h6 class="mb-0 fw-bold">{{ $shape->name }}</h6>
                            <small class="text-muted">Click to select</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning">No back wall shapes available.</div>
                </div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-12 mt-5 mb-5 Blad-01">
            <div class="measurement-cl">
                <div class="hori-mas-box mb-5 d-flex align-items-center justify-content-center">
                    <div class="hornumber">
                        <input type="text" class="form-control width-input" id="width1" placeholder="Width (cm)"
                            value="">
                    </div>
                </div>
                <div class="prod-box-bottom d-flex align-items-center justify-content-between gap-5">
                    <div class="prod-box-mid d-flex align-items-center justify-content-center position-relative">
                        <span class="left-ci-01 dotline"></span>
                        Blad 01
                        <span class="right-ci-01 dotline"></span>
                        <span class="right-ci-02 dotline btmdot"></span>
                    </div>
                    <div class="prod-box-rht">
                        <div class="inpnumber">
                            <input type="text" class="form-control height-input" id="height1" placeholder="Height (cm)"
                                value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sides selection: show after shape is selected -->
        <div class="col-lg-12 mt-5" id="sides-selection-section" style="{{ $selectedWallId ? '' : 'display:none;' }}">
            <hr>
            <div class="row">
                <div class="col-lg-12 mb-5">
                    <div class="tabheader d-flex align-items-start mb-4">
                        <figure class="me-3 pr-s-img">
                            <img src="{{ asset('assets/img/18.png') }}" width="50">
                        </figure>
                        <div>
                            <h3 class="fs-4 fw-bold mb-1">Select Sides for Back Wall Finishing</h3>
                            <p class="text-success small mb-0">The Green Sides Are Delivered Finished As Standard.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-5">
                    <div class="row g-5">
                        <div class="col-lg-6">
                            <div class="border-btm-green edges-check-box d-flex align-items-center justify-content-center position-relative p-4"
                                style="min-height: 200px;">
                                <div class="text-center">
                                    <h5 class="mb-3">Blad 01</h5>
                                    <span
                                        class="left-11-cir edge-circle {{ in_array('left', $selectedEdges) ? 'selected' : '' }}"
                                        data-edge="left" title="Left Side"></span>
                                    <span
                                        class="right-11-cir edge-circle {{ in_array('right', $selectedEdges) ? 'selected' : '' }}"
                                        data-edge="right" title="Right Side"></span>
                                    <span
                                        class="top-11-cir edge-circle {{ in_array('top', $selectedEdges) ? 'selected' : '' }}"
                                        data-edge="top" title="Top Side"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="w-100">
                                <h6 class="mb-3">Selected Sides:</h6>
                                <div id="selected-sides-list">
                                    @if(count($selectedEdges) > 0)
                                    @foreach($selectedEdges as $edge)
                                    <span class="badge bg-success me-2 mb-2">{{ ucfirst($edge) }}</span>
                                    @endforeach
                                    @else
                                    <p class="text-muted mb-0">No sides selected yet.</p>
                                    @endif
                                </div>
                            </div>
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

    setTimeout(function() {
        let selectedWallId = @json($selectedWallId);
        let selectedEdges = @json($selectedEdges);

        // Sync with global backWall object
        if (typeof window.backWall !== 'undefined') {
            window.backWall.wall_id = selectedWallId;
            window.backWall.selected_edges = selectedEdges;
        }
        if (typeof backWall !== 'undefined') {
            backWall.wall_id = selectedWallId;
            backWall.selected_edges = selectedEdges;
        }

        // Remove old listeners by cloning
        const wallCards = document.querySelectorAll('.wall-card');
        wallCards.forEach(card => {
            const newCard = card.cloneNode(true);
            if (card.parentNode) {
                card.parentNode.replaceChild(newCard, card);
            }
        });

        // Add fresh listeners
        document.querySelectorAll('.wall-card').forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const wallId = this.getAttribute('data-id');
                const wallName = this.getAttribute('data-name');
                if (!wallId) {
                    console.error('Wall ID not found');
                    return;
                }

                // Update selection
                selectedWallId = wallId;

                document.querySelectorAll('.wall-card').forEach(c => c.classList.remove(
                    'selected'));
                this.classList.add('selected');

                // Update global/local object
                if (typeof window.backWall !== 'undefined') {
                    window.backWall.wall_id = wallId;
                }
                if (typeof backWall !== 'undefined') {
                    backWall.wall_id = wallId;
                }

                // Show sides section
                const sidesSection = document.getElementById('sides-selection-section');
                if (sidesSection) sidesSection.style.display = 'block';

                // Save to session
                saveBackWallToSession();
            });
        });

        // Edge circle selection
        document.querySelectorAll('.edge-circle').forEach(circle => {
            circle.addEventListener('click', function() {
                const edge = this.getAttribute('data-edge');
                if (!edge) return;

                const ef = window.backWall || backWall;
                if (!ef) return;

                if (!ef.selected_edges) ef.selected_edges = [];

                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    ef.selected_edges = ef.selected_edges.filter(e => e !== edge);
                } else {
                    this.classList.add('selected');
                    ef.selected_edges.push(edge);
                }

                updateSelectedSidesDisplay();
                saveBackWallToSession();
            });
        });

        function updateSelectedSidesDisplay() {
            const selectedSidesList = document.getElementById('selected-sides-list');
            if (!selectedSidesList) return;

            const ef = window.backWall || backWall;
            const edges = (ef && ef.selected_edges) || [];

            if (edges.length > 0) {
                selectedSidesList.innerHTML = edges.map(edge =>
                    `<span class="badge bg-success me-2 mb-2">${edge.charAt(0).toUpperCase() + edge.slice(1)}</span>`
                ).join('');
            } else {
                selectedSidesList.innerHTML = '<p class="text-muted mb-0">No sides selected yet.</p>';
            }
        }

        function saveBackWallToSession() {
            const ef = window.backWall || backWall;
            if (!ef) return;

            fetch("{{ route('calculator.steps') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    step: 5,
                    back_wall: {
                        wall_id: selectedWallId,
                        selected_edges: ef.selected_edges || []
                    }
                })
            }).catch(err => console.error('Failed to save back wall:', err));
        }

        // Restore selection
        if (selectedWallId) {
            const selectedCard = document.querySelector(`.wall-card[data-id="${selectedWallId}"]`);
            if (selectedCard) selectedCard.classList.add('selected');
            const sidesSection = document.getElementById('sides-selection-section');
            if (sidesSection) sidesSection.style.display = 'block';
        }

        updateSelectedSidesDisplay();
    }, 100);
})();
</script>

<style>
.wall-card {
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 240px;
}

.wall-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.wall-card.selected {
    border: 3px solid #28a745 !important;
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.5) !important;
    background-color: #f8fff9;
}

.wall-card.selected::after {
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

.border-btm-green {
    border: 2px solid #28a745;
    border-radius: 8px;
    background: #f8fff9;
}
</style>
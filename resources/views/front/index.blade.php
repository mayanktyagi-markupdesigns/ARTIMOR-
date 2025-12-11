@extends('front.layouts.app')
@section('content')

@php
$selectedMaterialId = $selectedMaterialId ?? session('selected_material_id');
$selectedMaterialTypeId = $selectedMaterialTypeId ?? session('selected_material_type_id');
$selectedLayoutId = $selectedLayoutId ?? session('selected_layout_id');
@endphp

<div class="steps">
    <div class="step stepper1 active step-click" data-step="1">
        <div class="icon"><span>01</span>
            <img src="{{ asset('assets/front/img/01.png') }}" width="28" height="28">
        </div>
        <p>Material Price</p>
    </div>
    <div class="step stepper2 step-click" data-step="2">
        <div class="icon"><span>02</span>
            <img src="{{ asset('assets/front/img/03.png') }}" width="28" height="28">
        </div>
        <p>Choose Layout</p>
    </div>
    <div class="step stepper3 step-click" data-step="3">
        <div class="icon"><span>03</span>
            <img src="{{ asset('assets/front/img/04.png') }}" width="28" height="28">
        </div>
        <p>Dimensions</p>
    </div>
    <div class="step stepper4 step-click" data-step="4">
        <div class="icon"><span>04</span>
            <img src="{{ asset('assets/front/img/05.png') }}" width="28" height="28">
        </div>
        <p>Edge Finishing</p>
    </div>
    <div class="step stepper5 step-click" data-step="5">
        <div class="icon"><span>05</span>
            <img src="{{ asset('assets/front/img/06.png') }}" width="28" height="28">
        </div>
        <p>Back Wall</p>
    </div>
    <div class="step stepper6 step-click" data-step="6">
        <div class="icon"><span>06</span>
            <img src="{{ asset('assets/front/img/07.png') }}" width="28" height="28">
        </div>
        <p>Sink</p>
    </div>
    <div class="step stepper7 step-click" data-step="7">
        <div class="icon"><span>07</span>
            <img src="{{ asset('assets/front/img/08.png') }}" width="28" height="28">
        </div>
        <p>Cut Outs</p>
    </div>
    <div class="step stepper8 step-click" data-step="8">
        <div class="icon"><span>08</span>
            <img src="{{ asset('assets/front/img/09.png') }}" width="28" height="28">
        </div>
        <p>Overview</p>
    </div>
</div>

<div class="materials">
    <div id="step1" class="tab-content show active">
        @include('front.partials.material-price', [
        'materialGroups' => $materialCategories,
        'materialTypesByGroup' => $materialsByCategory,
        'selectedMaterialId' => $selectedMaterialId ?? null,
        'selectedMaterialTypeId' => $selectedMaterialTypeId ?? null,
        ])
    </div>

    <div id="step2" class="tab-content fade hidden">

    </div>
    <div id="step3" class="tab-content fade hidden">

    </div>
    <div id="step4" class="tab-content fade hidden">

    </div>
    <div id="step5" class="tab-content fade hidden">

    </div>
    <div id="step6" class="tab-content fade hidden">

    </div>
    <div id="step7" class="tab-content fade hidden">

    </div>
    <div id="step8" class="tab-content fade hidden">

    </div>


</div>
</div>
</div>
</div>
</div>
<!-- Next Step Button -->
<div class="text-center my-5 d-flex align-items-center justify-content-center gap-4">
    <a href="{{ route('home') }}" class="btn btn-secondary cancel-btn">Step Back</a>
    <button id="nextStepBtn" class="btn btn-dark btn-primary px-4" data-step="2">Next Step</button>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; flex-direction: column;">
    <div class="text-center text-white">
        <div class="spinner-border mb-3" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p style="font-size: 18px; font-weight: 500;">Loading...</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ==============================
    // CLICKABLE STEPPER NAVIGATION
    // ==============================
    document.querySelectorAll('.step-click').forEach(stepBtn => {
        stepBtn.addEventListener('click', function() {

            const targetStep = parseInt(this.getAttribute('data-step'));

            // ✅ Forward validation (same as Next button)
            // Step 1 to Step 2: Material configuration must be complete
            if (targetStep > 1 && targetStep <= 2) {
                if (!materialSelection.material_type_id || !materialSelection.color || !materialSelection.finish || !materialSelection.thickness) {
                    alert('Please complete material configuration first.');
                    return;
                }
            }
            // Step 2 to Step 3: Layout must be selected
            if (targetStep > 2 && targetStep <= 3) {
                if (!selectedLayoutId) {
                    // Scroll to layout section
                    const layoutSection = document.getElementById('step2');
                    if (layoutSection) {
                        layoutSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                    return;
                }
            }
            // Step 3 to Step 4: Dimensions must be entered
            if (targetStep > 3 && targetStep <= 4) {
                if (!dimensions.blad1.width || !dimensions.blad1.height || 
                    isNaN(dimensions.blad1.width) || isNaN(dimensions.blad1.height) ||
                    parseFloat(dimensions.blad1.width) <= 0 || parseFloat(dimensions.blad1.height) <= 0) {
                    alert('Please enter Width and Height.');
                    return;
                }
            }

            // Show loading overlay
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) {
                loadingOverlay.style.display = 'flex';
            }

            const data = {
                step: targetStep
            };
            if (targetStep >= 2) data.material_id = selectedMaterialId;
            if (targetStep >= 3) data.material_type_id = selectedMaterialTypeId;
            if (targetStep >= 4) data.layout_id = selectedLayoutId;

            fetch("{{ route('calculator.steps') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.text())
                .then(html => {

                    // ✅ Load content of clicked step
                    document.getElementById('step' + targetStep).innerHTML = html;

                    // ✅ Switch active view
                    for (let i = 1; i <= 9; i++) {
                        const div = document.getElementById('step' + i);
                        const stepper = document.querySelector('.stepper' + i);

                        if (i === targetStep) {
                            if (div) {
                                div.classList.remove('hidden');
                                div.classList.add('show', 'active');
                            }
                            if (stepper) {
                                stepper.classList.add('active');
                            }
                        } else {
                            if (div) {
                                div.classList.add('hidden');
                                div.classList.remove('show', 'active');
                            }
                            if (stepper) {
                                stepper.classList.remove('active');
                            }
                        }
                    }

                    // ✅ Sync Next button
                    nextStepBtn.setAttribute('data-step', targetStep + 1);
                    nextStepBtn.style.display = (targetStep === 9) ? 'none' :
                        'inline-block';

                    // ✅ Re-init step logic
                    if (targetStep === 2) {
                        setTimeout(() => initializeLayoutCards(), 100);
                    }
                    if (targetStep === 3) initializeDimensionInputs();
                    if (targetStep === 4) initializeEdgeFinishing();
                    if (targetStep === 5) initializeBackWall();
                    if (targetStep === 6) initializeSinkSelection();
                    if (targetStep === 7) initializeCutoutSelection();
                    if (targetStep === 8) initializePersonalDataForm();

                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to load step.');
                })
                .finally(() => {
                    // Hide loading overlay
                    const loadingOverlay = document.getElementById('loadingOverlay');
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'none';
                    }
                });
        });
    });

    const nextStepBtn = document.getElementById('nextStepBtn');
    const materialTabButtons = document.querySelectorAll('#materialsTab button[data-bs-toggle="tab"]');

    materialTabButtons.forEach((button) => {
        button.addEventListener('shown.bs.tab', (event) => {
            const targetSelector = event.target.getAttribute('data-bs-target');
            document.querySelectorAll('#materialsTabContent .tab-pane').forEach((pane) => {
                if ('#' + pane.id === targetSelector) {
                    pane.classList.add('show', 'active');
                } else {
                    pane.classList.remove('show', 'active');
                }
            });
        });
    });

    const initialMaterialId = @json($selectedMaterialId);
    console.log(initialMaterialId);
    //let selectedMaterialId = initialMaterialId ? String(initialMaterialId) : null;
    window.selectedMaterialId = initialMaterialId ? String(initialMaterialId) : null;
    const initialMaterialTypeId = @json($selectedMaterialTypeId);
    //let selectedMaterialTypeId = initialMaterialTypeId ? String(initialMaterialTypeId) : null;
    window.selectedMaterialTypeId = initialMaterialTypeId ? String(initialMaterialTypeId) : null;
    const initialLayoutId = @json($selectedLayoutId);
    let selectedLayoutId = initialLayoutId ? String(initialLayoutId) : null;
    let dimensions = {
        blad1: {
            width: null,
            height: null
        }
    };
    window.edgeFinishing = {
        edge_id: null,
        thickness_id: null,
        color_id: null,
        selected_edges: []
    };
    window.backWall = {
        wall_id: null,
        selected_edges: []
    };
    let backWall = window.backWall;
    let sinkSelection = {
        sink_id: null,
        cutout: null,
        number: null
    };
    let cutoutSelection = {
        cutout_id: null,
        recess_type: null
    };
    let userDetails = {
        first_name: null,
        last_name: null,
        phone_number: null,
        email: null,
        delivery_option: null,
        measurement_time: null,
        promo_code: null
    };

    // Utility function to clean up modal backdrops
    function cleanupModalBackdrop() {
        setTimeout(() => {
            // Remove all backdrops
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());

            // Reset body classes and styles
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }, 100);
    }

    // Function to initialize material card selection
    function initializeMaterialCards() {
        const materialCards = document.querySelectorAll('.material-card');
        materialCards.forEach(card => {
            card.addEventListener('click', function() {
                const materialId = this.getAttribute('data-id');
                selectedMaterialId = materialId ? String(materialId) : null;
                selectedMaterialTypeId = null;
                selectedLayoutId = null;
                materialCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    }

    // Function to initialize layout card selection
    function initializeLayoutCards() {
        // Wait a bit for DOM to be ready
        setTimeout(() => {
            const layoutCards = document.querySelectorAll('.layout-card');
            if (!layoutCards || layoutCards.length === 0) {
                selectedLayoutId = null;
                return;
            }

            // Add event listeners directly (no cloning needed)
            layoutCards.forEach(card => {
                // Remove existing listener if any
                const newCard = card.cloneNode(true);
                if (card.parentNode) {
                    card.parentNode.replaceChild(newCard, card);
                }

                // Add click listener to new card
                newCard.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const layoutId = this.getAttribute('data-id');
                    if (!layoutId) return;

                    selectedLayoutId = String(layoutId);
                    
                    // Update UI - remove all selections
                    document.querySelectorAll('.layout-card').forEach(c => {
                        if (c && c.classList) {
                            c.classList.remove('selected');
                            // Remove any existing confirmation badge
                            const existingBadge = c.querySelector('.layout-confirmation-badge');
                            if (existingBadge) existingBadge.remove();
                        }
                    });
                    
                    // Add selected state to clicked card
                    if (this && this.classList) {
                        this.classList.add('selected');
                        
                        // Add confirmation badge
                        if (!this.querySelector('.layout-confirmation-badge')) {
                            const badge = document.createElement('span');
                            badge.className = 'layout-confirmation-badge';
                            badge.innerHTML = '✓ Selected';
                            badge.style.cssText = 'position: absolute; top: 10px; left: 10px; background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; z-index: 10;';
                            if (this.style) {
                                this.style.position = 'relative';
                            }
                            this.appendChild(badge);
                        }
                    }

                    // Save to session immediately
                    fetch("{{ route('calculator.steps') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            step: 2,
                            layout_id: selectedLayoutId
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            console.log('Layout saved to session:', selectedLayoutId);
                        }
                    })
                    .catch(err => {
                        console.error('Failed to save layout:', err);
                    });

                    console.log('Layout selected:', selectedLayoutId);
                });
            });

            // Restore selected state if exists
            if (selectedLayoutId) {
                const activeLayoutCard = document.querySelector(`.layout-card[data-id="${selectedLayoutId}"]`);
                if (activeLayoutCard && activeLayoutCard.classList) {
                    activeLayoutCard.classList.add('selected');
                    // Add confirmation badge if not exists
                    if (!activeLayoutCard.querySelector('.layout-confirmation-badge')) {
                        const badge = document.createElement('span');
                        badge.className = 'layout-confirmation-badge';
                        badge.innerHTML = '✓ Selected';
                        badge.style.cssText = 'position: absolute; top: 10px; left: 10px; background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; z-index: 10;';
                        if (activeLayoutCard.style) {
                            activeLayoutCard.style.position = 'relative';
                        }
                        activeLayoutCard.appendChild(badge);
                    }
                }
            }
        }, 100);
    }

    // Function to initialize dimension inputs
    function initializeDimensionInputs() {
        const width1Input = document.getElementById('width1');
        const height1Input = document.getElementById('height1');

        if (width1Input && height1Input) {
            // Restore values if exist
            if (dimensions.blad1.width) width1Input.value = dimensions.blad1.width;
            if (dimensions.blad1.height) height1Input.value = dimensions.blad1.height;

            width1Input.addEventListener('input', function() {
                dimensions.blad1.width = this.value;
                validateDimensions();
            });
            
            height1Input.addEventListener('input', function() {
                dimensions.blad1.height = this.value;
                validateDimensions();
            });

            // Validate on blur
            width1Input.addEventListener('blur', validateDimensions);
            height1Input.addEventListener('blur', validateDimensions);
        }
    }

    // Validate dimensions
    function validateDimensions() {
        const width = parseFloat(dimensions.blad1.width);
        const height = parseFloat(dimensions.blad1.height);
        
        const widthInput = document.getElementById('width1');
        const heightInput = document.getElementById('height1');

        if (widthInput && heightInput) {
            if (width && width > 0) {
                widthInput.classList.remove('is-invalid');
                widthInput.classList.add('is-valid');
            } else if (dimensions.blad1.width) {
                widthInput.classList.remove('is-valid');
                widthInput.classList.add('is-invalid');
            }

            if (height && height > 0) {
                heightInput.classList.remove('is-invalid');
                heightInput.classList.add('is-valid');
            } else if (dimensions.blad1.height) {
                heightInput.classList.remove('is-valid');
                heightInput.classList.add('is-invalid');
            }
        }
    }

    // Function to initialize edge finishing selections
    function initializeEdgeFinishing() {
        // Edge finishing is now handled in the blade file itself
        // Just sync the global edgeFinishing object with the form
        setTimeout(() => {
            const ef = window.edgeFinishing || edgeFinishing;
            const edgeIdInput = document.querySelector('.edge-profile-card.selected');
            const thicknessSelect = document.getElementById('edge-thickness-select');
            const colorSelect = document.getElementById('edge-color-select');
            const edgeCircles = document.querySelectorAll('.edge-circle');

            // Sync edge_id
            if (edgeIdInput && ef) {
                ef.edge_id = edgeIdInput.getAttribute('data-id');
            }

            // Sync thickness_id
            if (thicknessSelect && ef) {
                ef.thickness_id = thicknessSelect.value;
                thicknessSelect.addEventListener('change', function() {
                    if (ef) ef.thickness_id = this.value;
                    // Save to session
                    saveEdgeFinishingToSession();
                });
            }

            // Sync color_id
            if (colorSelect && ef) {
                ef.color_id = colorSelect.value;
                colorSelect.addEventListener('change', function() {
                    if (ef) ef.color_id = this.value;
                    // Save to session
                    saveEdgeFinishingToSession();
                });
            }

            // Sync edge circles
            edgeCircles.forEach(circle => {
                circle.addEventListener('click', function() {
                    const edge = this.getAttribute('data-edge');
                    if (!edge || !ef) return;

                    if (!ef.selected_edges) {
                        ef.selected_edges = [];
                    }

                    if (ef.selected_edges.includes(edge)) {
                        ef.selected_edges = ef.selected_edges.filter(e => e !== edge);
                        this.classList.remove('selected');
                    } else {
                        ef.selected_edges.push(edge);
                        this.classList.add('selected');
                    }
                    
                    // Save to session
                    saveEdgeFinishingToSession();
                });
            });

            // Listen for edge profile card clicks (handled in blade but sync here)
            document.querySelectorAll('.edge-profile-card').forEach(card => {
                card.addEventListener('click', function() {
                    const edgeId = this.getAttribute('data-id');
                    if (edgeId && ef) {
                        ef.edge_id = edgeId;
                        // Save to session
                        saveEdgeFinishingToSession();
                    }
                });
            });
        }, 200);
    }

    // Save edge finishing to session
    function saveEdgeFinishingToSession() {
        const ef = window.edgeFinishing || edgeFinishing;
        if (!ef) return;
        
        fetch("{{ route('calculator.steps') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                step: 4,
                edge_finishing: ef
            })
        }).catch(err => console.error('Failed to save edge finishing:', err));
    }

    // Function to initialize back wall selections
    function initializeBackWall() {
        // Back wall is now handled in the blade file itself
        // Just sync the global backWall object
        setTimeout(() => {
            const ef = window.backWall || backWall;
            const wallIdInput = document.querySelector('.wall-card.selected');
            const edgeCircles = document.querySelectorAll('.edge-circle');

            // Sync wall_id
            if (wallIdInput && ef) {
                ef.wall_id = wallIdInput.getAttribute('data-id');
            }

            // Sync edge circles
            edgeCircles.forEach(circle => {
                circle.addEventListener('click', function() {
                    const edge = this.getAttribute('data-edge');
                    if (!edge || !ef) return;

                    if (!ef.selected_edges) {
                        ef.selected_edges = [];
                    }

                    if (ef.selected_edges.includes(edge)) {
                        ef.selected_edges = ef.selected_edges.filter(e => e !== edge);
                        this.classList.remove('selected');
                    } else {
                        ef.selected_edges.push(edge);
                        this.classList.add('selected');
                    }
                    
                    // Save to session
                    saveBackWallToSession();
                });
            });

            // Listen for wall card clicks (handled in blade but sync here)
            document.querySelectorAll('.wall-card').forEach(card => {
                card.addEventListener('click', function() {
                    const wallId = this.getAttribute('data-id');
                    if (wallId && ef) {
                        ef.wall_id = wallId;
                        // Save to session
                        saveBackWallToSession();
                    }
                });
            });
        }, 200);
    }
    
    // Save back wall to session
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
                back_wall: ef
            })
        }).catch(err => console.error('Failed to save back wall:', err));
    }

    // Function to initialize sink selections
    function initializeSinkSelection() {
        const confirmButtons = document.querySelectorAll('.confirm-sink');
        confirmButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                const sinkId = this.getAttribute('data-sink-id');
                const modal = this.closest('.modal');
                const cutoutSelect = modal.querySelector('.sink-cutout[data-sink-id="' +
                    sinkId + '"]');
                const numberInput = modal.querySelector('.sink-number[data-sink-id="' + sinkId +
                    '"]');

                if (!cutoutSelect.value) {
                    alert('Please select a cutout type.');
                    return;
                }
                if (!numberInput.value || numberInput.value < 0 || numberInput.value > 10) {
                    alert('Please enter a valid number (0-10).');
                    return;
                }

                sinkSelection.sink_id = sinkId;
                sinkSelection.cutout = cutoutSelect.value;
                sinkSelection.number = parseInt(numberInput.value);

                document.querySelectorAll('.sink-card').forEach(card => {
                    card.classList.remove('selected');
                });
                const selectedCard = document.querySelector('.sink-card[data-id="' + sinkId +
                    '"]');
                if (selectedCard) {
                    selectedCard.classList.add('selected');
                }

                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                } else {
                    modal.style.display = 'none';
                    modal.setAttribute('aria-hidden', 'true');
                }

                cleanupModalBackdrop();
            });
        });

        document.addEventListener('hidden.bs.modal', cleanupModalBackdrop);
    }

    // Function to initialize cut-out selections
    function initializeCutoutSelection() {
        const confirmButtons = document.querySelectorAll('.confirm-cutout');
        confirmButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                const cutoutId = this.getAttribute('data-cutout-id');
                const modal = this.closest('.modal');
                const recessTypeSelect = modal.querySelector(
                    '.cutout-recess-type[data-cutout-id="' + cutoutId + '"]');

                if (!recessTypeSelect.value) {
                    alert('Please select a recess type.');
                    return;
                }

                cutoutSelection.cutout_id = cutoutId;
                cutoutSelection.recess_type = recessTypeSelect.value;

                document.querySelectorAll('.cutout-card').forEach(card => {
                    card.classList.remove('selected');
                });
                const selectedCard = document.querySelector('.cutout-card[data-id="' +
                    cutoutId + '"]');
                if (selectedCard) {
                    selectedCard.classList.add('selected');
                }

                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                } else {
                    modal.style.display = 'none';
                    modal.setAttribute('aria-hidden', 'true');
                }

                cleanupModalBackdrop();
            });
        });

        document.addEventListener('hidden.bs.modal', cleanupModalBackdrop);
    }

    // Function to initialize personal data form
    function initializePersonalDataForm() {
        const form = document.getElementById('customForm');
        if (form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                userDetails.first_name = document.getElementById('firstName').value;
                userDetails.last_name = document.getElementById('lastName').value;
                userDetails.phone_number = document.getElementById('phoneNumber').value;
                userDetails.email = document.getElementById('email').value;
                userDetails.delivery_option = document.getElementById('deliveryOption').value;
                userDetails.measurement_time = document.getElementById('measurementTime').value;
                userDetails.promo_code = document.getElementById('promoCode').value;

                // Validate required fields
                if (!userDetails.first_name || !userDetails.last_name || !userDetails.phone_number || !
                    userDetails.email || !userDetails.delivery_option || !userDetails.measurement_time
                ) {
                    alert('Please fill in all required fields.');
                    return;
                }

                // Send user details to server
                fetch("{{ route('calculator.submit') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            step: 9,
                            first_name: userDetails.first_name,
                            last_name: userDetails.last_name,
                            phone_number: userDetails.phone_number,
                            email: userDetails.email,
                            delivery_option: userDetails.delivery_option,
                            measurement_time: userDetails.measurement_time,
                            promo_code: userDetails.promo_code,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // alert('User details saved successfully!');
                            window.location.href = "{{ route('thank.you') }}";
                            // Optionally switch to Overview tab
                            const overviewTab = document.getElementById('overview-tab');
                            if (overviewTab) {
                                bootstrap.Tab.getOrCreateInstance(overviewTab).show();
                            }
                        } else {
                            alert('Error saving user details: ' + (data.error || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        alert('Error saving user details: ' + error);
                    });
            });
        }
    }

    // Initialize material cards on page load
    initializeMaterialCards();

    // Handle Next Step button click
    nextStepBtn.addEventListener('click', function() {
        const currentStep = parseInt(nextStepBtn.getAttribute('data-step'));

        // Prevent multiple clicks
        if (nextStepBtn.disabled) return;
        
        // ✅ STEP-1 VALIDATION: Material Price - Color, Finish, Thickness must be selected
        if (currentStep === 2) {
            if (!materialSelection.material_type_id || !materialSelection.color || !materialSelection.finish || !materialSelection.thickness) {
                // Show inline error - no alert
                const materialCards = document.querySelectorAll('.material-type-card');
                if (materialCards.length > 0) {
                    // Scroll to material section
                    document.getElementById('step1').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                return;
            }
        }

        // ✅ STEP-2 VALIDATION: Choose Layout - Layout must be selected
        if (currentStep === 3) {
            if (!selectedLayoutId) {
                // Scroll to layout section
                const layoutSection = document.getElementById('step2');
                if (layoutSection) {
                    layoutSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                // Show inline error - no alert
                return;
            }
        }

        // ✅ STEP-3 VALIDATION: Dimensions - Width and Height must be entered
        if (currentStep === 4) {
            if (!dimensions.blad1.width || !dimensions.blad1.height || 
                isNaN(dimensions.blad1.width) || isNaN(dimensions.blad1.height) ||
                parseFloat(dimensions.blad1.width) <= 0 || parseFloat(dimensions.blad1.height) <= 0) {
                alert("Please enter Width and Height");
                return;
            }
        }

        // ✅ STEP-4 VALIDATION: Edge Finishing - Only Edge Profile must be selected (for now)
        if (currentStep === 5) {
            // Use window.edgeFinishing if available, fallback to edgeFinishing
            const ef = window.edgeFinishing || edgeFinishing;
            
            if (!ef || !ef.edge_id) {
                // Scroll to edge finishing section
                const edgeSection = document.getElementById('step4');
                if (edgeSection) {
                    edgeSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                alert('Please select an Edge Profile.');
                return;
            }
        }

        // ✅ STEP-5 VALIDATION: Back Wall - Back Wall Shape must be selected
        if (currentStep === 6) {
            const bw = window.backWall || backWall;
            
            if (!bw || !bw.wall_id) {
                const backWallSection = document.getElementById('step5');
                if (backWallSection) {
                    backWallSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                alert('Please select a Back Wall Shape.');
                return;
            }
        }

        // Disable button and show loading
        nextStepBtn.disabled = true;
        const originalText = nextStepBtn.innerHTML;
        nextStepBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
        
        // Show loading overlay
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'flex';
        }

        const data = {
            step: currentStep
        };

        /* ✅ SEND FULL MATERIAL CONFIG ONLY ON STEP-1 */
        if (currentStep === 2) {
            data.material_config = materialSelection;
        }

        if (currentStep === 3) data.layout_id = selectedLayoutId;
        if (currentStep === 4) data.dimensions = dimensions;
        if (currentStep === 5) {
            const ef = window.edgeFinishing || edgeFinishing;
            data.edge_finishing = ef;
        }
        if (currentStep === 6) {
            const ef = window.backWall || backWall;
            data.back_wall = ef;
        }
        if (currentStep === 7) data.sink_selection = sinkSelection;
        if (currentStep === 8) data.cutout_selection = cutoutSelection;

        fetch("{{ route('calculator.steps') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(async response => {
                const text = await response.text();
                if (!response.ok) {
                    // Try to parse error message
                    try {
                        const json = JSON.parse(text);
                        throw new Error(json.error || json.message || 'Server error occurred');
                    } catch (e) {
                        throw new Error('Server error: ' + response.status + ' ' + response.statusText);
                    }
                }
                return text;
            })
            .then(html => {
                document.getElementById('step' + currentStep).innerHTML = html;

                for (let i = 1; i <= 9; i++) {
                    const div = document.getElementById('step' + i);
                    const stepper = document.querySelector('.stepper' + i);
                    if (i === currentStep) {
                        if (div) {
                            div.classList.remove('hidden');
                            div.classList.add('show', 'active');
                        }
                        if (stepper) {
                            stepper.classList.add('active');
                        }
                    } else {
                        if (div) {
                            div.classList.add('hidden');
                            div.classList.remove('show', 'active');
                        }
                        if (stepper) {
                            stepper.classList.remove('active');
                        }
                    }
                }

                nextStepBtn.setAttribute('data-step', currentStep + 1);
                
                // Hide button on last step
                if (currentStep === 8) {
                    nextStepBtn.style.display = 'none';
                } else {
                    nextStepBtn.style.display = 'inline-block';
                }

                // Initialize step handlers
                if (currentStep === 2) {
                    setTimeout(() => initializeLayoutCards(), 100);
                }
                if (currentStep === 3) initializeDimensionInputs();
                if (currentStep === 4) initializeEdgeFinishing();
                if (currentStep === 5) initializeBackWall();
                if (currentStep === 6) initializeSinkSelection();
                if (currentStep === 7) initializeCutoutSelection();
                if (currentStep === 8) initializePersonalDataForm();
            })
            .catch(error => {
                console.error('Error:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack,
                    currentStep: currentStep,
                    data: data
                });
                
                // More specific error message
                let errorMessage = 'An error occurred. Please try again.';
                if (error.message) {
                    errorMessage += '\n\nError: ' + error.message;
                }
                
                alert(errorMessage);
            })
            .finally(() => {
                // Re-enable button
                nextStepBtn.disabled = false;
                nextStepBtn.innerHTML = originalText;
                
                // Hide loading overlay
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'none';
                }
            });
    });

});
</script>


<style>
.product-col.selected {
    border: 3px solid #28a745;
    box-shadow: 0 0 12px rgba(40, 167, 69, 0.6);
    position: relative;
}

.product-col.selected::after {
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
}

.material-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}

.material-card:hover {
    transform: scale(1.02);
}

.material-meta p {
    font-size: 14px;
    color: #555;
}

.material-meta strong {
    font-weight: 600;
}

.step-click {
    cursor: pointer;
}
</style>
@endsection
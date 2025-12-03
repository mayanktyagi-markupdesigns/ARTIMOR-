@extends('front.layouts.app')
@section('content')

@php
    $selectedMaterialId = $selectedMaterialId ?? session('selected_material_id');
    $selectedMaterialTypeId = $selectedMaterialTypeId ?? session('selected_material_type_id');
    $selectedLayoutId = $selectedLayoutId ?? session('selected_layout_id');
@endphp

<div class="steps">
    <div class="step stepper1 active">
        <div class="icon"><span>01</span>
            <img src="{{ asset('assets/front/img/01.png') }}" width="28" height="28">
        </div>
        <p>Material</p>
    </div>
    <div class="step stepper2">
        <div class="icon"><span>02</span>
            <img src="{{ asset('assets/front/img/02.png') }}" width="28" height="28">
        </div>
        <p>Type of</p>
    </div>
    <div class="step stepper3">
        <div class="icon"><span>03</span>
            <img src="{{ asset('assets/front/img/03.png') }}" width="28" height="28">
        </div>
        <p>Choose Layout</p>
    </div>
    <div class="step stepper4">
        <div class="icon"><span>04</span>
            <img src="{{ asset('assets/front/img/04.png') }}" width="28" height="28">
        </div>
        <p>Dimensions</p>
    </div>
    <div class="step stepper5">
        <div class="icon"><span>05</span>
            <img src="{{ asset('assets/front/img/05.png') }}" width="28" height="28">
        </div>
        <p>Edge Finishing</p>
    </div>
    <div class="step stepper6">
        <div class="icon"><span>06</span>
            <img src="{{ asset('assets/front/img/06.png') }}" width="28" height="28">
        </div>
        <p>Back Wall</p>
    </div>
    <div class="step stepper7">
        <div class="icon"><span>07</span>
            <img src="{{ asset('assets/front/img/07.png') }}" width="28" height="28">
        </div>
        <p>Sink</p>
    </div>
    <div class="step stepper8">
        <div class="icon"><span>08</span>
            <img src="{{ asset('assets/front/img/08.png') }}" width="28" height="28">
        </div>
        <p>Cut Outs</p>
    </div>
    <div class="step stepper9">
        <div class="icon"><span>09</span>
            <img src="{{ asset('assets/front/img/09.png') }}" width="28" height="28">
        </div>
        <p>Overview</p>
    </div>
</div>

<div class="materials">
    <div id="step1" class="tab-content show active">
        @include('front.partials.material-price', [
        'materialGroups' => $materialGroups,
        'materialTypesByGroup' => $materialTypesByGroup,
        'selectedGroupId' => $selectedGroupId ?? null,
        'selectedTypeId' => $selectedTypeId ?? null,
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
    <div id="step9" class="tab-content fade hidden">

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

<script>
document.addEventListener('DOMContentLoaded', function() {

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
    let selectedMaterialId = initialMaterialId ? String(initialMaterialId) : null;
    const initialMaterialTypeId = @json($selectedMaterialTypeId);
    let selectedMaterialTypeId = initialMaterialTypeId ? String(initialMaterialTypeId) : null;
    const initialLayoutId = @json($selectedLayoutId);
    let selectedLayoutId = initialLayoutId ? String(initialLayoutId) : null;
    let dimensions = {
        blad1: { width: null, height: null }
    };
    let edgeFinishing = {
        edge_id: null,
        thickness: null,
        selected_edges: []
    };
    let backWall = {
        wall_id: null,
        thickness: null,
        selected_edges: []
    };
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
        const layoutCards = document.querySelectorAll('.layout-card');
        if (!layoutCards.length) {
            selectedLayoutId = null;
            return;
        }
        layoutCards.forEach(card => {
            card.addEventListener('click', function() {
                const layoutId = this.getAttribute('data-id');
                selectedLayoutId = layoutId ? String(layoutId) : null;
                layoutCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
        if (!selectedLayoutId) {
            const activeLayoutCard = document.querySelector('.layout-card.selected');
            if (activeLayoutCard) {
                const layoutId = activeLayoutCard.getAttribute('data-id');
                selectedLayoutId = layoutId ? String(layoutId) : null;
            }
        }
    }

    // Function to initialize dimension inputs
    function initializeDimensionInputs() {
        const width1Input = document.getElementById('width1');
        const height1Input = document.getElementById('height1');

        if (width1Input && height1Input) {
            width1Input.addEventListener('input', () => dimensions.blad1.width = width1Input.value);
            height1Input.addEventListener('input', () => dimensions.blad1.height = height1Input.value);
        }
    }

    // Function to initialize edge finishing selections
    function initializeEdgeFinishing() {
        const edgeCards = document.querySelectorAll('.edge-card');
        const edgeCircles = document.querySelectorAll('.edge-finishing-tab .edge-circle');
        const thicknessSelect = document.getElementById('edge-thickness');

        edgeCards.forEach(card => {
            card.addEventListener('click', function() {
                edgeFinishing.edge_id = this.getAttribute('data-id');
                edgeCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        edgeCircles.forEach(circle => {
            circle.addEventListener('click', function() {
                const edge = this.getAttribute('data-edge');
                if (edgeFinishing.selected_edges.includes(edge)) {
                    edgeFinishing.selected_edges = edgeFinishing.selected_edges.filter(e => e !== edge);
                    this.classList.remove('selected');
                } else {
                    edgeFinishing.selected_edges.push(edge);
                    this.classList.add('selected');
                }
            });
        });

        if (thicknessSelect) {
            thicknessSelect.addEventListener('change', () => {
                edgeFinishing.thickness = thicknessSelect.value;
            });
        }
    }

    // Function to initialize back wall selections
    function initializeBackWall() {
        const wallCards = document.querySelectorAll('.wall-card');
        const wallCircles = document.querySelectorAll('.back-wall-tab .edge-circle');
        const thicknessSelect = document.getElementById('wall-thickness');

        wallCards.forEach(card => {
            card.addEventListener('click', function() {
                backWall.wall_id = this.getAttribute('data-id');
                wallCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        wallCircles.forEach(circle => {
            circle.addEventListener('click', function() {
                const edge = this.getAttribute('data-edge');
                if (backWall.selected_edges.includes(edge)) {
                    backWall.selected_edges = backWall.selected_edges.filter(e => e !== edge);
                    this.classList.remove('selected');
                } else {
                    backWall.selected_edges.push(edge);
                    this.classList.add('selected');
                }
            });
        });

        if (thicknessSelect) {
            thicknessSelect.addEventListener('change', () => {
                backWall.thickness = thicknessSelect.value;
            });
        }
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
                const cutoutSelect = modal.querySelector('.sink-cutout[data-sink-id="' + sinkId + '"]');
                const numberInput = modal.querySelector('.sink-number[data-sink-id="' + sinkId + '"]');

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
                const selectedCard = document.querySelector('.sink-card[data-id="' + sinkId + '"]');
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
                const recessTypeSelect = modal.querySelector('.cutout-recess-type[data-cutout-id="' + cutoutId + '"]');

                if (!recessTypeSelect.value) {
                    alert('Please select a recess type.');
                    return;
                }

                cutoutSelection.cutout_id = cutoutId;
                cutoutSelection.recess_type = recessTypeSelect.value;

                document.querySelectorAll('.cutout-card').forEach(card => {
                    card.classList.remove('selected');
                });
                const selectedCard = document.querySelector('.cutout-card[data-id="' + cutoutId + '"]');
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
                if (!userDetails.first_name || !userDetails.last_name || !userDetails.phone_number || !userDetails.email || !userDetails.delivery_option || !userDetails.measurement_time) {
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
                        first_name : userDetails.first_name,
                        last_name : userDetails.last_name,
                        phone_number : userDetails.phone_number,
                        email : userDetails.email,
                        delivery_option : userDetails.delivery_option,
                        measurement_time : userDetails.measurement_time,
                        promo_code : userDetails.promo_code,
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

        if(currentStep >1){
            $('.materials-tab-div').addClass('hidden');
        }else{
            $('.materials-tab-div').removeClass('hidden');
        }
        // Validate selections based on step
        if (currentStep === 2) {
            if (!selectedMaterialId) {
                alert("Please select a material before proceeding to the next step.");
                return;
            }
        }
        if (currentStep === 3) {
            if (!selectedMaterialId) {
                alert("Please select a material before proceeding to the next step.");
                return;
            }
            if (!selectedMaterialTypeId) {
                alert("Please select a material type before proceeding to the next step.");
                return;
            }
        }
        if (currentStep === 4 && !selectedLayoutId) {
            alert("Please select a layout before proceeding to the next step.");
            return;
        }
        if (currentStep === 5) {
            if (!dimensions.blad1.width || !dimensions.blad1.height) {
                alert("Please enter both width and height for Blad 01.");
                return;
            }
            if (isNaN(dimensions.blad1.width) || isNaN(dimensions.blad1.height) || dimensions.blad1.width <= 0 || dimensions.blad1.height <= 0) {
                alert("Please enter valid numeric values for width and height.");
                return;
            }
        }
        if (currentStep === 6) {
            if (!edgeFinishing.edge_id) {
                alert("Please select an edge type.");
                return;
            }
            if (!edgeFinishing.thickness) {
                alert("Please select an edge thickness.");
                return;
            }
            if (edgeFinishing.selected_edges.length === 0) {
                alert("Please select at least one edge to finish.");
                return;
            }
        }
        if (currentStep === 7) {
            if (!backWall.wall_id) {
                alert("Please select a back wall type.");
                return;
            }
            if (!backWall.thickness) {
                alert("Please select a back wall thickness.");
                return;
            }
            if (backWall.selected_edges.length === 0) {
                alert("Please select at least one side for back wall finishing.");
                return;
            }
        }
        if (currentStep === 8) {
            if (!sinkSelection.sink_id) {
                alert("Please select a sink by confirming in the modal.");
                return;
            }
            if (!sinkSelection.cutout) {
                alert("Please select a cutout type for the sink.");
                return;
            }
            if (!sinkSelection.number || isNaN(sinkSelection.number) || sinkSelection.number < 0 || sinkSelection.number > 10) {
                alert("Please enter a valid number of sinks (0-10).");
                return;
            }
        }
        if (currentStep === 9) {
            if (!cutoutSelection.cutout_id) {
                alert("Please select a cut-out by confirming in the modal.");
                return;
            }
            if (!cutoutSelection.recess_type) {
                alert("Please select a recess type for the cut-out.");
                return;
            }
        }

        // Prepare data for AJAX request
        const data = { step: currentStep };
        if (currentStep === 2 || currentStep === 3) data.material_id = selectedMaterialId;
        if ((currentStep === 2 || currentStep === 3) && selectedMaterialTypeId) {
            data.material_type_id = selectedMaterialTypeId;
        }
        if (currentStep === 4) data.layout_id = selectedLayoutId;
        if (currentStep === 5) data.dimensions = dimensions;
        if (currentStep === 6) data.edge_finishing = edgeFinishing;
        if (currentStep === 7) data.back_wall = backWall;
        if (currentStep === 8) data.sink_selection = sinkSelection;
        if (currentStep === 9) data.cutout_selection = cutoutSelection;
        console.log('Data sent for step', currentStep, data);
        fetch("{{ route('calculator.steps') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text())
        .then(html => {
            // Insert HTML into the correct step div
            const stepDivId = 'step' + currentStep;
            document.getElementById(stepDivId).innerHTML = html;

            // Show current step, hide others
            for (let i = 1; i <= 9; i++) {
                const div = document.getElementById('step' + i);
                const stepperDiv = document.querySelector('.stepper' + i);
                if (div) {
                    if (i === currentStep) {
                        div.classList.remove('hidden');
                        div.classList.add('show', 'active');
                    } else {
                        div.classList.add('hidden');
                        div.classList.remove('show', 'active');
                    }
                }
                if (stepperDiv) {
                    if (i < currentStep) {
                        stepperDiv.classList.add('completed');
                    } else if (i === currentStep) {
                        stepperDiv.classList.add('active');
                        stepperDiv.classList.remove('completed');
                    } else {
                        stepperDiv.classList.remove('active', 'completed');
                    }
                }
            }

            // Update button data-step
            nextStepBtn.setAttribute('data-step', currentStep + 1);

            // Initialize handlers for the loaded step
            if (currentStep === 3) {
                initializeLayoutCards();
            }
            if (currentStep === 4) {
                initializeDimensionInputs();
            }
            if (currentStep === 5) {
                initializeEdgeFinishing();
            }
            if (currentStep === 6) {
                initializeBackWall();
            }
            if (currentStep === 7) {
                initializeSinkSelection();
            }
            if (currentStep === 8) {
                initializeCutoutSelection();
            }
            if (currentStep === 9) {
                initializePersonalDataForm();
                if (nextStepBtn) {
                    nextStepBtn.style.display = 'none';
                }
            }

            // Handle material type selection (for step 2)
            const materialTypeItems = document.querySelectorAll('.material-type-item');
            const materialImage = document.getElementById('material-image');
            if (materialTypeItems.length) {
                materialTypeItems.forEach(item => {
                    item.addEventListener('click', function() {
                        materialTypeItems.forEach(i => i.classList.remove('active'));
                        this.classList.add('active');
                        const typeId = this.getAttribute('data-id');
                        selectedMaterialTypeId = typeId ? String(typeId) : null;
                        selectedLayoutId = null;
                        if (materialImage) {
                            const newImage = this.getAttribute('data-image');
                            if (newImage) {
                                materialImage.setAttribute('src', newImage);
                            }
                        }
                    });
                });

                if (!selectedMaterialTypeId) {
                    const activeItem = document.querySelector('.material-type-item.active');
                    if (activeItem) {
                        const defaultTypeId = activeItem.getAttribute('data-id');
                        selectedMaterialTypeId = defaultTypeId ? String(defaultTypeId) : null;
                        if (materialImage) {
                            const defaultImage = activeItem.getAttribute('data-image');
                            if (defaultImage) {
                                materialImage.setAttribute('src', defaultImage);
                            }
                        }
                    }
                    selectedLayoutId = null;
                }
            } else {
                selectedMaterialTypeId = null;
                selectedLayoutId = null;
            }

            if(currentStep == 9){
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
            }
            
        })
        .catch(error => {
            alert('Error loading step: ' + error);
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
</style>
@endsection
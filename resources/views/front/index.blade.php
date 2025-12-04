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

    let selectedMaterialId = @json($selectedMaterialId ? (string) $selectedMaterialId : null);
    let selectedMaterialTypeId = @json($selectedMaterialTypeId ? (string) $selectedMaterialTypeId : null);
    let selectedLayoutId = @json($selectedLayoutId ? (string) $selectedLayoutId : null);

    /* ✅ MISSING GLOBAL (CRITICAL FIX) */
    let materialSelection = {
        material_type_id: null,
        color: null,
        finish: null,
        thickness: null
    };

    let dimensions = {
        blad1: {
            width: null,
            height: null
        }
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

    /* ✅ CLEAN MODAL FIX */
    function cleanupModalBackdrop() {
        setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        }, 100);
    }

    /* ✅ MATERIAL CARD (STEP 1) */
    function initializeMaterialCards() {
        const materialCards = document.querySelectorAll('.material-card');
        materialCards.forEach(card => {
            card.addEventListener('click', function() {
                selectedMaterialId = this.dataset.id;
                selectedMaterialTypeId = null;
                materialCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    }

    /* ✅ ✅ ✅ MATERIAL QUICK VIEW — SINK-STYLE (FIXED) */
    function initializeMaterialQuickView() {

        document.querySelectorAll('.confirm-material').forEach(button => {

            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const materialTypeId = this.dataset.id;
                const modal = this.closest('.modal');

                const color = modal.querySelector('.mat-color').value;
                const finish = modal.querySelector('.mat-finish').value;
                const thickness = modal.querySelector('.mat-thickness').value;

                if (!color) return alert('Please select color');
                if (!finish) return alert('Please select finish');
                if (!thickness) return alert('Please select thickness');

                /* ✅ LOCAL STATE (NO AJAX LIKE SINK) */
                selectedMaterialTypeId = materialTypeId;

                materialSelection = {
                    material_type_id: materialTypeId,
                    color,
                    finish,
                    thickness
                };

                console.log('Material Saved:', materialSelection);

                /* ✅ UI SELECT */
                document.querySelectorAll('.material-type-card').forEach(card => {
                    card.classList.remove('selected');
                });

                const selectedCard = document.querySelector(
                    '.material-type-card[data-id="' + materialTypeId + '"]'
                );
                if (selectedCard) selectedCard.classList.add('selected');

                /* ✅ SAFE MODAL CLOSE */
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) modalInstance.hide();
                cleanupModalBackdrop();
            });
        });
    }

    /* ✅ SINK — UNCHANGED */
    function initializeSinkSelection() {
        document.querySelectorAll('.confirm-sink').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const sinkId = this.dataset.sinkId;
                const modal = this.closest('.modal');
                const cutout = modal.querySelector('.sink-cutout').value;
                const number = modal.querySelector('.sink-number').value;

                if (!cutout) return alert('Select cutout');
                if (!number) return alert('Enter number');

                sinkSelection = {
                    sink_id: sinkId,
                    cutout,
                    number
                };

                document.querySelectorAll('.sink-card').forEach(c => c.classList.remove(
                    'selected'));
                document.querySelector('.sink-card[data-id="' + sinkId + '"]').classList.add(
                    'selected');

                bootstrap.Modal.getInstance(modal).hide();
                cleanupModalBackdrop();
            });
        });
    }

    /* ✅ NEXT STEP BUTTON — FIXED VALIDATION */
    nextStepBtn.addEventListener('click', function() {

        const currentStep = parseInt(this.dataset.step);
        alert(selectedMaterialId);

        if (currentStep === 2 && !selectedMaterialId) {
            return alert('Select Material First');
        }

        if (currentStep === 3 && !selectedMaterialTypeId) {
            return alert('Confirm Material Type First');
        }

        /* ✅ SEND AJAX */
        const data = {
            step: currentStep
        };

        if (currentStep === 3) {
            data.material_id = selectedMaterialId;
            data.material_type_id = selectedMaterialTypeId;
            data.material_config = materialSelection;
        }

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

                document.getElementById('step' + currentStep).innerHTML = html;

                for (let i = 1; i <= 9; i++) {
                    const stepDiv = document.getElementById('step' + i);
                    if (!stepDiv) continue;
                    stepDiv.classList.toggle('hidden', i !== currentStep);
                    stepDiv.classList.toggle('show', i === currentStep);
                    stepDiv.classList.toggle('active', i === currentStep);
                }

                nextStepBtn.dataset.step = currentStep + 1;

                /* ✅ REBIND DYNAMIC STEPS */
                if (currentStep === 2) initializeMaterialQuickView();
                if (currentStep === 7) initializeSinkSelection();
            });
    });

    /* ✅ FIRST LOAD */
    initializeMaterialCards();
    initializeMaterialQuickView();

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
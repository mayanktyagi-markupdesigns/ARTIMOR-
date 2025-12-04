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
            <img src="{{ asset('assets/front/img/03.png') }}" width="28" height="28">
        </div>
        <p>Choose Layout</p>
    </div>
    <div class="step stepper3">
        <div class="icon"><span>03</span>
            <img src="{{ asset('assets/front/img/04.png') }}" width="28" height="28">
        </div>
        <p>Dimensions</p>
    </div>
    <div class="step stepper4">
        <div class="icon"><span>04</span>
            <img src="{{ asset('assets/front/img/05.png') }}" width="28" height="28">
        </div>
        <p>Edge Finishing</p>
    </div>
    <div class="step stepper5">
        <div class="icon"><span>05</span>
            <img src="{{ asset('assets/front/img/06.png') }}" width="28" height="28">
        </div>
        <p>Back Wall</p>
    </div>
    <div class="step stepper6">
        <div class="icon"><span>06</span>
            <img src="{{ asset('assets/front/img/07.png') }}" width="28" height="28">
        </div>
        <p>Sink</p>
    </div>
    <div class="step stepper7">
        <div class="icon"><span>07</span>
            <img src="{{ asset('assets/front/img/08.png') }}" width="28" height="28">
        </div>
        <p>Cut Outs</p>
    </div>
    <div class="step stepper8">
        <div class="icon"><span>08</span>
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

    let materialSelection = {};
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

    /* ✅ FORCE CLEAN MODAL STATE */
    function cleanupModalBackdrop() {
        setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        }, 150);
    }

    /* ✅ MATERIAL GROUP CARD */
    function initializeMaterialCards() {
        document.querySelectorAll('.material-card').forEach(card => {
            card.addEventListener('click', function() {
                selectedMaterialId = this.dataset.id;
                document.querySelectorAll('.material-card')
                    .forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    }

    /* ✅ ✅ ✅ SINGLE GLOBAL CONFIRM HANDLER */
    document.body.addEventListener('click', function(e) {

        const button = e.target.closest('.confirm-material');
        if (!button) return;

        e.preventDefault();
        e.stopPropagation();

        const modal = button.closest('.modal');
        const materialTypeId = button.dataset.id;

        const color = modal.querySelector('.mat-color')?.value;
        const finish = modal.querySelector('.mat-finish')?.value;
        const thickness = modal.querySelector('.mat-thickness')?.value;

        if (!color || !finish || !thickness) {
            alert('Please select color, finish & thickness');
            return;
        }

        selectedMaterialTypeId = materialTypeId;

        materialSelection = {
            material_type_id: materialTypeId,
            color,
            finish,
            thickness
        };

        console.log('✅ Material Saved:', materialSelection);

        document.querySelectorAll('.material-type-card')
            .forEach(c => c.classList.remove('selected'));

        const activeCard = document.querySelector(
            `.material-type-card[data-id="${materialTypeId}"]`
        );
        if (activeCard) activeCard.classList.add('selected');

        const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
        modalInstance.hide();

        button.blur();
        cleanupModalBackdrop();
    });

    /* ✅ ✅ NEXT BUTTON (FIXED CLICK ISSUE) */
    nextStepBtn.addEventListener('click', function() {

        let nextStep = parseInt(this.dataset.step);
        let currentStep = nextStep - 1;

        if (currentStep === 3 && !selectedLayoutId) {
            alert("Please select a layout.");
            return;
        }

        const data = {
            step: nextStep
        };
        if (nextStep === 2) {
            data.material_id = selectedMaterialId;
        }

        if (nextStep === 3) {
            data.material_id = selectedMaterialId;
            data.material_type_id = materialSelection.material_type_id;
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

                document.getElementById('step' + nextStep).innerHTML = html;

                for (let i = 1; i <= 9; i++) {
                    const div = document.getElementById('step' + i);
                    const stepper = document.querySelector('.stepper' + i);

                    if (div) {
                        div.classList.toggle('hidden', i !== nextStep);
                        div.classList.toggle('show', i === nextStep);
                        div.classList.toggle('active', i === nextStep);
                    }

                    if (stepper) {
                        stepper.classList.toggle('active', i === nextStep);
                        stepper.classList.toggle('completed', i < nextStep);
                    }
                }

                if (nextStep < 9) {
                    this.dataset.step = nextStep + 1;
                } else {
                    this.style.display = 'none';
                }

                initializeMaterialCards();
            });
    });

    /* ✅ FIRST LOAD */
    initializeMaterialCards();
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
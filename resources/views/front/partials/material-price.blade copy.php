@php
$materialConfig = session('material_config', [
'material_type_id' => null,
'color' => null,
'finish' => null,
'thickness' => null,
]);

$selectedMaterialTypeId = $materialConfig['material_type_id'] ?? null;
@endphp

<div class="materials-tab-wrapper">

    <!-- GROUP TABS -->
    <div class="d-flex align-items-center justify-content-center materials-tab-div">
        @if($materialGroups->isNotEmpty())
        <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
            @foreach($materialGroups as $index => $group)
            @php
            $tabId = \Illuminate\Support\Str::slug($group->name ?: 'Other');
            @endphp
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $tabId }}-tab" data-bs-toggle="tab"
                    data-bs-target="#{{ $tabId }}" type="button" role="tab">
                    {{ $group->name }}
                </button>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    <!-- TAB CONTENT -->
    <div class="tab-content" id="materialsTabContent">
        @foreach($materialGroups as $index => $group)
        @php
        $tabId = \Illuminate\Support\Str::slug($group->name ?: 'Other');
        $types = $materialTypesByGroup[$group->id] ?? collect();
        @endphp

        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel">
            <div class="row">

                @forelse($types as $i => $type)
                @php
                $typeImage = $type->image
                ? asset('uploads/material-type/' . $type->image)
                : asset('assets/front/img/product-circle.jpg');
                @endphp

                <!-- MATERIAL CARD -->
                <div class="col-md-4 mb-4">
                    <div class="p-0 card border-0 rounded-0 position-relative product-col material-type-card
                                {{ (string)$selectedMaterialTypeId === (string)$type->id ? 'selected' : '' }}"
                        data-id="{{ $type->id }}">

                        <img src="{{ $typeImage }}" class="card-img-top" alt="{{ $type->name }}">

                        <div class="p-0 card-body text-center">
                            <div class="titleoverlay">
                                <div>
                                    <span>{{ $i + 1 }}.</span> {{ $type->name }}
                                </div>

                                <a href="#" data-bs-toggle="modal" data-bs-target="#materialModal-{{ $type->id }}"
                                    class="btn-link">
                                    Quick View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QUICK VIEW MODAL -->
                <div class="modal fade" id="materialModal-{{ $type->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-md-6 text-center">
                                        <img src="{{ $typeImage }}" class="product-main-img" alt="{{ $type->name }}">
                                    </div>

                                    <div class="col-md-6">
                                        <h2 class="fw-bold fs-3">{{ $type->name }}</h2>

                                        <!-- STATIC COLOR -->
                                        <div class="inputfild-box mt-3">
                                            <label class="form-label">Color<sup>*</sup></label>
                                            <select class="form-select mat-color" data-id="{{ $type->id }}">
                                                <option value="">Select Color</option>
                                                @foreach($type->colors as $color)
                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <!-- STATIC FINISH -->
                                        <div class="inputfild-box mt-3">
                                            <label class="form-label">Finish<sup>*</sup></label>
                                            <select class="form-select mat-finish" data-id="{{ $type->id }}">
                                                <option value="">Select Finish</option>
                                                @foreach($type->finishes as $finish)
                                                <option value="{{ $finish->id }}">{{ $finish->finish_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- STATIC THICKNESS -->
                                        <div class="inputfild-box mt-3">
                                            <label class="form-label">Thickness<sup>*</sup></label>
                                            <select class="form-select mat-thickness" data-id="{{ $type->id }}">
                                                <option value="">Select Thickness</option>
                                                @foreach($type->thicknesses as $thickness)
                                                <option value="{{ $thickness->id }}">
                                                    {{ $thickness->thickness_value }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="d-flex gap-4 mt-5">
                                            <button class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">
                                                Cancel
                                            </button>

                                            <button class="btn btn-primary red-btn confirm-material"
                                                data-id="{{ $type->id }}">
                                                Confirm
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                </div>

                @empty
                <div class="col-12 text-center py-5">
                    <p>No material types available for this group.</p>
                </div>
                @endforelse

            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
let selectedMaterialTypeId = "{{ $selectedMaterialTypeId }}";
let materialSelection = {};

console.log('✅ Final Material script loaded');

/* =================================
   ✅ SAFE MATERIAL CARD SELECTION
================================= */
document.addEventListener('click', function(e) {

    if (e.target.closest('.modal')) return;
    // if (e.target.closest('[data-bs-toggle="modal"]')) return;

    /* ✅ If click is on Quick View button → LET BOOTSTRAP HANDLE IT */

    const quickViewBtn = e.target.closest('[data-bs-toggle="modal"]');

    if (quickViewBtn) {

        return; // ✅ DO NOT touch selection, DO NOT stop event

    }

    const card = e.target.closest('.material-type-card');
    if (!card) return;

    const clickedId = card.dataset.id;

    if (card.classList.contains('selected')) {
        card.classList.remove('selected');
        selectedMaterialTypeId = null;
        materialSelection = {};
        console.log('Material unselected');
    } else {
        document.querySelectorAll('.material-type-card')
            .forEach(c => c.classList.remove('selected'));

        card.classList.add('selected');
        selectedMaterialTypeId = clickedId;
        materialSelection.material_type_id = clickedId;

        console.log('Material selected:', clickedId);
    }
});


/* =================================
   ✅ CONFIRM BUTTON (ARIA SAFE)
================================= */
document.addEventListener('click', function(e) {

    const button = e.target.closest('.confirm-material');
    if (!button) return;

    e.preventDefault();
    e.stopImmediatePropagation();

    const materialTypeId = button.dataset.id;
    const modal = button.closest('.modal');

    if (!modal) return;

    const color = modal.querySelector('.mat-color')?.value;
    const finish = modal.querySelector('.mat-finish')?.value;
    const thickness = modal.querySelector('.mat-thickness')?.value;

    if (!color) return alert('Please select color');
    if (!finish) return alert('Please select finish');
    if (!thickness) return alert('Please select thickness');

    /* ✅ SAVE MATERIAL */
    selectedMaterialTypeId = materialTypeId;
    materialSelection = {
        material_type_id: materialTypeId,
        color,
        finish,
        thickness
    };

    console.log('✅ Material Saved:', materialSelection);

    /* ✅ UPDATE UI */
    document.querySelectorAll('.material-type-card')
        .forEach(c => c.classList.remove('selected'));

    const selectedCard = document.querySelector(
        `.material-type-card[data-id="${materialTypeId}"]`
    );
    if (selectedCard) selectedCard.classList.add('selected');

    /* ✅ MOVE FOCUS OUT BEFORE HIDING MODAL (ARIA FIX) */
    button.blur();
    document.body.focus();

    /* ✅ PROPER BOOTSTRAP MODAL CLOSE (NO MANUAL BACKDROP HACKS) */
    const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
    modalInstance.hide();
});


/* =================================
   ✅ HARD BACKDROP SAFETY NET
   (runs only if Bootstrap fails)
================================= */
document.addEventListener('hidden.bs.modal', function() {
    document.querySelectorAll('.modal-backdrop').forEach(bg => bg.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('padding-right');
});
</script>

<!-- ✅ STYLES -->
<style>
.material-type-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}

.material-type-card:hover {
    transform: scale(1.02);
}

.material-type-card.selected {
    border: 3px solid #28a745;
    box-shadow: 0 0 12px rgba(40, 167, 69, 0.6);
    position: relative;
}

.material-type-card.selected::after {
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
</style>
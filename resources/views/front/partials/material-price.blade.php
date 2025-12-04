<div class="materials-tab-wrapper">
    <div class="d-flex align-items-center justify-content-center materials-tab-div">
        @if($materialGroups->isNotEmpty())
            <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
                @foreach($materialGroups as $index => $group)
                    @php
                        $tabId = \Illuminate\Support\Str::slug($group->name ?: 'Other');
                    @endphp
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                            id="{{ $tabId }}-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $tabId }}"
                            type="button"
                            role="tab"
                            data-group-id="{{ $group->id }}">
                            {{ $group->name }}
                        </button>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="py-5 text-center w-100">
                <p class="mb-0">No material groups available.</p>
            </div>
        @endif
    </div>

    @if($materialGroups->isNotEmpty())
        <div class="tab-content" id="materialsTabContent">
            @foreach($materialGroups as $index => $group)
                @php
                    $tabId = \Illuminate\Support\Str::slug($group->name ?: 'Other');
                    $types = $materialTypesByGroup[$group->id] ?? collect();
                @endphp
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel"
                    aria-labelledby="{{ $tabId }}-tab">
                    <div class="row">
                        @forelse($types as $type)
                            @php
                                $typeImage = $type->image 
                                    ? asset('uploads/material-type/' . $type->image) 
                                    : asset('assets/front/img/product-circle.jpg');
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div class="card border-0 rounded-0 position-relative product-col material-type-card {{ (string)($selectedMaterialTypeId ?? '') === (string)$type->id ? 'selected' : '' }}"
                                    data-id="{{ $type->id }}">
                                    <img src="{{ $typeImage }}" class="card-img-top" alt="{{ $type->name }}">
                                    <div class="card-body text-center p-0">
                                        <div class="titleoverlay">
                                            <div>{{ $type->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="mb-0">No material types available for this group.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedMaterialTypeId = @json($selectedMaterialTypeId ?? null);

    function initTypeSelection() {
        document.querySelectorAll('.material-type-card').forEach(card => {
            card.addEventListener('click', function() {
                selectedMaterialTypeId = this.dataset.id;

                document.querySelectorAll('.material-type-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    }

    initTypeSelection();

    // Re-initialize when tab is shown
    const tabButtons = document.querySelectorAll('#materialsTab button[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', () => {
            initTypeSelection();
        });
    });
});
</script>

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

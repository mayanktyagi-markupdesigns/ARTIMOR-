<div class="materials-tab-wrapper">
    <div class="d-flex align-items-center justify-content-center materials-tab-div mb-4">
        <!-- Material Group Selection -->
        <div class="me-3">
            <label for="materialGroup" class="form-label">Material Group</label>
            <select id="materialGroup" class="form-select">
                <option value="">Select Material Group</option>
                @foreach($materialGroups as $group)
                    <option value="{{ $group->id }}" 
                        {{ ($selectedGroupId ?? '') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Material Type Selection -->
        <div>
            <label for="materialType" class="form-label">Material Type</label>
            <select id="materialType" class="form-select">
                <option value="">Select Material Type</option>
                @if($selectedGroupId && isset($materialTypesByGroup[$selectedGroupId]))
                    @foreach($materialTypesByGroup[$selectedGroupId] as $type)
                        <option value="{{ $type->id }}"
                            {{ ($selectedTypeId ?? '') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <!-- Material Cards -->
    <div class="row">
        @foreach($materialGroups as $group)
            @if(isset($materialTypesByGroup[$group->id]))
                @foreach($materialTypesByGroup[$group->id] as $type)
                    @php
                        $materialImage = $type->image
                            ? asset('uploads/material-types/' . $type->image)
                            : asset('assets/front/img/product-circle.jpg');
                    @endphp
                    <div class="col-md-3 mb-4 material-card-wrapper" 
                         data-group="{{ $group->id }}" data-type="{{ $type->id }}">
                        <div class="card border-0 product-col material-card 
                            {{ ($selectedTypeId ?? '') == $type->id ? 'selected' : '' }}"
                             data-id="{{ $type->id }}">
                            <img src="{{ $materialImage }}" class="card-img-top" alt="{{ $type->name }}">
                            <div class="card-body text-center p-2">
                                <strong>{{ $type->name }}</strong>
                                <p class="mb-0">{{ $group->name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const materialGroupSelect = document.getElementById('materialGroup');
    const materialTypeSelect = document.getElementById('materialType');

    // Map of material types by group
    const materialTypesByGroup = @json($materialTypesByGroup);

    // Update material types dropdown when group changes
    materialGroupSelect.addEventListener('change', function() {
        const groupId = this.value;
        materialTypeSelect.innerHTML = '<option value="">Select Material Type</option>';

        if (groupId && materialTypesByGroup[groupId]) {
            materialTypesByGroup[groupId].forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.text = type.name;
                materialTypeSelect.appendChild(option);
            });
        }

        // Clear selected type
        selectedTypeId = null;
        // Clear card selections
        document.querySelectorAll('.material-card').forEach(card => card.classList.remove('selected'));
    });

    // Material Type selection
    materialTypeSelect.addEventListener('change', function() {
        selectedTypeId = this.value;

        document.querySelectorAll('.material-card').forEach(card => {
            card.classList.remove('selected');
            if (card.dataset.type === selectedTypeId) {
                card.classList.add('selected');
            }
        });
    });

    // Material card click
    document.querySelectorAll('.material-card').forEach(card => {
        card.addEventListener('click', function() {
            const typeId = this.dataset.id;
            selectedTypeId = typeId;
            materialTypeSelect.value = typeId;

            document.querySelectorAll('.material-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
});
</script>

<style>
.material-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.material-card:hover {
    transform: scale(1.02);
}
.material-card.selected {
    border: 3px solid #28a745;
    box-shadow: 0 0 12px rgba(40, 167, 69, 0.6);
    position: relative;
}
.material-card.selected::after {
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

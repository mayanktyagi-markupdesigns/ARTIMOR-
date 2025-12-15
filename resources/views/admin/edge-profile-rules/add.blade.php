@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Add Edge Profile Thickness Rule</h3>
        <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')

            <form action="{{ route('admin.edge.profile.thickness.store') }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Material Type -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Material Type <span class="text-danger">*</span>
                        </label>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $t)
                            <option value="{{ $t->id }}" {{ old('material_type_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Edge Profile -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Edge Profile <span class="text-danger">*</span>
                        </label>
                        <select name="edge_profile_id" class="form-select">
                            <option value="">Select Edge Profile</option>
                            @foreach($edge as $e)
                            <option value="{{ $e->id }}" {{ old('edge_profile_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('edge_profile_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Thickness (Dynamic) -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Thickness <span class="text-danger">*</span>
                        </label>
                        <select name="thickness_id" id="thickness_id" class="form-select" disabled>
                            <option value="">Select Thickness</option>
                        </select>
                        @error('thickness_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Guest Price -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Price (Guest) <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" min="0" name="price_per_lm_guest" class="form-control"
                            value="{{ old('price_per_lm_guest') }}">
                        @error('price_per_lm_guest')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Business Price -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Price (Business) <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" min="0" name="price_per_lm_business" class="form-control"
                            value="{{ old('price_per_lm_business') }}">
                        @error('price_per_lm_business')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-danger ms-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const materialSelect = document.getElementById('material_type_id');
    const thicknessSelect = document.getElementById('thickness_id');
    const oldThickness = "{{ old('thickness_id') }}";

    function loadThickness(materialTypeId, selectedId = null) {
        thicknessSelect.innerHTML = '<option value="">Loading...</option>';
        thicknessSelect.disabled = true;

        fetch(`/admin/edge-profile-thickness/material-type/${materialTypeId}/thicknesses`)
            .then(res => res.json())
            .then(data => {
                let html = '<option value="">Select Thickness</option>';

                if (data.length === 0) {
                    html += '<option value="">No thickness available</option>';
                } else {
                    data.forEach(item => {
                        const selected = selectedId == item.id ? 'selected' : '';
                        html += `<option value="${item.id}" ${selected}>
                                    ${item.thickness_value}
                                 </option>`;
                    });
                }

                thicknessSelect.innerHTML = html;
                thicknessSelect.disabled = false;
            })
            .catch(() => {
                thicknessSelect.innerHTML = '<option value="">Error loading thickness</option>';
            });
    }

    // On change material type
    materialSelect.addEventListener('change', function() {
        if (this.value) {
            loadThickness(this.value);
        } else {
            thicknessSelect.innerHTML = '<option value="">Select Thickness</option>';
            thicknessSelect.disabled = true;
        }
    });

    // Page reload (validation error case)
    if (materialSelect.value) {
        loadThickness(materialSelect.value, oldThickness);
    }
});
</script>
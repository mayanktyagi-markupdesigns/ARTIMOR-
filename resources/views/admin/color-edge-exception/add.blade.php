@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Add Material Color Edge Exception</h3>
        <a href="{{ route('admin.color.edge.exception.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.color.edge.exception.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Material Type -->
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type<span class="text-danger">*</span></label>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $t)
                            <option value="{{ $t->id }}" {{ old('material_type_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Material Color -->
                    <div class="col-md-4 mb-3">
                        <label for="color_id">Material Color<span class="text-danger">*</span></label>
                        <select name="color_id" id="color_id" class="form-select" disabled>
                            <option value="">Select Material Color</option>
                        </select>
                        @error('color_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Edge Profile -->
                    <div class="col-md-4 mb-3">
                        <label for="edge_profile_id">Edge Profile <span class="text-danger">*</span></label>
                        <select name="edge_profile_id" class="form-select">
                            <option value="">Select Edge Profile</option>
                            @foreach($edge as $e)
                            <option value="{{ $e->id }}" {{ old('edge_profile_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('edge_profile_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Thickness -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_id">Thickness <span class="text-danger">*</span></label>
                        <select name="thickness_id" id="thickness_id" class="form-select" disabled>
                            <option value="">Select Thickness</option>
                        </select>
                        @error('thickness_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Override Prices -->
                    <div class="col-md-4 mb-3">
                        <label>Override Price (Business) <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="override_price_per_lm" class="form-control"
                            value="{{ old('override_price_per_lm') }}">
                        @error('override_price_per_lm') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Override Guest Price <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="override_guest_price_per_lm" class="form-control"
                            value="{{ old('override_guest_price_per_lm') }}">
                        @error('override_guest_price_per_lm') <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', 1) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.color.edge.exception.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {

    const materialSelect = document.getElementById('material_type_id');
    const colorSelect = document.getElementById('color_id');
    const thicknessSelect = document.getElementById('thickness_id');
    const oldColor = "{{ old('color_id') }}";
    const oldThickness = "{{ old('thickness_id') }}";

    function loadColors(materialId, selectedId = null) {
        colorSelect.innerHTML = '<option>Loading...</option>';
        colorSelect.disabled = true;

        fetch(`/admin/color-edge-exception/material-type/${materialId}/colors`)
            .then(res => res.json())
            .then(data => {
                let html = '<option value="">Select Material Color</option>';
                data.forEach(item => {
                    const selected = selectedId == item.id ? 'selected' : '';
                    html += `<option value="${item.id}" ${selected}>${item.name}</option>`;
                });
                colorSelect.innerHTML = html;
                colorSelect.disabled = false;
            })
            .catch(() => {
                colorSelect.innerHTML = '<option value="">Error loading colors</option>';
            });
    }

    function loadThickness(materialId, selectedId = null) {
        thicknessSelect.innerHTML = '<option>Loading...</option>';
        thicknessSelect.disabled = true;

        fetch(`/admin/color-edge-exception/material-type/${materialId}/thicknesses`)
            .then(res => res.json())
            .then(data => {
                let html = '<option value="">Select Thickness</option>';
                data.forEach(item => {
                    const selected = selectedId == item.id ? 'selected' : '';
                    html +=
                        `<option value="${item.id}" ${selected}>${item.thickness_value}</option>`;
                });
                thicknessSelect.innerHTML = html;
                thicknessSelect.disabled = false;
            })
            .catch(() => {
                thicknessSelect.innerHTML = '<option value="">Error loading thickness</option>';
            });
    }

    // Page load if old values exist
    if (materialSelect.value) {
        loadColors(materialSelect.value, oldColor);
        loadThickness(materialSelect.value, oldThickness);
    }

    // On change material type
    materialSelect.addEventListener('change', function() {
        if (this.value) {
            loadColors(this.value);
            loadThickness(this.value);
        } else {
            colorSelect.innerHTML = '<option value="">Select Material Color</option>';
            colorSelect.disabled = true;
            thicknessSelect.innerHTML = '<option value="">Select Thickness</option>';
            thicknessSelect.disabled = true;
        }
    });
});
</script>
@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Edit Material Color Edge Exception</h3>
        <a href="{{ route('admin.color.edge.exception.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')

            <form action="{{ route('admin.color.edge.exception.update', $color_edge_exception->id) }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Material Type -->
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type <span class="text-danger">*</span></label>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $t)
                            <option value="{{ $t->id }}"
                                {{ old('material_type_id', $color_edge_exception->material_type_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Material Color -->
                    <div class="col-md-4 mb-3">
                        <label for="color_id">Material Color <span class="text-danger">*</span></label>
                        <select name="color_id" id="color_id" class="form-select">
                            <option value="">Select Material Color</option>
                            @foreach(($color ?? []) as $c)
                            <option value="{{ $c->id }}"
                                {{ old('color_id', $color_edge_exception->color_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('color_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Edge Profile -->
                    <div class="col-md-4 mb-3">
                        <label for="edge_profile_id">Edge Profile <span class="text-danger">*</span></label>
                        <select name="edge_profile_id" id="edge_profile_id" class="form-select">
                            <option value="">Select Edge Profile</option>
                            @foreach($edgeProfiles as $profile)
                            <option value="{{ $profile->id }}"
                                {{ old('edge_profile_id', $color_edge_exception->edge_profile_id) == $profile->id ? 'selected' : '' }}>
                                {{ $profile->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('edge_profile_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Thickness -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_id">Thickness <span class="text-danger">*</span></label>
                        <select name="thickness_id" id="thickness_id" class="form-select">
                            <option value="">Select Thickness</option>
                            @foreach($thicknesses as $thick)
                            <option value="{{ $thick->id }}"
                                {{ old('thickness_id', $color_edge_exception->thickness_id) == $thick->id ? 'selected' : '' }}>
                                {{ $thick->thickness_value }}
                            </option>
                            @endforeach
                        </select>
                        @error('thickness_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Override Business Price -->
                    <div class="col-md-4 mb-3">
                        <label>Override Price (Business) <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="override_price_per_lm" class="form-control"
                            value="{{ old('override_price_per_lm', $color_edge_exception->override_price_per_lm) }}">
                        @error('override_price_per_lm') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Override Guest Price -->
                    <div class="col-md-4 mb-3">
                        <label>Override Guest Price <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="override_guest_price_per_lm" class="form-control"
                            value="{{ old('override_guest_price_per_lm', $color_edge_exception->override_guest_price_per_lm) }}">
                        @error('override_guest_price_per_lm') <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $color_edge_exception->status) == 1 ? 'selected' : '' }}>
                                Active</option>
                            <option value="0" {{ old('status', $color_edge_exception->status) == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.color.edge.exception.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Dynamic JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const materialSelect = document.getElementById('material_type_id');
    const colorSelect = document.getElementById('color_id');
    const thicknessSelect = document.getElementById('thickness_id');
    const oldColor = "{{ old('color_id', $color_edge_exception->color_id) }}";
    const oldThickness = "{{ old('thickness_id', $color_edge_exception->thickness_id) }}";

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

    // On page load if old value exists
    if (materialSelect.value) {
        loadColors(materialSelect.value, oldColor);
        loadThickness(materialSelect.value, oldThickness);
    }

    // On change Material Type
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

@endsection
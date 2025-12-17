@extends('admin.layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add Backsplash Price</h3>
        <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.backsplash.price.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Backsplash Shapes *</label>
                        <select name="backsplash_shape_id" class="form-select">
                            <option value="">Select Backsplash Shapes</option>
                            @foreach($backsplashShapes as $mt)
                            <option value="{{ $mt->id }}" {{ old('backsplash_shape_id') == $mt->id ? 'selected' : '' }}>
                                {{ $mt->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('backsplash_shape_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Material Type *</label>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($materialTypes as $mt)
                            <option value="{{ $mt->id }}" {{ old('material_type_id') == $mt->id ? 'selected' : '' }}>
                                {{ $mt->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
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

                    <div class="col-md-4 mb-3">
                        <label>Price (Guest) *</label>
                        <input type="number" name="price_lm_guest" value="{{ old('price_lm_guest') }}"
                            class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Guest)</label>
                        <input type="number" name="finished_side_price_lm_guest"
                            value="{{ old('finished_side_price_lm_guest') }}" class="form-control" step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Price (Business) *</label>
                        <input type="number" name="price_lm_business" value="{{ old('price_lm_business') }}"
                            class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Business)</label>
                        <input type="number" name="finished_side_price_lm_business"
                            value="{{ old('finished_side_price_lm_business') }}" class="form-control" step="0.01">
                    </div>

                    <!-- <div class="col-md-4 mb-3">
                        <label>Min Height (mm)</label>
                        <input type="number" name="min_height_mm" value="{{ old('min_height_mm') }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Max Height (mm)</label>
                        <input type="number" name="max_height_mm" value="{{ old('max_height_mm') }}" class="form-control">
                    </div> -->

                    <div class="col-md-4 mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-danger ms-2">Cancel</a>
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
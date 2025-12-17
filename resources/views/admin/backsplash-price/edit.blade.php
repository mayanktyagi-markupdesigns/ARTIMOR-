@extends('admin.layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Backsplash Price</h3>
        <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.backsplash.price.update', $price->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Backsplash Shapes *</label>
                        <select name="backsplash_shape_id" class="form-select">
                            <option value="">Select Backsplash Shapes</option>
                            @foreach($backsplashShapes as $mt)
                            <option value="{{ $mt->id }}"
                                {{ $price->backsplash_shape_id == $mt->id ? 'selected' : '' }}>
                                {{ $mt->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('backsplash_shape_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Material Type *</label>
                        <select name="material_type_id" id="material_type_id" class="form-select" required>
                            <option value="">Select Material Type</option>
                            @foreach($materialTypes as $mt)
                            <option value="{{ $mt->id }}" {{ $price->material_type_id == $mt->id ? 'selected' : '' }}>
                                {{ $mt->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Thickness (Dynamic) --}}
                    <div class="col-md-4 mb-3">
                        <label for="thickness_id">Thickness <span class="text-danger">*</span></label>
                        <select name="thickness_id" id="thickness_id" class="form-select" disabled>
                            <option value="">Select Thickness</option>
                        </select>
                        @error('thickness_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Price (Guest) *</label>
                        <input type="number" name="price_lm_guest" value="{{ $price->price_lm_guest }}"
                            class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Guest)</label>
                        <input type="number" name="finished_side_price_lm_guest"
                            value="{{ $price->finished_side_price_lm_guest }}" class="form-control" step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Price (Business) *</label>
                        <input type="number" name="price_lm_business" value="{{ $price->price_lm_business }}"
                            class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Business)</label>
                        <input type="number" name="finished_side_price_lm_business"
                            value="{{ $price->finished_side_price_lm_business }}" class="form-control" step="0.01">
                    </div>

                    <!-- <div class="col-md-4 mb-3">
                        <label>Min Height (mm)</label>
                        <input type="number" name="min_height_mm" value="{{ $price->min_height_mm }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Max Height (mm)</label>
                        <input type="number" name="max_height_mm" value="{{ $price->max_height_mm }}" class="form-control">
                    </div> -->

                    <div class="col-md-4 mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $price->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $price->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    const materialSelect = $('#material_type_id');
    const thicknessSelect = $('#thickness_id');
    const oldThickness = "{{ old('thickness_id', $price->thickness_id) }}";

    function loadThickness(materialTypeId, selectedId = null) {
        thicknessSelect.html('<option value="">Loading...</option>');
        thicknessSelect.prop('disabled', true);

        $.getJSON(`/admin/edge-profile-thickness/material-type/${materialTypeId}/thicknesses`, function(data) {
            let html = '<option value="">Select Thickness</option>';
            if (data.length === 0) {
                html += '<option value="">No thickness available</option>';
            } else {
                $.each(data, function(i, item) {
                    const selected = selectedId == item.id ? 'selected' : '';
                    html +=
                        `<option value="${item.id}" ${selected}>${item.thickness_value}</option>`;
                });
            }
            thicknessSelect.html(html);
            thicknessSelect.prop('disabled', false);
        }).fail(function() {
            thicknessSelect.html('<option value="">Error loading thickness</option>');
        });
    }

    // On page load
    if (materialSelect.val()) {
        loadThickness(materialSelect.val(), oldThickness);
    }

    // On change Material Type
    materialSelect.change(function() {
        const materialId = $(this).val();
        if (materialId) {
            loadThickness(materialId);
        } else {
            thicknessSelect.html('<option value="">Select Thickness</option>');
            thicknessSelect.prop('disabled', true);
        }
    });
});
</script>
@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Edge Profile Thickness Rule</h3>
        <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')

            <form action="{{ route('admin.edge.profile.thickness.update', $rule->id) }}" method="POST">
                @csrf
                <div class="row">

                    {{-- Material Type --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type <span class="text-danger">*</span></label>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $t)
                            <option value="{{ $t->id }}"
                                {{ old('material_type_id', $rule->material_type_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Edge Profile --}}
                    <div class="col-md-4 mb-3">
                        <label for="edge_profile_id">Edge Profile <span class="text-danger">*</span></label>
                        <select name="edge_profile_id" id="edge_profile_id" class="form-select">
                            <option value="">Select Edge Profile</option>
                            @foreach($edgeProfiles as $profile)
                            <option value="{{ $profile->id }}"
                                {{ old('edge_profile_id', $rule->edge_profile_id) == $profile->id ? 'selected' : '' }}>
                                {{ $profile->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('edge_profile_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
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

                </div>

                <div class="row">
                    {{-- Guest Price --}}
                    <div class="col-md-4 mb-3">
                        <label for="price_per_lm_guest">Price (Guest) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="price_per_lm_guest" class="form-control"
                            value="{{ old('price_per_lm_guest', $rule->price_per_lm_guest) }}"
                            placeholder="Enter guest price">
                        @error('price_per_lm_guest')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Business Price --}}
                    <div class="col-md-4 mb-3">
                        <label for="price_per_lm_business">Price (Business) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="price_per_lm_business" class="form-control"
                            value="{{ old('price_per_lm_business', $rule->price_per_lm_business) }}"
                            placeholder="Enter business price">
                        @error('price_per_lm_business')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $rule->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $rule->status) == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-danger ms-2">Cancel</a>
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
    const oldThickness = "{{ old('thickness_id', $rule->thickness_id) }}";

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
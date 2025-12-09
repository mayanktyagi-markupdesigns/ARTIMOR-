@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Thickness Options</h3>
        <a href="{{ route('admin.thickness.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.thickness.update', $thickness->id) }}" method="POST" id="thicknessForm">
                @csrf
                <div class="row">
                    <!-- Material Group -->
                    <div class="col-md-4 mb-3">
                        <label for="material_group_id">Material Group</label><span style="color:red;">*</span>
                        <select class="form-select" name="material_group_id" id="material_group_id" required>
                            <option value="">Select Material Group</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}"
                                {{ old('material_group_id', $thickness->material_group_id) == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_group_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Material Type -->
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type</label><span style="color:red;">*</span>
                        <select class="form-select" name="material_type_id" id="material_type_id" required>
                            <option value="">Select Material Type</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}"
                                {{ old('material_type_id', $thickness->material_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Thickness -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_value">Thickness (mm)</label><span class="text-danger">*</span>
                        <input type="text" name="thickness_value" id="thickness_value" class="form-control"
                            value="{{ old('thickness_value', $thickness->thickness_value) }}" required>
                        @error('thickness_value')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Is Massive -->
                    <div class="col-md-4 mb-3">
                        <label>Is Massive?</label>
                        <select name="is_massive" class="form-select">
                            <option value="0" {{ old('is_massive', $thickness->is_massive) == 0 ? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ old('is_massive', $thickness->is_massive) == 1 ? 'selected' : '' }}>Yes
                            </option>
                        </select>
                    </div>

                    <!-- Can Be Laminated -->
                    <div class="col-md-4 mb-3">
                        <label>Can Be Laminated?</label>
                        <select name="can_be_laminated" id="can_be_laminated" class="form-select">
                            <option value="0"
                                {{ old('can_be_laminated', $thickness->can_be_laminated) == 0 ? 'selected' : '' }}>No
                            </option>
                            <option value="1"
                                {{ old('can_be_laminated', $thickness->can_be_laminated) == 1 ? 'selected' : '' }}>Yes
                            </option>
                        </select>
                    </div>

                    <!-- Laminate Min -->
                    <div class="col-md-4 mb-3">
                        <label>Lamination Min (mm)</label>
                        <input type="number" name="laminate_min" id="laminate_min" class="form-control"
                            value="{{ old('laminate_min', $thickness->laminate_min) }}"
                            {{ old('can_be_laminated', $thickness->can_be_laminated) == 1 ? '' : 'disabled' }}>
                    </div>

                    <!-- Laminate Max -->
                    <div class="col-md-4 mb-3">
                        <label>Lamination Max (mm)</label>
                        <input type="number" name="laminate_max" id="laminate_max" class="form-control"
                            value="{{ old('laminate_max', $thickness->laminate_max) }}"
                            {{ old('can_be_laminated', $thickness->can_be_laminated) == 1 ? '' : 'disabled' }}>
                    </div>

                    <!-- Business Price -->
                    <div class="col-md-4 mb-3">
                        <label>Business Price (per m²)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" name="bussiness_price_m2" class="form-control"
                            value="{{ old('bussiness_price_m2', $thickness->bussiness_price_m2) }}" required>
                    </div>

                    <!-- Guest Price -->
                    <div class="col-md-4 mb-3">
                        <label>Guest Price (per m²)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" name="guest_price_m2" class="form-control"
                            value="{{ old('guest_price_m2', $thickness->guest_price_m2) }}" required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $thickness->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $thickness->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.thickness.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$('#can_be_laminated').on('change', function() {
    if ($(this).val() == 1) {
        $('#laminate_min, #laminate_max').removeAttr('disabled');
    } else {
        $('#laminate_min, #laminate_max').attr('disabled', true).val('');
    }
});

//Dependecy Dropdown

$(document).ready(function() {

    // Safe JSON variables (no syntax error)
    let currentMaterialTypeId = {!! json_encode(old('material_type_id', $thickness->material_type_id)) !!};
    let currentMaterialGroupId = {!! json_encode(old('material_group_id', $thickness->material_group_id)) !!};

    // Auto-load types if group is selected
    if (currentMaterialGroupId) {
        loadMaterialTypes(currentMaterialGroupId, currentMaterialTypeId);
    }

    // On material group change
    $('#material_group_id').on('change', function() {
        let groupId = $(this).val();
        loadMaterialTypes(groupId, null);
    });

    // Function to fetch material types
    function loadMaterialTypes(groupId, selectedId = null) {
        let typeSelect = $('#material_type_id');

        typeSelect.html('<option value="">Loading...</option>');

        if (!groupId) {
            typeSelect.html('<option value="">Select Material Group First</option>');
            return;
        }

        $.ajax({
            url: '{{ route("admin.thickness.getMaterialTypes") }}',
            type: 'GET',
            data: { material_group_id: groupId },
            success: function(response) {
                typeSelect.html('<option value="">Select Material Type</option>');

                if (response.types && response.types.length > 0) {
                    $.each(response.types, function(index, type) {
                        typeSelect.append(
                            `<option value="${type.id}">${type.name}</option>`
                        );
                    });

                    if (selectedId) {
                        typeSelect.val(selectedId);
                    }
                } else {
                    typeSelect.html('<option value="">No Material Types Available</option>');
                }
            },
            error: function() {
                typeSelect.html('<option value="">Error loading material types</option>');
            }
        });
    }
});
</script>
@endpush
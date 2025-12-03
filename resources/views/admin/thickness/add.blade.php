@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add New Thickness Options</h3>
        <a href="{{ route('admin.thickness.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.thickness.store') }}" method="POST" id="thicknessForm">
                @csrf
                <div class="row">
                    <!-- Material Group -->
                    <div class="col-md-4 mb-3">
                        <label for="material_group_id">Material Group</label><span style="color:red;">*</span>
                        <select class="form-select" name="material_group_id" id="material_group_id" required>
                            <option value="">Select Material Group</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}"
                                {{ old('material_group_id') == $group->id ? 'selected' : '' }}>
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
                            <option value="">Select Material Group First</option>
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Finish Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label for="finish_id">Finish</label><span class="text-danger">*</span>
                        <select name="finish_id" id="finish_id" class="form-select" required>
                            <option value="">Select Finish</option>
                            @foreach($finishes as $finish)
                            <option value="{{ $finish->id }}" {{ old('finish_id') == $finish->id ? 'selected' : '' }}>
                                {{ $finish->finish_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('finish_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Thickness Value -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_value">Thickness (mm)</label><span class="text-danger">*</span>
                        <input type="text" name="thickness_value" id="thickness_value" class="form-control"
                            placeholder="Enter e.g. 12mm or 20mm" value="{{ old('thickness_value') }}" required>
                        @error('thickness_value')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Is Massive -->
                    <div class="col-md-4 mb-3">
                        <label>Is Massive?</label>
                        <select name="is_massive" class="form-select">
                            <option value="0" {{ old('is_massive') == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_massive') == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                        @error('is_massive')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Can Be Laminated -->
                    <div class="col-md-4 mb-3">
                        <label>Can Be Laminated?</label>
                        <select name="can_be_laminated" id="can_be_laminated" class="form-select">
                            <option value="0" {{ old('can_be_laminated') == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('can_be_laminated') == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                        @error('can_be_laminated')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Lamination Range -->
                    <div class="col-md-4 mb-3">
                        <label>Lamination Min (mm)</label>
                        <input type="number" name="laminate_min" id="laminate_min" class="form-control"
                            value="{{ old('laminate_min') }}" {{ old('can_be_laminated') ? '' : 'disabled' }}>
                        @error('laminate_min')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Lamination Max (mm)</label>
                        <input type="number" name="laminate_max" id="laminate_max" class="form-control"
                            value="{{ old('laminate_max') }}" {{ old('can_be_laminated') ? '' : 'disabled' }}>
                        @error('laminate_max')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Business Price -->
                    <div class="col-md-4 mb-3">
                        <label>Business Price (per m²)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" name="bussiness_price_m2" class="form-control"
                            value="{{ old('bussiness_price_m2', 0) }}" required>
                        @error('bussiness_price_m2')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Guest Price -->
                    <div class="col-md-4 mb-3">
                        <label>Guest Price (per m²)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" name="guest_price_m2" class="form-control"
                            value="{{ old('guest_price_m2', 0) }}" required>
                        @error('guest_price_m2')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.thickness.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Enable/Disable laminate fields
$('#can_be_laminated').on('change', function() {
    if ($(this).val() == 1) {
        $('#laminate_min, #laminate_max').removeAttr('disabled');
    } else {
        $('#laminate_min, #laminate_max').attr('disabled', true).val('');
    }
});

//Dependecy Dropdpwn
$(document).ready(function() {
    // When Material Group changes, fetch Material Types
    $('#material_group_id').on('change', function() {
        var materialGroupId = $(this).val();
        var materialTypeSelect = $('#material_type_id');
        
        // Clear existing options
        materialTypeSelect.html('<option value="">Loading...</option>');
        
        if (materialGroupId) {
            // Fetch material types via AJAX
            $.ajax({
                url: '{{ route("admin.color.getMaterialTypes") }}',
                type: 'GET',
                data: {
                    material_group_id: materialGroupId
                },
                success: function(response) {
                    materialTypeSelect.html('<option value="">Select Material Type</option>');
                    if (response.types && response.types.length > 0) {
                        $.each(response.types, function(index, type) {
                            materialTypeSelect.append(
                                $('<option></option>')
                                    .attr('value', type.id)
                                    .text(type.name)
                            );
                        });
                    } else {
                        materialTypeSelect.html('<option value="">No Material Types Available</option>');
                    }
                },
                error: function() {
                    materialTypeSelect.html('<option value="">Error loading Material Types</option>');
                }
            });
        } else {
            materialTypeSelect.html('<option value="">Select Material Group First</option>');
        }
    });

    // If there's an old material_group_id (from validation errors), trigger the change
    @if(old('material_group_id'))
        $('#material_group_id').trigger('change');
        // After a short delay, set the old material_type_id
        setTimeout(function() {
            $('#material_type_id').val('{{ old("material_type_id") }}');
        }, 500);
    @endif
});
</script>
@endpush
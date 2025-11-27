@extends('admin.layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Material Color</h3>
        <a href="{{ route('admin.color.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.color.update', $color->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name">Name</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $color->name) }}" placeholder="Enter name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Material Group -->
                    <div class="col-md-4 mb-3">
                        <label for="material_group_id">Material Group</label><span style="color:red;">*</span>
                        <select class="form-select" name="material_group_id" id="material_group_id" required>
                            <option value="">Select Material Group</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}" 
                                {{ old('material_group_id', $color->material_group_id) == $group->id ? 'selected' : '' }}>
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
                                {{ old('material_type_id', $color->material_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label><span style="color:red;">*</span>
                        <select class="form-select" name="status" id="status" required>
                            <option value="1" {{ old('status', $color->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $color->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.color.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var currentMaterialTypeId = {{ old('material_type_id', $color->material_type_id) ?? 'null' }};
    var isInitialLoad = true;
    
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
                            var option = $('<option></option>')
                                .attr('value', type.id)
                                .text(type.name);
                            
                            // Select if it matches current material type id
                            if (currentMaterialTypeId && type.id == currentMaterialTypeId) {
                                option.attr('selected', 'selected');
                            }
                            
                            materialTypeSelect.append(option);
                        });
                        
                        // After populating, select the current value if it exists
                        if (currentMaterialTypeId) {
                            materialTypeSelect.val(currentMaterialTypeId);
                        }
                        
                        // Reset currentMaterialTypeId after first load
                        if (isInitialLoad) {
                            currentMaterialTypeId = null;
                            isInitialLoad = false;
                        }
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

    // Trigger change if material_group_id was changed during validation errors
    @if(old('material_group_id') && old('material_group_id') != $color->material_group_id)
        currentMaterialTypeId = {{ old('material_type_id') ?? 'null' }};
        $('#material_group_id').trigger('change');
    @endif
});
</script>
@endpush

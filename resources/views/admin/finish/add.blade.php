@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add New Finish Variants</h3>
        <a href="{{ route('admin.finish.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.finish.store') }}" method="POST" enctype="multipart/form-data"
                    id="finishForm">
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

                        <div class="col-md-4 mb-3">
                            <label for="color_id">Material Color</label><span style="color:red;">*</span>
                            <select class="form-select" name="color_id" id="color_id">
                                <option value="">Select Material Color</option>
                                @foreach($color as $color)
                                <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('material_group_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Finish Name -->
                        <div class="col-md-4 mb-3">
                            <label for="finish_name">Finish Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="finish_name" id="finish_name"
                                value="{{ old('finish_name') }}" placeholder="Enter finish name" required>
                            @error('finish_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label><span style="color:red;">*</span>
                            <select class="form-select" name="status" id="status" required>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('admin.finish.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
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
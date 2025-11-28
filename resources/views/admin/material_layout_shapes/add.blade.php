@extends('admin.layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add New Material Layout Shape</h3>
        <a href="{{ route('admin.material.layout.shape.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.material.layout.shape.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-4 mb-3">
                            <label for="name">Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                                placeholder="Enter name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Material Layout Group -->
                        <div class="col-md-4 mb-3">
                            <label for="layout_group_id">Material Layout Group</label><span style="color:red;">*</span>
                            <select class="form-select" name="layout_group_id" id="layout_group_id">
                                <option value="">Select Material Layout Group</option>
                                @foreach($group as $group)
                                <option value="{{ $group->id }}"
                                    {{ old('layout_group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('layout_group_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Image -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label><span style="color:red;">*</span>
                            <input type="file" class="form-control" name="image" id="image"
                                accept=".jpg,.jpeg,.png,.JPG,.PNG,.svg">
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label>Dimension Sides</label>
                            <div id="dimension-wrapper">

                                <div class="row mb-2 single-side">
                                    <div class="col-md-4">
                                        <input type="text" name="dimension_sides[0][name]" class="form-control"
                                            placeholder="Side Name (e.g., Side A)">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="dimension_sides[0][min]" class="form-control"
                                            placeholder="Min Value">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="dimension_sides[0][max]" class="form-control"
                                            placeholder="Max Value">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-side d-none">X</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-side" class="btn btn-primary btn-sm mt-2">+ Add Side</button>
                        </div>
                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('admin.material.layout.shape.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let index = 1;

document.getElementById('add-side').addEventListener('click', function() {
    let html = `
        <div class="row mb-2 single-side">
            <div class="col-md-4">
                <input type="text" name="dimension_sides[${index}][name]" class="form-control" placeholder="Side Name">
            </div>
            <div class="col-md-3">
                <input type="number" name="dimension_sides[${index}][min]" class="form-control" placeholder="Min Value">
            </div>
            <div class="col-md-3">
                <input type="number" name="dimension_sides[${index}][max]" class="form-control" placeholder="Max Value">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-side">X</button>
            </div>
        </div>`;
    document.getElementById('dimension-wrapper').insertAdjacentHTML('beforeend', html);
    index++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-side')) {
        e.target.closest('.single-side').remove();
    }
});
</script>
@endsection
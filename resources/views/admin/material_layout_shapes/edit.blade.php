@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Material Layout Shape</h3>
        <a href="{{ route('admin.material.layout.shape.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.material.layout.shape.update', $shape->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label for="name">Name</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ old('name', $shape->name) }}" placeholder="Enter name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- Material Layout Group -->
                    <div class="col-md-4 mb-3">
                        <label for="layout_group_id">Material Layout Group</label><span class="text-danger">*</span>
                        <select class="form-select" name="layout_group_id" id="layout_group_id">
                            <option value="">Select Material Layout Group</option>
                            @foreach($group as $grp)
                            <option value="{{ $grp->id }}"
                                {{ old('layout_group_id', $shape->layout_group_id) == $grp->id ? 'selected' : '' }}>
                                {{ $grp->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('layout_group_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- Image -->
                    <div class="col-md-4 mb-3">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept=".jpg,.jpeg,.png,.svg">
                        @if($shape->image)
                        <img src="{{ asset('uploads/layout-shapes/'.$shape->image) }}" class="img-thumbnail mt-2"
                            width="120">
                        @endif

                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="1" {{ old('status', $shape->status) == '1' ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $shape->status) == '0' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                {{-- ===============================
                    DIMENSION SIDES (JSON INPUT)
                ================================== --}}

                @php
                $sides = old('dimension_sides', $shape->dimension_sides ?? []);
                @endphp

                <div class="col-12 mt-3">
                    <label class="fw-bold">Dimension Sides</label>
                    <div id="dimension-wrapper">
                        @if(!empty($sides))
                        @foreach($sides as $index => $side)
                        <div class="row mb-2 single-side">
                            <div class="col-md-4">
                                <input type="text" name="dimension_sides[{{ $index }}][name]" class="form-control"
                                    placeholder="Side Name" value="{{ $side['name'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="dimension_sides[{{ $index }}][min]" class="form-control"
                                    placeholder="Min" value="{{ $side['min'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="dimension_sides[{{ $index }}][max]" class="form-control"
                                    placeholder="Max" value="{{ $side['max'] ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-side">X</button>
                            </div>
                        </div>
                        @endforeach
                        @else
                        {{-- If no sides exist, show one default row --}}
                        <div class="row mb-2 single-side">
                            <div class="col-md-4">
                                <input type="text" name="dimension_sides[0][name]" class="form-control"
                                    placeholder="Side Name">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="dimension_sides[0][min]" class="form-control"
                                    placeholder="Min">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="dimension_sides[0][max]" class="form-control"
                                    placeholder="Max">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-side d-none">X</button>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" id="add-side" class="btn btn-primary btn-sm mt-2">+ Add Side</button>
                </div>
                <!-- Submit -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.material.layout.shape.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
let index = {
    {
        !empty($sides) ? count($sides) : 1
    }
};
document.getElementById('add-side').addEventListener('click', function() {
    let html = `
        <div class="row mb-2 single-side">
            <div class="col-md-4">
                <input type="text" name="dimension_sides[${index}][name]" class="form-control" placeholder="Side Name">
            </div>
            <div class="col-md-3">
                <input type="number" name="dimension_sides[${index}][min]" class="form-control" placeholder="Min">
            </div>
            <div class="col-md-3">
                <input type="number" name="dimension_sides[${index}][max]" class="form-control" placeholder="Max">
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
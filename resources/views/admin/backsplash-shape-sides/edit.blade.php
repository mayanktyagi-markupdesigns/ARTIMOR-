@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Backsplash Shapes Sides</h3>
        <a href="{{ route('admin.backsplash.shapes.sides.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.backsplash.shapes.sides.update', $side->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="backsplash_shape_id">Backsplash Shape *</label>
                        <select name="backsplash_shape_id" id="backsplash_shape_id" class="form-select" required>
                            <option value="">Select Shape</option>
                            @foreach($shapes as $shape)
                                <option value="{{ $shape->id }}" {{ $side->backsplash_shape_id == $shape->id ? 'selected' : '' }}>{{ $shape->name }}</option>
                            @endforeach
                        </select>
                        @error('backsplash_shape_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="side_name">Side Name *</label>
                        <input type="text" name="side_name" class="form-control" value="{{ old('side_name', $side->side_name) }}" placeholder="A, B, C..." required>
                        @error('side_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="label">Label</label>
                        <input type="text" name="label" class="form-control" value="{{ old('label', $side->label) }}" placeholder="Left Side, Right Side">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="is_finishable">Finishable *</label>
                        <select name="is_finishable" class="form-select" required>
                            <option value="1" {{ $side->is_finishable == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $side->is_finishable == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="sort_order">Sort Order *</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $side->sort_order) }}" required>
                    </div>

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
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.backsplash.shapes.sides.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
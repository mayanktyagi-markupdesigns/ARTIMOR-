@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add Backsplash Shapes</h3>
        <a href="{{ route('admin.backsplash.shapes.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.backsplash.shapes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name">Name</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                            placeholder="Enter name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Image -->
                    <div class="col-md-4 mb-3">
                        <label for="image">Image</label><span style="color:red;">*</span>
                        <input type="file" class="form-control" name="image" id="image"
                            accept=".jpg,.jpeg,.png,.JPG,.PNG,.svg">
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Sort Order *</label>
                        <input type="number" name="sort_order" value="1" class="form-control" required>
                    </div>

                    <!-- <div class="col-md-4 mb-3">
                        <label>Dimension Fields (comma separated)</label>
                        <input type="text" name="dimension_fields[]" class="form-control" placeholder="length,height">
                    </div> -->
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
                    <a href="{{ route('admin.backsplash.shapes.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
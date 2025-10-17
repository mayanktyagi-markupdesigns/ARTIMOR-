@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Dimension - <span style="color: blue;">{{ $dimension->id }}</span></h3>
        <a href="{{ route('admin.dimension.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.dimension.update', $dimension->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="image" class="form-label">Image</label><br />
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                            @if($dimension->image)
                            <img src="{{ asset('uploads/dimensions/' . $dimension->image) }}" width="100"
                                alt="Dimension Image" /><br />
                            @endif

                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="height_cm" class="form-label">Height (cm)</label><span
                                style="color:red;">*</span>
                            <input type="number" step="0.01" name="height_cm" id="height_cm" class="form-control"
                                value="{{ old('height_cm', $dimension->height_cm) }}" required />
                            @error('height_cm') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="width_cm" class="form-label">Width (cm)</label><span style="color:red;">*</span>
                            <input type="number" step="0.01" name="width_cm" id="width_cm" class="form-control"
                                value="{{ old('width_cm', $dimension->width_cm) }}" required />
                            @error('width_cm') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="1" {{ (old('status', $dimension->status) == 1) ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ (old('status', $dimension->status) == 0) ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.dimension.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
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
                            width="60">
                        @endif

                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Price Guest -->
                    <div class="col-md-4 mb-3">
                        <label for="price_guest">Price Guest <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="price_guest"
                            value="{{ old('price_guest', $shape->price_guest) }}" placeholder="Enter guest price">
                        @error('price_guest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Price Business -->
                    <div class="col-md-4 mb-3">
                        <label for="price_business">Price Business <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="price_business"
                            value="{{ old('price_business', $shape->price_business) }}"
                            placeholder="Enter business price">
                        @error('price_business') <small class="text-danger">{{ $message }}</small> @enderror
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

                <!-- Submit -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.material.layout.shape.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
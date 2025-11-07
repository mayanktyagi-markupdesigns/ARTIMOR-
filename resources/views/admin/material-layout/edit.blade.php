@extends('admin.layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Material Layout</h3>
        <a href="{{ route('admin.layout.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">  
            @include('admin.layouts.alerts')         
            <div class="">
                <form action="{{ route('admin.layout.update', $layout->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-4 mb-3">
                            <label for="name">Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="name" id="name" 
                                value="{{ old('name', $layout->name) }}" placeholder="Enter name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Material Type -->
                        <div class="col-md-4 mb-3">
                            <label for="material_layout_category_id">Material Layout Category</label><span style="color:red;">*</span>
                            <select class="form-select" name="material_layout_category_id" id="material_layout_category_id">
                                @foreach(($categories ?? []) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('material_layout_category_id', $layout->material_layout_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('material_layout_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Price -->
                        <div class="col-md-4 mb-3">
                            <label for="price">Per Sq/Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="price" 
                                value="{{ old('price', $layout->price) }}" placeholder="Enter price">
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="user_price">Per Sq/User Price</label>
                            <input type="number" step="0.01" class="form-control" name="user_price" id="user_price"
                                value="{{ old('user_price', $layout->user_price) }}" placeholder="Enter price">
                            @error('user_price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Image -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image"
                                accept=".jpg,.jpeg,.png,.JPG,.PNG,.svg">
                            @if($layout->image)
                                <img src="{{ asset('uploads/material-layout/'.$layout->image) }}" 
                                     alt="layout Image" class="img-thumbnail mt-2" width="120">
                            @endif
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{ old('status', $layout->status) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $layout->status) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.layout.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

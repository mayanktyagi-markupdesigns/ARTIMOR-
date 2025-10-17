@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add New Material Type</h3>
        <a href="{{ route('admin.material.type.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">  
            @include('admin.layouts.alerts')         
            <div class="">
                <form action="{{ route('admin.material.type.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">                                            
                        <!-- Type -->
                        <div class="col-md-4 mb-3">
                            <label for="type">Type</label><span style="color:red;">*</span>
                            <select class="form-select" name="type" id="type">
                                <option value="">Select Type</option>
                                <option value="Polished" {{ old('type') == 'Polished' ? 'selected' : '' }}>Polished</option>
                                <option value="Gray sanded" {{ old('type') == 'Gray sanded' ? 'selected' : '' }}>Gray sanded</option>
                                <option value="Dark honed" {{ old('type') == 'Dark honed' ? 'selected' : '' }}>Dark honed</option>
                                <option value="Leathano" {{ old('type') == 'Leathano' ? 'selected' : '' }}>Leathano</option>
                                <option value="Anticato" {{ old('type') == 'Anticato' ? 'selected' : '' }}>Anticato</option>
                            </select>
                            @error('type') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Image -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label><span style="color:red;">*</span>
                            <input type="file" class="form-control" name="image" id="image"
                                accept=".jpg,.jpeg,.png,.JPG,.PNG,.svg">
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Price -->
                        <div class="col-md-4 mb-3">
                            <label for="price">Per Sq/Price</label><span style="color:red;">*</span>
                            <input type="number" step="0.01" class="form-control" name="price" id="price" 
                                value="{{ old('price') }}" placeholder="Enter price">
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
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
                        <a href="{{ route('admin.material.type.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

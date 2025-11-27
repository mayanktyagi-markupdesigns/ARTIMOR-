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
                <form action="{{ route('admin.finish.store') }}" method="POST" enctype="multipart/form-data" id="finishForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="color_id">Material Color</label><span style="color:red;">*</span>
                            <select class="form-select" name="color_id" id="color_id">
                                <option value="">Select Material Color</option>
                                @foreach($color as $color)
                                <option value="{{ $color->id }}"
                                    {{ old('color_id') == $color->id ? 'selected' : '' }}>
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



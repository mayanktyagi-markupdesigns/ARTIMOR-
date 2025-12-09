@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Add Cutout Material Thickness Prices</h3>
        <a href="{{ route('admin.cutout.material.thickness.price.controller.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.cutout.material.thickness.price.controller.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Material type -->
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type<span class="text-danger">*</span></label>
                        <select name="material_type_id" class="form-select">
                            <option value="">SelectMaterial Type</option>
                            @foreach($type as $e)
                            <option value="{{ $e->id }}" {{ old('material_type_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Edge Profile -->
                    <div class="col-md-4 mb-3">
                        <label for="cut_out_id">Select Cut Outs <span class="text-danger">*</span></label>
                        <select name="cut_out_id" class="form-select">
                            <option value="">Select cutouts</option>
                            @foreach($cutouts as $e)
                            <option value="{{ $e->id }}" {{ old('cut_out_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('cut_out_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- thickness_value -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_value">Thickness Value</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="thickness_value" id="thickness_value"
                            value="{{ old('thickness_value') }}" placeholder="Enter thickness value">
                        @error('thickness_value') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Guest Price -->
                    <div class="col-md-4 mb-3">
                        <label>Price Guest <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="price_guest" class="form-control"
                            value="{{ old('price_guest') }}">
                        @error('price_guest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Business Price -->
                    <div class="col-md-4 mb-3">
                        <label>Price Business <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="price_business" class="form-control"
                            value="{{ old('price_business') }}">
                        @error('price_business') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', 1) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.cutout.material.thickness.price.controller.list') }}"
                        class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
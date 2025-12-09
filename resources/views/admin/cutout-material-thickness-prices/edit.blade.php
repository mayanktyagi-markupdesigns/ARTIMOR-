@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Cutout Material Thickness Prices</h3>
        <a href="{{ route('admin.cutout.material.thickness.price.controller.list') }}"
            class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form
                action="{{ route('admin.cutout.material.thickness.price.controller.update', $cutout_material_thickness->id) }}"
                method="POST">
                @csrf
                <div class="row">
                    {{-- Edge Profile --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type</label><span class="text-danger">*</span>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $type)
                            <option value="{{ $type->id }}"
                                {{ old('material_type_id', $cutout_material_thickness->material_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cut_out_id">Cut Outs</label><span class="text-danger">*</span>
                        <select name="cut_out_id" id="cut_out_id" class="form-select">
                            <option value="">Select Cut Outs</option>
                            @foreach($cutouts as $cutouts)
                            <option value="{{ $cutouts->id }}"
                                {{ old('cut_out_id', $cutout_material_thickness->cut_out_id) == $cutouts->id ? 'selected' : '' }}>
                                {{ $cutouts->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('cut_out_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="thickness_value">Thickness Value</label><span style="color:red;">*</span>
                    <input type="text" class="form-control" name="thickness_value" id="thickness_value"
                        value="{{ old('thickness_value', $cutout_material_thickness->thickness_value) }}"
                        placeholder="Enter thickness value">
                    @error('thickness_value') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="row">
                    {{-- Guest Price --}}
                    <div class="col-md-4 mb-3">
                        <label for="price_guest">Price Guest</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" class="form-control" name="price_guest"
                            value="{{ old('price_guest', $cutout_material_thickness->price_guest) }}"
                            placeholder="Enter guest price">
                        @error('price_guest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- price_business --}}
                    <div class="col-md-4 mb-3">
                        <label for="price_business">Price Business</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" class="form-control" name="price_business"
                            value="{{ old('price_business', $cutout_material_thickness->price_business) }}"
                            placeholder="Enter business price">
                        @error('price_business') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label><span class="text-danger">*</span>
                        <select name="status" class="form-select">
                            <option value="1"
                                {{ old('status', $cutout_material_thickness->status) == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0"
                                {{ old('status', $cutout_material_thickness->status) == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.cutout.material.thickness.price.controller.list') }}"
                        class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
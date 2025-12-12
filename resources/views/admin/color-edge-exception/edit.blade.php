@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Material Color Edge Exception</h3>

        <a href="{{ route('admin.color.edge.exception.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.color.edge.exception.update', $color_edge_exception->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type</label><span class="text-danger">*</span>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('material_type_id', $color_edge_exception->material_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="color_id">Material Color</label><span style="color:red;">*</span>
                        <select class="form-select" name="color_id" id="color_id">
                            @foreach(($color ?? []) as $color)
                            <option value="{{ $color->id }}"
                                {{ old('color_id', $color_edge_exception->color_id) == $color->id ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('color_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    {{-- Edge Profile --}}
                    <div class="col-md-4 mb-3">
                        <label for="edge_profile_id">Edge Profile</label><span class="text-danger">*</span>
                        <select name="edge_profile_id" id="edge_profile_id" class="form-select">
                            <option value="">Select Edge Profile</option>
                            @foreach($edgeProfiles as $profile)
                            <option value="{{ $profile->id }}"
                                {{ old('edge_profile_id', $color_edge_exception->edge_profile_id) == $profile->id ? 'selected' : '' }}>
                                {{ $profile->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('edge_profile_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Thickness --}}
                    <div class="col-md-4 mb-3">
                        <label for="thickness_id">Thickness</label><span class="text-danger">*</span>
                        <select name="thickness_id" id="thickness_id" class="form-select">
                            <option value="">Select Thickness</option>
                            @foreach($thicknesses as $thick)
                            <option value="{{ $thick->id }}"
                                {{ old('thickness_id', $color_edge_exception->thickness_id) == $thick->id ? 'selected' : '' }}>
                                {{ $thick->thickness_value }}
                            </option>
                            @endforeach
                        </select>
                        @error('thickness_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Is Allowed --}}
                    <!-- <div class="col-md-4 mb-3">
                        <label for="is_allowed">Is Allowed</label><span class="text-danger">*</span>
                        <select name="is_allowed" id="is_allowed" class="form-select">
                            <option value="true"
                                {{ old('is_allowed', $color_edge_exception->is_allowed) == 1 ? 'selected' : '' }}>True
                            </option>
                            <option value="false"
                                {{ old('is_allowed', $color_edge_exception->is_allowed) == 0 ? 'selected' : '' }}>False
                            </option>
                        </select>
                        @error('is_allowed') <small class="text-danger">{{ $message }}</small> @enderror
                    </div> -->
                    <!--override_price_per_lm-->
                    <div class="col-md-4 mb-3">
                        <label>Override Price (Business) <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="override_price_per_lm"
                               class="form-control" value="{{ old('override_price_per_lm', $color_edge_exception->override_price_per_lm) }}">
                        @error('override_price_per_lm') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>                    
                </div>
                <div class="row">
                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label><span class="text-danger">*</span>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $color_edge_exception->status) == 1 ? 'selected' : '' }}>
                                Active</option>
                            <option value="0" {{ old('status', $color_edge_exception->status) == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.color.edge.exception.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
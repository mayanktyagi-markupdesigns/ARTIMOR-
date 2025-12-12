@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Add Edge Profile Thickness Rule</h3>
        <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.edge.profile.thickness.store') }}" method="POST">
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
                        <label for="edge_profile_id">Edge Profile <span class="text-danger">*</span></label>
                        <select name="edge_profile_id" class="form-select">
                            <option value="">Select Edge Profile</option>
                            @foreach($edge as $e)
                            <option value="{{ $e->id }}" {{ old('edge_profile_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('edge_profile_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Thickness -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_id">Thickness <span class="text-danger">*</span></label>
                        <select name="thickness_id" class="form-select">
                            <option value="">Select Thickness</option>
                            @foreach($thickness as $t)
                            <option value="{{ $t->id }}" {{ old('thickness_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->thickness_value }}
                            </option>
                            @endforeach
                        </select>
                        @error('thickness_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Is Allowed -->
                    <!-- <div class="col-md-4 mb-3">
                        <label for="is_allowed">Is Allowed <span class="text-danger">*</span></label>
                        <select name="is_allowed" class="form-select">
                            <option value="">Select Option</option>
                            <option value="true" {{ old('is_allowed') == 'true' ? 'selected' : '' }}>Yes</option>
                            <option value="false" {{ old('is_allowed') == 'false' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('is_allowed') <small class="text-danger">{{ $message }}</small> @enderror
                    </div> -->

                    <!-- Guest Price -->
                    <div class="col-md-4 mb-3">
                        <label>Price (Guest) <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="price_per_lm_guest" class="form-control"
                            value="{{ old('price_per_lm_guest') }}">
                        @error('price_per_lm_guest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Business Price -->
                    <div class="col-md-4 mb-3">
                        <label>Price (Business) <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="0.01" name="price_per_lm_business" class="form-control"
                            value="{{ old('price_per_lm_business') }}">
                        @error('price_per_lm_business') <small class="text-danger">{{ $message }}</small> @enderror
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
                    <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Edge Profile Thickness Rule</h3>
        <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.edge.profile.thickness.update', $rule->id) }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Edge Profile --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type</label><span class="text-danger">*</span>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('material_type_id', $rule->material_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edge_profile_id">Edge Profile</label><span class="text-danger">*</span>
                        <select name="edge_profile_id" id="edge_profile_id" class="form-select">
                            <option value="">Select Edge Profile</option>
                            @foreach($edgeProfiles as $profile)
                                <option value="{{ $profile->id }}"
                                    {{ old('edge_profile_id', $rule->edge_profile_id) == $profile->id ? 'selected' : '' }}>
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
                                    {{ old('thickness_id', $rule->thickness_id) == $thick->id ? 'selected' : '' }}>
                                    {{ $thick->thickness_value }}
                                </option>
                            @endforeach
                        </select>
                        @error('thickness_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Is Allowed --}}
                    <div class="col-md-4 mb-3">
                        <label for="is_allowed">Is Allowed</label><span class="text-danger">*</span>
                        <select name="is_allowed" id="is_allowed" class="form-select">
                            <option value="true"  {{ old('is_allowed', $rule->is_allowed) == 1 ? 'selected' : '' }}>True</option>
                            <option value="false" {{ old('is_allowed', $rule->is_allowed) == 0 ? 'selected' : '' }}>False</option>
                        </select>
                        @error('is_allowed') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="row">
                    {{-- Guest Price --}}
                    <div class="col-md-4 mb-3">
                        <label for="price_per_lm_guest">Price Per LM (Guest)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" class="form-control" name="price_per_lm_guest"
                            value="{{ old('price_per_lm_guest', $rule->price_per_lm_guest) }}"
                            placeholder="Enter guest price">
                        @error('price_per_lm_guest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Business Price --}}
                    <div class="col-md-4 mb-3">
                        <label for="price_per_lm_business">Price Per LM (Business)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" class="form-control" name="price_per_lm_business"
                            value="{{ old('price_per_lm_business', $rule->price_per_lm_business) }}"
                            placeholder="Enter business price">
                        @error('price_per_lm_business') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label><span class="text-danger">*</span>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $rule->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $rule->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.edge.profile.thickness.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add Backsplash Price</h3>
        <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.backsplash.price.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Material Type *</label>
                        <select name="material_type_id" class="form-select" required>
                            <option value="">Select Material Type</option>
                            @foreach($materialTypes as $mt)
                                <option value="{{ $mt->id }}" {{ old('material_type_id') == $mt->id ? 'selected' : '' }}>
                                    {{ $mt->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Price LM (Guest) *</label>
                        <input type="number" name="price_lm_guest" value="{{ old('price_lm_guest') }}" class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Guest)</label>
                        <input type="number" name="finished_side_price_lm_guest" value="{{ old('finished_side_price_lm_guest') }}" class="form-control" step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Price LM (Business) *</label>
                        <input type="number" name="price_lm_business" value="{{ old('price_lm_business') }}" class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Business)</label>
                        <input type="number" name="finished_side_price_lm_business" value="{{ old('finished_side_price_lm_business') }}" class="form-control" step="0.01">
                    </div>

                    <!-- <div class="col-md-4 mb-3">
                        <label>Min Height (mm)</label>
                        <input type="number" name="min_height_mm" value="{{ old('min_height_mm') }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Max Height (mm)</label>
                        <input type="number" name="max_height_mm" value="{{ old('max_height_mm') }}" class="form-control">
                    </div> -->

                    <div class="col-md-4 mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

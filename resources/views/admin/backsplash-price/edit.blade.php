@extends('admin.layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Backsplash Price</h3>
        <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.backsplash.price.update', $price->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Material Type *</label>
                        <select name="material_type_id" class="form-select" required>
                            <option value="">Select Material Type</option>
                            @foreach($materialTypes as $mt)
                                <option value="{{ $mt->id }}" {{ $price->material_type_id == $mt->id ? 'selected' : '' }}>
                                    {{ $mt->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Price (Guest) *</label>
                        <input type="number" name="price_lm_guest" value="{{ $price->price_lm_guest }}" class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Guest)</label>
                        <input type="number" name="finished_side_price_lm_guest" value="{{ $price->finished_side_price_lm_guest }}" class="form-control" step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Price (Business) *</label>
                        <input type="number" name="price_lm_business" value="{{ $price->price_lm_business }}" class="form-control" required step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Finished Side Price (Business)</label>
                        <input type="number" name="finished_side_price_lm_business" value="{{ $price->finished_side_price_lm_business }}" class="form-control" step="0.01">
                    </div>

                    <!-- <div class="col-md-4 mb-3">
                        <label>Min Height (mm)</label>
                        <input type="number" name="min_height_mm" value="{{ $price->min_height_mm }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Max Height (mm)</label>
                        <input type="number" name="max_height_mm" value="{{ $price->max_height_mm }}" class="form-control">
                    </div> -->

                    <div class="col-md-4 mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $price->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $price->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.backsplash.price.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

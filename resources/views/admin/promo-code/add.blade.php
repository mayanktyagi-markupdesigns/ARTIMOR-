@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add New Promo Code</h3>
        <a href="{{ route('admin.promo.code.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            
            <form action="{{ route('admin.promo.code.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="code">Promo Code</label>
                        <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}" placeholder="Enter Promo Code">
                        @error('code') <small class="text-danger">{{ $message }}</small> @enderror      
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="discount_type">Discount Type</label>
                        <select class="form-select" name="discount_type" id="discount_type">
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Percent</option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        </select>
                        @error('discount_type') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="discount_value">Discount Value</label>
                        <input type="number" class="form-control" name="discount_value" id="discount_value" value="{{ old('discount_value') }}" step="0.01" placeholder="Enter Discount Value">
                        @error('discount_value') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}">
                        @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date') }}">
                        @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

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
                    <a href="{{ route('admin.promo.code.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

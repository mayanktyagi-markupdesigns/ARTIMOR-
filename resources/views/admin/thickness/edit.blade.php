@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Thickness Options</h3>
        <a href="{{ route('admin.thickness.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')

            <form action="{{ route('admin.thickness.update', $thickness->id) }}" method="POST" id="thicknessForm">
                @csrf

                <div class="row">

                    <!-- Finish -->
                    <div class="col-md-4 mb-3">
                        <label for="finish_id">Finish</label><span class="text-danger">*</span>
                        <select name="finish_id" id="finish_id" class="form-select" required>
                            <option value="">Select Finish</option>
                            @foreach($finishes as $finish)
                            <option value="{{ $finish->id }}" 
                                {{ old('finish_id', $thickness->finish_id) == $finish->id ? 'selected' : '' }}>
                                {{ $finish->finish_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('finish_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Thickness -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_value">Thickness (mm)</label><span class="text-danger">*</span>
                        <input type="text" name="thickness_value" id="thickness_value" 
                            class="form-control"
                            value="{{ old('thickness_value', $thickness->thickness_value) }}"
                            required>
                        @error('thickness_value')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <!-- Is Massive -->
                    <div class="col-md-4 mb-3">
                        <label>Is Massive?</label>
                        <select name="is_massive" class="form-select">
                            <option value="0" {{ old('is_massive', $thickness->is_massive) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_massive', $thickness->is_massive) == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <!-- Can Be Laminated -->
                    <div class="col-md-4 mb-3">
                        <label>Can Be Laminated?</label>
                        <select name="can_be_laminated" id="can_be_laminated" class="form-select">
                            <option value="0" {{ old('can_be_laminated', $thickness->can_be_laminated) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('can_be_laminated', $thickness->can_be_laminated) == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <!-- Laminate Min -->
                    <div class="col-md-4 mb-3">
                        <label>Lamination Min (mm)</label>
                        <input type="number" name="laminate_min" id="laminate_min"
                            class="form-control"
                            value="{{ old('laminate_min', $thickness->laminate_min) }}"
                            {{ old('can_be_laminated', $thickness->can_be_laminated) == 1 ? '' : 'disabled' }}>
                    </div>

                    <!-- Laminate Max -->
                    <div class="col-md-4 mb-3">
                        <label>Lamination Max (mm)</label>
                        <input type="number" name="laminate_max" id="laminate_max"
                            class="form-control"
                            value="{{ old('laminate_max', $thickness->laminate_max) }}"
                            {{ old('can_be_laminated', $thickness->can_be_laminated) == 1 ? '' : 'disabled' }}>
                    </div>

                    <!-- Business Price -->
                    <div class="col-md-4 mb-3">
                        <label>Business Price (per m²)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" name="bussiness_price_m2" class="form-control"
                            value="{{ old('bussiness_price_m2', $thickness->bussiness_price_m2) }}" required>
                    </div>

                    <!-- Guest Price -->
                    <div class="col-md-4 mb-3">
                        <label>Guest Price (per m²)</label><span class="text-danger">*</span>
                        <input type="number" step="0.01" name="guest_price_m2" class="form-control"
                            value="{{ old('guest_price_m2', $thickness->guest_price_m2) }}" required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $thickness->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $thickness->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.thickness.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#can_be_laminated').on('change', function() {
        if ($(this).val() == 1) {
            $('#laminate_min, #laminate_max').removeAttr('disabled');
        } else {
            $('#laminate_min, #laminate_max').attr('disabled', true).val('');
        }
    });
</script>
@endpush

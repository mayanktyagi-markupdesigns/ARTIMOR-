@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Thickness Options Details</h3>       
        <a href="{{ route('admin.thickness.list') }}" class="btn btn-secondary btn-custom-add">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>        
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Finish</label>
                    <p>{{ $thickness->finish->finish_name ?? '—' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Thickness Value</label>
                    <p>{{ $thickness->thickness_value }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Is Massive?</label>
                    <p>
                        @if($thickness->is_massive)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Can Be Laminated?</label>
                    <p>
                        @if($thickness->can_be_laminated)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </p>
                </div>
                @if($thickness->can_be_laminated)
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Laminate Min</label>
                        <p>{{ $thickness->laminate_min ?? '—' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Laminate Max</label>
                        <p>{{ $thickness->laminate_max ?? '—' }}</p>
                    </div>
                @endif

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Business Price (m²)</label>
                    <p>₹ {{ number_format($thickness->bussiness_price_m2, 2) }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Guest Price (m²)</label>
                    <p>₹ {{ number_format($thickness->guest_price_m2, 2) }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Status</label>
                    <p>
                        @if ($thickness->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Created At</label>
                    <p>{{ $thickness->created_at->format('d M, Y h:i A') }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Updated At</label>
                    <p>{{ $thickness->updated_at->format('d M, Y h:i A') }}</p>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection

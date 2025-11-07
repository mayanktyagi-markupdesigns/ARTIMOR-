@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">View Sink Details</h3>
        <a href="{{ route('admin.sink.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Name -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Name:</label>
                    <p>{{ $sink->name }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Per Sq/Price:</label>
                    <p>{{ $sink->price }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Name:</label>
                    <p>{{ $sink->name }}</p>
                </div>

                <!-- Series Type -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Sink Category:</label>
                    <p>{{ $sink->category->name ?? '—' }}</p>
                </div>

                <!-- Internal Dimensions -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Internal Dimensions:</label>
                    <p>{{ $sink->internal_dimensions ?? '-' }}</p>
                </div>

                <!-- External Dimensions -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">External Dimensions:</label>
                    <p>{{ $sink->external_dimensions ?? '-' }}</p>
                </div>

                <!-- Depth -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Depth (mm):</label>
                    <p>{{ $sink->depth ?? '-' }}</p>
                </div>

                <!-- Radius -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Radius (mm):</label>
                    <p>{{ $sink->radius ?? '-' }}</p>
                </div>

                <!-- Status -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <p>
                        @if ($sink->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>

                <!-- Images -->
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Images:</label>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($sink->images as $image)
                            <div class="position-relative">
                                <img src="{{ asset('uploads/sinks/' . $image->image) }}" 
                                     alt="Sink Image" 
                                     style="width:100px; height:100px; object-fit:cover;" 
                                     class="rounded">
                            </div>
                        @empty
                            <p class="text-muted">No images available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-eye-fill text-primary me-2"></i> View Material Layout Shape
        </h3>
        <a href="{{ route('admin.material.layout.shape.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <!-- Main Info Section -->
            <div class="row">
                <!-- Name -->
                <div class="col-md-6 mb-4">
                    <div class="info-card p-3 border rounded bg-light">
                        <label class="fw-bold text-secondary">
                            <i class="bi bi-tag-fill me-1 text-dark"></i> Name
                        </label>
                        <p class="mt-2 h6">{{ $shape->name }}</p>
                    </div>
                </div>

                <!-- Layout Group -->
                <div class="col-md-6 mb-4">
                    <div class="info-card p-3 border rounded bg-light">
                        <label class="fw-bold text-secondary">
                            <i class="bi bi-grid-fill me-1 text-dark"></i> Material Layout Group
                        </label>
                        <p class="mt-2 h6">{{ $shape->layoutGroup->name ?? '—' }}</p>
                    </div>
                </div>

                <!-- Image -->
                <div class="col-md-6 mb-4">
                    <div class="info-card p-3 border rounded bg-light">
                        <label class="fw-bold text-secondary">
                            <i class="bi bi-image-fill me-1 text-dark"></i> Image
                        </label>
                        <div class="mt-3 text-center">
                            @if($shape->image)
                            <img src="{{ asset('uploads/layout-shapes/' . $shape->image) }}"
                                class="img-thumbnail shadow-sm rounded" width="60" alt="Shape Image">
                            @else
                            <p class="text-muted">No image uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="info-card p-3 border rounded bg-light">
                        <label class="fw-bold text-secondary">
                            <i class="bi bi-tag-fill me-1 text-dark"></i> Price Guest
                        </label>
                        <p class="mt-2 h6">{{ $shape->price_guest }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="info-card p-3 border rounded bg-light">
                        <label class="fw-bold text-secondary">
                            <i class="bi bi-tag-fill me-1 text-dark"></i> Price Business
                        </label>
                        <p class="mt-2 h6">{{ $shape->price_business }}</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-4">
                    <div class="info-card p-3 border rounded bg-light">
                        <label class="fw-bold text-secondary">
                            <i class="bi bi-check2-circle me-1 text-dark"></i> Status
                        </label>
                        <p class="mt-3">
                            @if ($shape->status == 1)
                            <span class="badge bg-success px-3 py-2">Active</span>
                            @else
                            <span class="badge bg-danger px-3 py-2">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                                     class="img-thumbnail shadow-sm rounded"
                                     width="200" alt="Shape Image">
                            @else
                                <p class="text-muted">No image uploaded</p>
                            @endif
                        </div>
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

            <!-- Dimension Sides -->
            <!-- <div class="mt-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-rulers text-primary me-2"></i> Dimension Sides
                </h5>

                @if(!empty($shape->dimension_sides))
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle shadow-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Side Name</th>
                                    <th>Min Value</th>
                                    <th>Max Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shape->dimension_sides as $side)
                                    <tr>
                                        <td>{{ $side['name'] ?? '—' }}</td>
                                        <td>{{ $side['min'] ?? '—' }}</td>
                                        <td>{{ $side['max'] ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted border p-3 bg-light rounded text-center">
                        <i class="bi bi-info-circle me-1"></i> No dimension sides added
                    </p>
                @endif
            </div> -->
        </div>
    </div>
</div>
@endsection

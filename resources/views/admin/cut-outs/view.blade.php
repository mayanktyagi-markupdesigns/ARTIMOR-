@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">View Cut Outs Details</h3>
        <a href="{{ route('admin.cut.outs.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Name -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Name:</label>
                    <p>{{ $outs->name }}</p>
                </div>

                <!-- price -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Per Sq/Price:</label>
                    <p>€{{ $outs->price }}</p>
                </div>

                <!-- User price -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Per Sq/User Price:</label>
                    <p>€{{ $outs->user_price }}</p>
                </div>

                <!-- Cut Outs Category -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Cut Outs Category:</label>
                    <p>{{ $outs->category->name ?? '—' }}</p>
                </div>                

                <!-- Description -->
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Description:</label>
                    <p>{{ $outs->description ?? '-' }}</p>
                </div>

                <!-- Status -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <p>
                        @if ($outs->status == 1)
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
                        @forelse($outs->images as $image)
                            <div class="position-relative">
                                <img src="{{ asset('uploads/cut-outs/' . $image->image) }}" 
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

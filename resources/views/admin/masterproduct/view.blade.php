@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Master Product Details</h3>
        <div>
            <a href="{{ route('admin.masterproduct.edit', $product->id) }}" class="btn btn-primary me-2">
                <i class="bi bi-pencil-square me-1"></i>Edit
            </a>
            <a href="{{ route('admin.masterproduct.list') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to List
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">General Information</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 40%">Product Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($product->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>{{ optional($product->color)->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Total Price (Approx.)</th>
                                <td>Rs. {{ number_format($product->total_price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $product->created_at?->format('d M Y, h:i A') ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $product->updated_at?->format('d M Y, h:i A') ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Material Selection</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 40%">Material Category</th>
                                <td>{{ optional(optional($product->material)->category)->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Material</th>
                                <td>{{ optional($product->material)->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Material Type Category</th>
                                <td>{{ optional(optional($product->materialType)->category)->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Material Type</th>
                                <td>{{ optional($product->materialType)->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Layout Category</th>
                                <td>{{ optional(optional($product->materialLayout)->category)->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Material Layout</th>
                                <td>{{ optional($product->materialLayout)->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Material Edge</th>
                                <td>{{ optional($product->materialEdge)->name ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <h5 class="fw-bold mb-3">Additional Components</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 20%">Back Wall</th>
                                    <td>{{ optional($product->backWall)->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Sink Category</th>
                                    <td>{{ optional(optional($product->sink)->category)->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Sink</th>
                                    <td>{{ optional($product->sink)->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Cut Outs Category</th>
                                    <td>{{ optional(optional($product->cutOut)->category)->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Cut Out</th>
                                    <td>{{ optional($product->cutOut)->name ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

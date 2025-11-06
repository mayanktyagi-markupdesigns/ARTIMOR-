
@extends('admin.layouts.app')

@section('title', 'Quotation #' . $quotation->id)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Quotation Details - <span style="color: blue;">#{{ $quotation->id }}</span></h3>
        <a href="{{ route('admin.quotations.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Customer Details</h4>
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Full Name</th>
                    <td>{{ $quotation->first_name }} {{ $quotation->last_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $quotation->email }}</td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>{{ $quotation->phone_number }}</td>
                </tr>
                <tr>
                    <th>Delivery Option</th>
                    <td>{{ $quotation->delivery_option ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Measurement Time</th>
                    <td>{{ $quotation->measurement_time ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Promo Code</th>
                    <td>{{ $quotation->promo_code ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $quotation->created_at?->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $quotation->updated_at?->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            <h4 class="mb-3 mt-4">Quotation Details</h4>
            <table class="table table-bordered">
                <!-- Material -->
                @if($material)
                <tr>
                    <th style="width: 200px;">Material</th>
                    <td>
                        <strong>Name:</strong> {{ $material->name ?? 'N/A' }}<br>
                        <strong>Brand:</strong> {{ $material->brand ?? 'N/A' }}<br>
                        <strong>Color:</strong> {{ $material->color ?? 'N/A' }}<br>
                        <strong>Price:</strong> ₹{{ number_format($material->price * (($dimensions['blad1']['width'] * $dimensions['blad1']['height']) / 10000), 2) ?? 'N/A' }}<br>
                        @if($material->image && file_exists(public_path('uploads/materials/' . $material->image)))
                        <img src="{{ asset('uploads/materials/' . $material->image) }}" alt="{{ $material->name }}"
                            class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                @endif

                <!-- Material Type -->
                @if($materialType)
                <tr>
                    <th>Material Type</th>
                    <td>
                        <strong>Name:</strong> {{ $materialType->name ?? 'N/A' }}<br>
                        <strong>Price:</strong> ₹{{ number_format($materialType->price * (($dimensions['blad1']['width'] * $dimensions['blad1']['height']) / 10000), 2) ?? 'N/A' }}<br>
                        @if($materialType->image && file_exists(public_path('uploads/material-types/' . $materialType->image)))
                        <img src="{{ asset('uploads/material-types/' . $materialType->image) }}" alt="{{ $materialType->name }}"
                            class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                @endif

                <!-- Layout -->
                @if($layout)
                <tr>
                    <th>Layout</th>
                    <td>
                        <strong>Name:</strong> {{ $layout->name ?? 'N/A' }}<br>
                        <strong>Price:</strong> ₹{{ number_format($layout->price * (($dimensions['blad1']['width'] * $dimensions['blad1']['height']) / 10000), 2) ?? 'N/A' }}<br>
                        @if($layout->image && file_exists(public_path('uploads/material-layout/' . $layout->image)))
                        <img src="{{ asset('uploads/material-layout/' . $layout->image) }}" alt="{{ $layout->name }}"
                            class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                @endif

                <!-- Dimensions -->
                @if($dimensions['blad1']['width'] || $dimensions['blad1']['height'])
                <tr>
                    <th>Dimensions</th>
                    <td>
                        <strong>Width:</strong> {{ $dimensions['blad1']['width'] ?: 'N/A' }} cm<br>
                        <strong>Height:</strong> {{ $dimensions['blad1']['height'] ?: 'N/A' }} cm<br>
                        <strong>Area:</strong> {{ number_format(($dimensions['blad1']['width'] * $dimensions['blad1']['height']) / 10000, 2) }} m²
                    </td>
                </tr>
                @endif

                <!-- Edge Finishing -->
                @if($edge)
                <tr>
                    <th>Edge Finishing</th>
                    <td>
                        <strong>Kind:</strong> {{ $edge->name ?? 'N/A' }}<br>
                        <strong>Thickness:</strong> {{ $quotation->edge_thickness ?? 'N/A' }} cm<br>
                        <strong>Edges to be Finished:</strong> {{ implode(', ', $edgeSelectedEdges) ?: 'None' }}<br>
                        <strong>Price:</strong> ₹{{ number_format($edge->price * (($dimensions['blad1']['width'] * $dimensions['blad1']['height']) / 10000), 2) ?? 'N/A' }}<br>
                        @if($edge->image && file_exists(public_path('uploads/material-edge/' . $edge->image)))
                        <img src="{{ asset('uploads/material-edge/' . $edge->image) }}" alt="{{ $edge->name }}"
                            class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                @endif

                <!-- Back Wall -->
                @if($wall)
                <tr>
                    <th>Back Wall</th>
                    <td>
                        <strong>Kind:</strong> {{ $wall->name ?? 'N/A' }}<br>
                        <strong>Thickness:</strong> {{ $quotation->back_wall_thickness ?? 'N/A' }} cm<br>
                        <strong>Sides to be Finished:</strong> {{ implode(', ', $backWallSelectedEdges) ?: 'None' }}<br>
                        <strong>Price:</strong> ₹{{ number_format($wall->price * (($dimensions['blad1']['width'] * $dimensions['blad1']['height']) / 10000), 2) ?? 'N/A' }}<br>
                        @if($wall->image && file_exists(public_path('uploads/back-wall/' . $wall->image)))
                        <img src="{{ asset('uploads/back-wall/' . $wall->image) }}" alt="{{ $wall->name }}"
                            class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                @endif

                <!-- Sink -->
                @if($sink)
                <tr>
                    <th>Sink</th>
                    <td>
                        <strong>Model:</strong> {{ $sink->name ?? 'N/A' }}<br>
                        <strong>Type:</strong> {{ ucfirst($quotation->sink_cutout) ?? 'N/A' }}<br>
                        <strong>Number:</strong> {{ $quotation->sink_number ?? 'N/A' }}<br>
                        <strong>Price:</strong> ₹{{ number_format($sink->price * ($quotation->sink_number ?? 1), 2) ?? 'N/A' }}<br>
                        @if($sink->images->first() && file_exists(public_path('uploads/sinks/' . $sink->images->first()->image)))
                        <img src="{{ asset('uploads/sinks/' . $sink->images->first()->image) }}" alt="{{ $sink->name }}"
                            class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                @endif

                <!-- Cutouts -->
                @if($cutout)
                <tr>
                    <th>Cutouts</th>
                    <td>
                        <strong>Kind:</strong> {{ $cutout->name ?? 'N/A' }}<br>
                        <strong>Type:</strong> {{ ucfirst($quotation->cutout_recess_type) ?? 'N/A' }}<br>
                        <strong>Price:</strong> ₹{{ number_format($cutout->price, 2) ?? 'N/A' }}<br>
                        @if($cutout->images->first() && file_exists(public_path('uploads/cut-outs/' . $cutout->images->first()->image)))
                        <img src="{{ asset('uploads/cut-outs/' . $cutout->images->first()->image) }}" alt="{{ $cutout->name }}"
                            class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                @endif

                <!-- Total Price -->
                <tr>
                    <th>Total Price</th>
                    <td><strong>€{{ number_format($quotation->total_price, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card.shadow-sm {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.table th, .table td {
    vertical-align: middle;
    padding: 0.75rem;
}
.table th {
    background-color: #f8f9fa;
    width: 200px;
}
.btn-custom-add {
    background-color: #007bff;
    border-color: #007bff;
}
.btn-custom-add:hover {
    background-color: #0056b3;
    border-color: #004085;
}
.img-thumbnail {
    max-width: 200px;
}
.listing_name h3 {
    font-size: 1.75rem;
}
</style>
@endsection

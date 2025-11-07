@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Material layout Details</h3>
        <a href="{{ route('admin.layout.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Name</th>
                    <td>{{ $layout->name }}</td>
                </tr>
                <tr>
                    <th>Layout Category</th>
                     <td>{{ $layout->category->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Per Sq/Price</th>
                     <td>{{ $layout->price }}</td>
                </tr>
                <tr>
                    <th>Per Sq/User Price</th>
                    <td>{{ $layout->user_price }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($layout->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($layout->image)
                            <img src="{{ asset('uploads/material-layout/'.$layout->image) }}" 
                                 alt="Material Image" width="150" class="img-thumbnail">
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $layout->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

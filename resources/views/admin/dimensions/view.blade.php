@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Banner Details - <span style="color: blue;">{{ $banner->id }}</span></h3>
        <a href="{{ route('admin.banner.list') }}" c class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Title</th>
                    <td>{{ $banner->title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $banner->description ? strip_tags($banner->description) : '---' }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($banner->status == 1)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($banner->image && file_exists(public_path('uploads/banners/' . $banner->image)))
                        <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="Banner Image"
                            class="img-thumbnail" style="max-width: 300px;">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $banner->created_at?->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $banner->updated_at?->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
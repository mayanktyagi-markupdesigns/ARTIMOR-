@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">User Details - <span style="color: blue;">{{ $user->id }}</span></h3>
        <a href="{{ route('admin.user.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3 text-center">
                    @if ($user->photo && file_exists(public_path('uploads/users/' . $user->photo)))
                    <img src="{{ asset('uploads/users/' . $user->photo) }}" alt="Profile Photo" width="120" height="120"
                        class="rounded-circle img-thumbnail">
                    @else
                    <img src="{{ asset('uploads/users/no_icon.jpg') }}" alt="Default Photo" width="120" height="120"
                        class="rounded-circle img-thumbnail">
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 mb-3"><strong>Name:</strong> {{ $user->name }}</div>
                        <div class="col-md-6 mb-3"><strong>Business Name:</strong> {{ $user->business_name }}</div>
                        <div class="col-md-6 mb-3"><strong>Email:</strong> {{ $user->email }}</div>
                        <div class="col-md-6 mb-3"><strong>Mobile:</strong> {{ $user->mobile }}</div>                        
                        <div class="col-md-6 mb-3"><strong>Vat Number:</strong> {{ $user->vat_number }}</div>                        
                        <div class="col-md-6 mb-3"><strong>Status:</strong>
                            @if($user->status)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3"><strong>Created On:</strong> {{ $user->created_at->format('d-M-Y') }}
                        </div>
                        <div class="col-md-12 mb-3"><strong>Address:</strong><br> {{ $user->address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('admin.layouts.app')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.password.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 mb-4">
                        <h5 class="fw-bold border-bottom pb-2">Password Update Information</h5>
                    </div>

                    <div class="col-md-4">
                        <label for="current_password" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-1"></i>Current Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="current_password" id="current_password"
                            class="form-control" placeholder="Enter current password"
                            value="{{ old('current_password') }}">
                        @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="password" class="form-label fw-semibold">
                            <i class="bi bi-key-fill me-1"></i>New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password" id="password"
                            class="form-control" placeholder="Enter new password">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i>Confirm Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="Confirm new password">
                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Change Password</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@if(session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        });
    </script>
@endif
@endsection



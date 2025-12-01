@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add New User</h3>
        <a href="{{ route('admin.user.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="name">Name</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                            placeholder="Enter name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="business_name">Business Name</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="business_name" value="{{ old('business_name') }}"
                            placeholder="Enter Business Name">
                        @error('business_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="email">Email</label><span style="color:red;">*</span>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="Enter email">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="mobile">Mobile</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                            placeholder="Enter mobile">
                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>                   

                    <div class="col-md-4 mb-3">
                        <label for="password">Password</label><span style="color:red;">*</span>
                        <input type="password" class="form-control" name="password" placeholder="Enter password">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password_confirmation">Confirm Password</label><span style="color:red;">*</span>
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Confirm password">
                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="vat_number">Vat Number</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="vat_number" value="{{ old('vat_number') }}"
                            placeholder="Enter Vat Number">
                        @error('vat_number') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="photo">Profile Photo</label>
                        <input type="file" class="form-control" name="photo" id="photo"
                            accept=".jpg, .jpeg, .JPG, .JPEG">
                        @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select class="form-select" name="status">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control" rows="2" id="summernote"
                            placeholder="Enter address">{{ old('address') }}</textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.user.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
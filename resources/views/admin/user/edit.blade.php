@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit User - <span style="color: blue;">{{ $user->id }}</span></h3>
        <a href="{{ route('admin.user.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label for="name">Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}"
                                placeholder="Enter name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="business_name">Business Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="business_name"
                                value="{{ old('business_name', $user->business_name) }}" placeholder="Enter Business Name">
                            @error('business_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="email">Email</label><span style="color:red;">*</span>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', $user->email) }}" placeholder="Enter email">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="mobile">Mobile</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="mobile"
                                value="{{ old('mobile', $user->mobile) }}" placeholder="Enter mobile">
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
                            <input type="text" class="form-control" name="vat_number" value="{{ old('vat_number', $user->vat_number) }}"
                                placeholder="Enter Vat Number">
                            @error('vat_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="photo">Profile Photo</label>
                            <input type="file" class="form-control" name="photo" id="photo"
                                accept=".jpg, .jpeg, .JPG, .JPEG">
                            @if($user->photo)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/users/' . $user->photo) }}" alt="Profile Photo" width="60"
                                    height="60" style="border-radius: 5px; object-fit: cover;">
                            </div>
                            @endif
                            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" rows="2" id="summernote"
                                placeholder="Enter address">{{ old('address', $user->address) }}</textarea>
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
</div>
@endsection
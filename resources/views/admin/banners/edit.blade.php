@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Banner - <span style="color: blue;">{{ $banner->id }}</span></h3>
        <a href="{{ route('admin.banner.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
           @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="title">Title</label><span style="color:red;">*</span>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title"
                                value="{{ old('title', $banner->title) }}">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image"
                                accept=".jpg,.jpeg,.png,.svg,.JPG,.PNG">
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror

                            @if($banner->image)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="banner Image"
                                    width="100" class="img-thumbnail">
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{ old('status', $banner->status) == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ old('status', $banner->status) == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="summernote" rows="2"
                                placeholder="Enter description">{{ old('description', $banner->description) }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.banner.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
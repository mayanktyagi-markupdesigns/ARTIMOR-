@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Material Layout Group</h3>
        <a href="{{ route('admin.material.layout.group.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.material.layout.group.update', $group->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-4 mb-3">
                            <label for="name">Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ old('name', $group->name) }}" placeholder="Enter name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Material Group -->
                        <div class="col-md-4 mb-3">
                            <label for="layout_category_id">Material Group</label><span style="color:red;">*</span>
                            <select class="form-select" name="layout_category_id" id="layout_category_id">
                                @foreach(($category ?? []) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('layout_category_id', $group->layout_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('layout_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{ old('status', $group->status) == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0" {{ old('status', $group->status) == '0' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.material.layout.group.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
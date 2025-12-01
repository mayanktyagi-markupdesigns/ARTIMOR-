@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Material Type</h3>
        <a href="{{ route('admin.material.type.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.material.type.update', $type->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-4 mb-3">
                            <label for="name">Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ old('name', $type->name) }}" placeholder="Enter name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Material Group -->
                        <div class="col-md-4 mb-3">
                            <label for="material_group_id">Material Group</label><span style="color:red;">*</span>
                            <select class="form-select" name="material_group_id" id="material_group_id">
                                @foreach(($group ?? []) as $group)
                                <option value="{{ $group->id }}"
                                    {{ old('material_group_id', $type->material_group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('material_group_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{ old('status', $type->status) == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0" {{ old('status', $type->status) == '0' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.material.type.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
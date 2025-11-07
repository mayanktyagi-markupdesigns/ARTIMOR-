@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add Master Product</h3>
        <a href="{{ route('admin.color.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')

            <form action="{{ route('admin.masterproduct.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    {{-- Material Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_category">Material Category</label>
                        <select id="material_category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($materialCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Material --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_id">Material <span class="text-danger">*</span></label>
                        <select name="material_id" id="material_id" class="form-control" required>
                            <option value="">Select Material</option>
                        </select>
                    </div>

                    {{-- Type Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="type_category">Type Category</label>
                        <select id="type_category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($typeCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Material Type --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type <span class="text-danger">*</span></label>
                        <select name="material_type_id" id="material_type_id" class="form-control" required>
                            <option value="">Select Type</option>
                        </select>
                    </div>

                    {{-- Layout Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="layout_category">Layout Category</label>
                        <select id="layout_category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($layoutCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Material Layout --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_layout_id">Material Layout <span class="text-danger">*</span></label>
                        <select name="material_layout_id" id="material_layout_id" class="form-control" required>
                            <option value="">Select Layout</option>
                        </select>
                    </div>

                    {{-- Material Edge --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_edge_id">Material Edge <span class="text-danger">*</span></label>
                        <select name="material_edge_id" id="material_edge_id" class="form-control" required>
                            <option value="">Select Edge</option>
                            @foreach($edges as $edge)
                            <option value="{{ $edge->id }}">{{ $edge->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.color.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const materialCategorySelect = document.getElementById('material_category');
    const materialSelect = document.getElementById('material_id');
    const materialEndpoint = "{{ url('admin/ajax/materials') }}";
    const materialTypeCategorySelect = document.getElementById('type_category');
    const materialTypeSelect = document.getElementById('material_type_id');
    const materialTypeEndpoint = "{{ url('admin/ajax/material-types') }}";
    const layoutCategorySelect = document.getElementById('layout_category');
    const layoutSelect = document.getElementById('material_layout_id');
    const layoutEndpoint = "{{ url('admin/ajax/material-layouts') }}";

    const dependencies = [
        {
            trigger: materialCategorySelect,
            target: materialSelect,
            endpoint: materialEndpoint,
            placeholder: 'Select Material',
        },
        {
            trigger: materialTypeCategorySelect,
            target: materialTypeSelect,
            endpoint: materialTypeEndpoint,
            placeholder: 'Select Type',
        },
        {
            trigger: layoutCategorySelect,
            target: layoutSelect,
            endpoint: layoutEndpoint,
            placeholder: 'Select Layout',
        },
    ];

    dependencies.forEach(({ trigger, target, endpoint, placeholder }) => {
        if (!trigger || !target) {
            return;
        }

        trigger.addEventListener('change', function () {
            const categoryId = this.value;

            target.innerHTML = `<option value="">${placeholder}</option>`;

            if (!categoryId) {
                return;
            }

            target.innerHTML = '<option>Loading...</option>';

            fetch(`${endpoint}/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    let options = `<option value="">${placeholder}</option>`;

                    data.forEach(item => {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });

                    target.innerHTML = options;
                })
                .catch(() => {
                    target.innerHTML = `<option value="">${placeholder}</option>`;
                });
        });
    });
});
</script>
@endsection
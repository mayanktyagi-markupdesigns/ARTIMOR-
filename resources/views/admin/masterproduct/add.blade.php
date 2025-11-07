@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add Master Product</h3>
        <a href="{{ route('admin.masterproduct.list') }}" class="btn btn-primary btn-custom-add">
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
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                    </div>

                    {{-- Material Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_category">Material Category</label>
                        <select id="material_category" name="material_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($materialCategories as $cat)
                                <option value="{{ $cat->id }}" {{ old('material_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('material_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    

                    {{-- Material --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_id">Material <span class="text-danger">*</span></label>
                        <select name="material_id" id="material_id" class="form-control" data-selected="{{ old('material_id') }}">
                            <option value="">Select Material</option>
                        </select>
                        @error('material_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                    </div>

                    {{-- Type Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="type_category">Type Category</label>
                        <select id="type_category" name="material_type_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($typeCategories as $cat)
                                <option value="{{ $cat->id }}" {{ old('material_type_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Material Type --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type <span class="text-danger">*</span></label>
                        <select name="material_type_id" id="material_type_id" class="form-control" data-selected="{{ old('material_type_id') }}">
                            <option value="">Select Material Type</option>
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                    </div>

                    {{-- Layout Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="layout_category">Layout Category</label>
                        <select id="layout_category" name="material_layout_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($layoutCategories as $cat)
                                <option value="{{ $cat->id }}" {{ old('material_layout_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Material Layout --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_layout_id">Material Layout <span class="text-danger">*</span></label>
                        <select name="material_layout_id" id="material_layout_id" class="form-control" data-selected="{{ old('material_layout_id') }}">
                            <option value="">Select Layout</option>
                        </select>
                        @error('material_layout_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                    </div>

                    {{-- Material Edge --}}
                    <div class="col-md-4 mb-3">
                        <label for="material_edge_id">Material Edge <span class="text-danger">*</span></label>
                        <select name="material_edge_id" id="material_edge_id" class="form-control">
                            <option value="">Select Edge</option>
                            @foreach($edges as $edge)
                                <option value="{{ $edge->id }}" {{ old('material_edge_id') == $edge->id ? 'selected' : '' }}>{{ $edge->name }}</option>
                            @endforeach
                        </select>
                        @error('material_edge_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Back Wall --}}
                    <div class="col-md-4 mb-3">
                        <label for="back_wall_id">Back Wall <span class="text-danger">*</span></label>
                        <select name="back_wall_id" id="back_wall_id" class="form-control">
                            <option value="">Select Back Wall</option>
                            @foreach($backWalls as $backWall)
                                <option value="{{ $backWall->id }}" {{ old('back_wall_id') == $backWall->id ? 'selected' : '' }}>{{ $backWall->name }}</option>
                            @endforeach
                        </select>
                        @error('back_wall_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                    </div>

                    {{-- Sink Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="sink_category_id">Sink Category</label>
                        <select id="sink_category_id" name="sink_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($sinkCategories as $sinkCategory)
                                <option value="{{ $sinkCategory->id }}" {{ old('sink_category_id') == $sinkCategory->id ? 'selected' : '' }}>{{ $sinkCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sink --}}
                    <div class="col-md-4 mb-3">
                        <label for="sink_id">Sink <span class="text-danger">*</span></label>
                        <select name="sink_id" id="sink_id" class="form-control" data-selected="{{ old('sink_id') }}">
                            <option value="">Select Sink</option>
                        </select>
                        @error('sink_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                     <div class="col-md-4 mb-3">
                    </div>

                    {{-- Cut Outs Category --}}
                    <div class="col-md-4 mb-3">
                        <label for="cut_outs_category_id">Cut Outs Category</label>
                        <select id="cut_outs_category_id" name="cut_outs_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($cutOutsCategories as $cutOutsCategory)
                                <option value="{{ $cutOutsCategory->id }}" {{ old('cut_outs_category_id') == $cutOutsCategory->id ? 'selected' : '' }}>{{ $cutOutsCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Cut Out --}}
                    <div class="col-md-4 mb-3">
                        <label for="cut_outs_id">Cut Out <span class="text-danger">*</span></label>
                        <select name="cut_outs_id" id="cut_outs_id" class="form-control" data-selected="{{ old('cut_outs_id') }}">
                            <option value="">Select Cut Out</option>
                        </select>
                        @error('cut_outs_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                    </div>

                    {{-- Color --}}
                    <div class="col-md-4 mb-3">
                        <label for="color_id">Color <span class="text-danger">*</span></label>
                        <select name="color_id" id="color_id" class="form-control">
                            <option value="">Select Color</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                            @endforeach
                        </select>
                        @error('color_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>                    
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.masterproduct.list') }}" class="btn btn-danger ms-2">Cancel</a>
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
    const sinkCategorySelect = document.getElementById('sink_category_id');
    const sinkSelect = document.getElementById('sink_id');
    const sinkEndpoint = "{{ url('admin/ajax/sinks') }}";
    const cutOutsCategorySelect = document.getElementById('cut_outs_category_id');
    const cutOutsSelect = document.getElementById('cut_outs_id');
    const cutOutsEndpoint = "{{ url('admin/ajax/cut-outs') }}";

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
            placeholder: 'Select Material Type',
        },
        {
            trigger: layoutCategorySelect,
            target: layoutSelect,
            endpoint: layoutEndpoint,
            placeholder: 'Select Layout',
        },
        {
            trigger: sinkCategorySelect,
            target: sinkSelect,
            endpoint: sinkEndpoint,
            placeholder: 'Select Sink',
        },
        {
            trigger: cutOutsCategorySelect,
            target: cutOutsSelect,
            endpoint: cutOutsEndpoint,
            placeholder: 'Select Cut Out',
        },
    ];

    const buildOptions = (data, placeholder, selectedValue) => {
        let options = `<option value="">${placeholder}</option>`;

        if (Array.isArray(data)) {
            data.forEach(item => {
                const value = item?.id ?? '';
                if (!value) {
                    return;
                }
                const label = item?.name ?? `#${value}`;
                const isSelected = selectedValue && String(selectedValue) === String(value) ? ' selected' : '';
                options += `<option value="${value}"${isSelected}>${label}</option>`;
            });
        }

        return options;
    };

    dependencies.forEach(({ trigger, target, endpoint, placeholder }) => {
        if (!trigger || !target) {
            return;
        }

        trigger.addEventListener('change', function () {
            const categoryId = this.value;
            target.innerHTML = `<option value="">${placeholder}</option>`;

            if (!categoryId) {
                target.dataset.selected = '';
                target.removeAttribute('data-selected');
                return;
            }

            target.innerHTML = '<option>Loading...</option>';

            fetch(`${endpoint}/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    const selectedValue = target.dataset.selected || target.getAttribute('data-selected') || '';
                    target.innerHTML = buildOptions(data, placeholder, selectedValue);
                    target.dataset.selected = '';
                    target.removeAttribute('data-selected');
                })
                .catch(() => {
                    target.innerHTML = `<option value="">${placeholder}</option>`;
                    target.dataset.selected = '';
                    target.removeAttribute('data-selected');
                });
        });
    });

    dependencies.forEach(({ trigger }) => {
        if (trigger && trigger.value) {
            trigger.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection
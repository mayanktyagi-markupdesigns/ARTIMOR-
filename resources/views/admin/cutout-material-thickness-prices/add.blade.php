@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <h3>Add Cutout Material Thickness Prices</h3>
    <div class="card mt-3">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.cutout.material.thickness.price.controller.store') }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Material Type -->
                    <div class="col-md-4 mb-3">
                        <label>Material Type <span class="text-danger">*</span></label>
                        <select name="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $t)
                                <option value="{{ $t->id }}" {{ old('material_type_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Thickness Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label>Thickness <span class="text-danger">*</span></label>
                        <select name="thickness_value" id="thicknessDropdown" class="form-select">
                            <option value="">Select Thickness</option>
                        </select>
                        @error('thickness_value') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Cutouts -->
                    <div class="col-md-4 mb-3">
                        <label>Cutouts <span class="text-danger">*</span></label>
                        <select name="cut_out_id" class="form-select">
                            <option value="">Select Cutout</option>
                            @foreach($cutouts as $c)
                                <option value="{{ $c->id }}" {{ old('cut_out_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cut_out_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Price Guest -->
                    <div class="col-md-4 mb-3">
                        <label>Price Guest <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price_guest" class="form-control" value="{{ old('price_guest') }}">
                        @error('price_guest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Price Business -->
                    <div class="col-md-4 mb-3">
                        <label>Price Business <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price_business" class="form-control" value="{{ old('price_business') }}">
                        @error('price_business') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('select[name="material_type_id"]').on('change', function () {
        let typeId = $(this).val();
        let dropdown = $('#thicknessDropdown');
        dropdown.html('<option value="">Loading...</option>');

        if (typeId) {
            $.ajax({
                url: "{{ route('admin.cutout.material.thickness.price.controller.getThicknessByType') }}",
                type: "GET",
                data: { material_type_id: typeId },
                success: function(response) {
                    dropdown.empty();
                    dropdown.append('<option value="">Select Thickness</option>');
                    if(response.data.length > 0){
                        $.each(response.data, function(key, val){
                            dropdown.append('<option value="'+val.thickness_value+'">'+val.thickness_value+'</option>');
                        });
                    } else {
                        dropdown.append('<option value="">No Thickness Found</option>');
                    }
                }
            });
        } else {
            dropdown.html('<option value="">Select Thickness</option>');
        }
    });
});
</script>

@endsection

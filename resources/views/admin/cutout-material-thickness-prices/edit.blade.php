@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Cutout Material Thickness Prices</h3>
        <a href="{{ route('admin.cutout.material.thickness.price.controller.list') }}"
            class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form
                action="{{ route('admin.cutout.material.thickness.price.controller.update', $cutout_material_thickness->id) }}"
                method="POST">
                @csrf
                <div class="row">
                    <!-- Material Type -->
                    <div class="col-md-4 mb-3">
                        <label for="material_type_id">Material Type <span class="text-danger">*</span></label>
                        <select name="material_type_id" id="material_type_id" class="form-select">
                            <option value="">Select Material Type</option>
                            @foreach($type as $t)
                                <option value="{{ $t->id }}"
                                    {{ old('material_type_id', $cutout_material_thickness->material_type_id) == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Cutouts -->
                    <div class="col-md-4 mb-3">
                        <label for="cut_out_id">Cut Outs <span class="text-danger">*</span></label>
                        <select name="cut_out_id" id="cut_out_id" class="form-select">
                            <option value="">Select Cut Outs</option>
                            @foreach($cutouts as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('cut_out_id', $cutout_material_thickness->cut_out_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cut_out_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Thickness Value -->
                    <div class="col-md-4 mb-3">
                        <label for="thickness_value">Thickness Value <span class="text-danger">*</span></label>
                        <select name="thickness_value" id="thicknessDropdown" class="form-select">
                            <option value="">Select Thickness</option>
                            @if($cutout_material_thickness->material_type_id)
                                @foreach(App\Models\Thickness::where('material_type_id', $cutout_material_thickness->material_type_id)->get() as $th)
                                    <option value="{{ $th->thickness_value }}"
                                        {{ old('thickness_value', $cutout_material_thickness->thickness_value) == $th->thickness_value ? 'selected' : '' }}>
                                        {{ $th->thickness_value }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('thickness_value') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Price Guest -->
                    <div class="col-md-4 mb-3">
                        <label for="price_guest">Price Guest <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="price_guest"
                            value="{{ old('price_guest', $cutout_material_thickness->price_guest) }}"
                            placeholder="Enter guest price">
                        @error('price_guest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Price Business -->
                    <div class="col-md-4 mb-3">
                        <label for="price_business">Price Business <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="price_business"
                            value="{{ old('price_business', $cutout_material_thickness->price_business) }}"
                            placeholder="Enter business price">
                        @error('price_business') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $cutout_material_thickness->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $cutout_material_thickness->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.cutout.material.thickness.price.controller.list') }}"
                        class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#material_type_id').on('change', function () {
        let typeId = $(this).val();
        let dropdown = $('#thicknessDropdown');
        dropdown.html('<option value="">Loading...</option>');

        if(typeId){
            $.ajax({
                url: "{{ route('admin.cutout.material.thickness.price.controller.getThicknessByType') }}",
                type: "GET",
                data: { material_type_id: typeId },
                success: function(response){
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

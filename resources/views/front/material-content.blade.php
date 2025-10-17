<div class="row">
    @foreach($materials as $material)
    <div class="col-md-4 mb-4">
        <div class="card border-0 rounded-0 position-relative product-col material-card {{ session('selected_material_id') == $material->id ? 'selected' : '' }}"
            data-id="{{ $material->id }}">
            <img src="{{ asset('uploads/materials/' . $material->image) }}" class="card-img-top" alt="{{ $material->name }}" />
            <div class="card-body text-center p-0">
                <div class="titleoverlay">
                    <div>
                        <span>{{ $loop->iteration }}.</span> {{ $material->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
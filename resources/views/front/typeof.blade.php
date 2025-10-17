

<div class="materials pt-5">
    <div class="row g-4">
        <div class="col-lg-8 m-auto">
            <div class="types-stone-texture">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <figure class="prod-box">
                            @if($materialTypes->first())
                                <img id="material-image" class="img-fluid"
                                    src="{{ asset('uploads/materialtype/' . $materialTypes->first()->image) }}"
                                    alt="{{ $materialTypes->first()->type }}">
                            @else
                                <img id="material-image" class="img-fluid"
                                    src="{{ asset('assets/front/img/product-circle.jpg') }}"
                                    alt="Default Image">
                            @endif
                        </figure>
                    </div>
                    <div class="col-md-6">
                        <ul class="design-step">
                            @forelse($materialTypes as $material)
                                <li class="d-flex align-items-center material-type-item @if($loop->first) active @endif" 
                                    data-image="{{ asset('uploads/materialtype/' . $material->image) }}">
                                    <span class="cicle-t me-2"></span>
                                    <span class="tepr">{{ $material->type }}</span>
                                </li>
                            @empty
                                <li>No material types available.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>

<style>
.design-step li.active {
    font-weight: bold;
    color: #28a745;
    background-color: #f0fff0;
    border-left: 4px solid #28a745;
}
.design-step li {
    cursor: pointer;
    padding: 10px;
    margin-bottom: 5px;
    border-radius: 4px;
    transition: background 0.2s ease;
}
</style>




@php
    $materialTypes = $materialTypes ?? collect();
    $productsByMaterialType = $productsByMaterialType ?? collect();
    $selectedMaterialTypeId = $selectedMaterialTypeId ?? null;
    $activeType = $materialTypes->firstWhere('id', $selectedMaterialTypeId) ?? $materialTypes->first();
    $activeImage = $activeType && $activeType->image
        ? asset('uploads/materialtype/' . $activeType->image)
        : asset('assets/front/img/product-circle.jpg');
    $activeTitle = $activeType
        ? (optional($activeType->category)->name ?? $activeType->name ?? $activeType->type ?? 'Material Type')
        : 'Material Type';
@endphp

<div class="materials pt-5">
    <div class="row g-4">
        <div class="col-lg-8 m-auto">
            <div class="types-stone-texture">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <figure class="prod-box">
                            <img id="material-image" class="img-fluid"
                                src="{{ $activeImage }}"
                                alt="{{ $activeTitle }}">
                        </figure>
                    </div>
                    <div class="col-md-6">
                        @if($materialTypes->isNotEmpty())
                            <ul class="design-step">
                                @foreach($materialTypes as $type)
                                    @php
                                        $displayName = optional($type->category)->name ?? $type->name ?? $type->type ?? 'Material Type';
                                        $imagePath = $type->image
                                            ? asset('uploads/materialtype/' . $type->image)
                                            : asset('assets/front/img/product-circle.jpg');
                                        $isActive = (string)($selectedMaterialTypeId ?? '') === (string)$type->id
                                            || (!$selectedMaterialTypeId && $loop->first);
                                    @endphp
                                    <li class="d-flex flex-column material-type-item {{ $isActive ? 'active' : '' }}"
                                        data-id="{{ $type->id }}"
                                        data-image="{{ $imagePath }}">
                                        <div class="d-flex align-items-center w-100">
                                            <span class="cicle-t me-2"></span>
                                            <span class="tepr flex-grow-1">{{ $displayName }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="py-5 text-center">
                                <p class="mb-0">Select a material to view available types.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.design-step li {
    cursor: pointer;
    padding: 12px 16px;
    margin-bottom: 8px;
    border-radius: 6px;
    transition: background 0.2s ease, border-color 0.2s ease;
    border: 1px solid transparent;
}
.design-step li.active {
    font-weight: 600;
    color: #28a745;
    background-color: #f0fff0;
    border-color: #28a745;
}
.design-step li .tepr {
    font-size: 16px;
}
.design-step li p {
    font-size: 13px;
}
</style>

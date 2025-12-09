<div class="materials-tab-wrapper">
    <div class="d-flex align-items-center justify-content-center materials-tab-div">
        @if($materialCategories->isNotEmpty())
        <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
            @foreach($materialCategories as $index => $categoryName)
            @php
            $tabId = \Illuminate\Support\Str::slug($categoryName ?: 'Other');
            @endphp
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $tabId }}-tab" data-bs-toggle="tab"
                    data-bs-target="#{{ $tabId }}" type="button" role="tab">
                    {{ $categoryName ?: 'Other' }}
                </button>
            </li>
            @endforeach
        </ul>
        @else
        <div class="py-5 text-center w-100">
            <p class="mb-0">No materials available at the moment.</p>
        </div>
        @endif
    </div>

    @if($materialCategories->isNotEmpty())
    <div class="tab-content" id="materialsTabContent">
        @foreach($materialsByCategory as $categoryName => $categoryMaterials)
        @php
        $tabId = \Illuminate\Support\Str::slug($categoryName ?: 'Other');
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel"
            aria-labelledby="{{ $tabId }}-tab">
            <div class="row">
                @forelse($categoryMaterials as $material)
                @php
                $productGroup = $productsByMaterial->get($material->id, collect());
                $typeNames = $productGroup->pluck('materialType.name')->filter()->unique()->values();
                $layoutNames = $productGroup->pluck('materialLayout.name')->filter()->unique()->values();
                $productIds = $productGroup->pluck('id')->unique()->values()->implode(',');
                $materialImage = $material->image
                ? asset('uploads/materials/' . $material->image)
                : asset('assets/front/img/product-circle.jpg');
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card border-0 rounded-0 position-relative product-col material-card {{ (string)($selectedMaterialId ?? '') === (string)$material->id ? 'selected' : '' }}"
                        data-id="{{ $material->id }}" data-product-ids="{{ $productIds }}">
                        <img src="{{ $materialImage }}" class="card-img-top" alt="{{ $material->name }}">
                        <div class="card-body text-center p-0">
                            <div class="titleoverlay">
                                <div>
                                    <span>{{ $loop->iteration }}.</span> {{ $material->name }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="mb-0">No materials available in this category.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
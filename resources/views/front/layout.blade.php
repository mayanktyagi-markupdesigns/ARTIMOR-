@php
    $layoutsByType = $layoutsByType ?? collect();
    $layoutTypes = $layoutTypes ?? collect();
    $productsByLayout = $productsByLayout ?? collect();
    $selectedLayoutId = (string)($selectedLayoutId ?? session('selected_layout_id'));
@endphp

<div class="materials">
    @if($layoutTypes->isNotEmpty())
        <!-- Nav Tabs -->
        <div class="d-flex align-items-center justify-content-center">
            <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
                @foreach($layoutTypes as $index => $type)
                    @php
                        $tabId = \Illuminate\Support\Str::slug($type ?: 'Other');
                    @endphp
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                            id="{{ $tabId }}-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $tabId }}"
                            type="button"
                            role="tab">
                            {{ strtoupper($type ?: 'Other') }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="materialsTabContent">
            @foreach($layoutTypes as $index => $type)
                @php
                    $tabId = \Illuminate\Support\Str::slug($type ?: 'Other');
                    $layouts = $layoutsByType->get($type, collect());
                @endphp
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel"
                    aria-labelledby="{{ $tabId }}-tab">
                    <div class="row">
                        @forelse($layouts as $loopIndex => $layout)
                            @php
                                $layoutId = (string)$layout->id;
                                $productGroup = $productsByLayout->get($layout->id, collect());
                                $materialNames = $productGroup->pluck('material.name')->filter()->unique()->values();
                                $typeNames = $productGroup->pluck('materialType.name')->filter()->unique()->values();
                                $productIds = $productGroup->pluck('id')->unique()->implode(',');
                                $imagePath = $layout->image
                                    ? asset('uploads/material-layout/' . $layout->image)
                                    : asset('assets/front/img/product-circle.jpg');
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div class="p-0 card rounded-0 position-relative product-col layout-card {{ $selectedLayoutId === $layoutId ? 'selected' : '' }}"
                                    data-id="{{ $layoutId }}"
                                    data-product-ids="{{ $productIds }}">
                                    <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $layout->name }}">
                                    <div class="p-0 card-body text-center">
                                        <div class="titleoverlay">
                                            <div>
                                                <span>{{ $loopIndex + 1 }}.</span> {{ $layout->name }}
                                            </div>
                                        </div>
                                        <div class="px-3 py-3 text-start layout-meta">
                                            @if($materialNames->isNotEmpty())
                                                <p class="mb-1">
                                                    <strong>Materials:</strong> {{ $materialNames->join(', ') }}
                                                </p>
                                            @endif
                                            @if($typeNames->isNotEmpty())
                                                <p class="mb-0">
                                                    <strong>Types:</strong> {{ $typeNames->join(', ') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="mb-0">No layouts available under this category.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-5 text-center">
            <p class="mb-0">Select a material and type to view available layouts.</p>
        </div>
    @endif
</div>

<style>
.layout-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.layout-card:hover {
    transform: scale(1.02);
}
.layout-card.selected {
    border: 3px solid #007bff;
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.5);
    position: relative;
}
.layout-card.selected::after {
    content: "✔ Selected";
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #007bff;
    color: white;
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 4px;
    font-weight: bold;
}
.layout-meta p {
    font-size: 14px;
    color: #555;
}
.layout-meta strong {
    font-weight: 600;
}
</style>
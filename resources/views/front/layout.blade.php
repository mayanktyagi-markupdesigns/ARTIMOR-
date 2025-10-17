@php
$selectedLayoutId = session('selected_layout_id');
@endphp
<div class="materials">
    <!-- Nav Tabs -->
    <div class="d-flex align-items-center justify-content-center">
        @php
        // Get all unique layout types from table
        $layoutTypes = \App\Models\MaterialLayout::where('status', 1)->distinct()->pluck('layout_type');
        @endphp
        <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
            @foreach($layoutTypes as $index => $type)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if($index == 0) active @endif" id="{{ \Str::slug($type) }}-tab"
                    data-bs-toggle="tab" data-bs-target="#{{ \Str::slug($type) }}" type="button" role="tab">
                    {{ strtoupper($type) }}
                </button>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="materialsTabContent">
        @foreach($layoutTypes as $index => $type)
        @php
        $layouts = \App\Models\MaterialLayout::where('layout_type', $type)
            ->where('status', 1)
            ->get();
        @endphp
        <div class="tab-pane fade @if($index == 0) show active @endif" id="{{ \Str::slug($type) }}" role="tabpanel"
            aria-labelledby="{{ \Str::slug($type) }}-tab">
            <div class="row">
                @forelse($layouts as $key => $layout)
                <div class="col-md-4 mb-4">
                    <div class="p-0 card rounded-0 position-relative product-col layout-card {{ $selectedLayoutId == $layout->id ? 'selected' : '' }}"
                        data-id="{{ $layout->id }}">
                        <img src="{{ asset('uploads/material-layout/' . $layout->image) }}" class="card-img-top"
                            alt="{{ $layout->name }}">
                        <div class="p-0 card-body text-center">
                            <div class="titleoverlay">
                                <div>
                                    <span>{{ $key+1 }}.</span> {{ $layout->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p>No layouts available.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>
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
</style>
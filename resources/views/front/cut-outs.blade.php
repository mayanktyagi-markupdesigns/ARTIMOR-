@php
$cutoutSelection = session('cutout_selection', [
    'cutout_id' => null,
    'recess_type' => null
])  ?? [];
$selectedCutoutId = $cutoutSelection['cutout_id'] ?? null;
@endphp
<div class="materials">
    <!-- Nav Tabs -->
    <div class="d-flex align-items-center justify-content-center">
        <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
            @foreach($grouped->keys() as $key => $series)
                <li class="nav-item" role="presentation">
                    @php
                    $slug = Str::slug($series) ?: ('cutout-series-' . $key);
                    @endphp
                    <button class="nav-link @if($key === 0) active @endif"
                            id="{{ $slug }}-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $slug }}"
                            type="button" role="tab">
                        {{ $series ?: 'Other' }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="materialsTabContent">
        @foreach($grouped as $series => $items)
            @php
            $slug = Str::slug($series) ?: ('cutout-series-' . $loop->index);
            @endphp
            <div class="tab-pane fade @if($loop->first) show active @endif"
                 id="{{ $slug }}"
                 role="tabpanel"
                 aria-labelledby="{{ $slug }}-tab">
                <div class="row">
                    @foreach($items as $item)
                        <div class="col-md-4 mb-4">
                            <div class="p-0 card border-0 rounded-0 position-relative product-col cutout-card {{ $selectedCutoutId == $item->id ? 'selected' : '' }}"
                                 data-id="{{ $item->id }}">
                                @if($item->images->first())
                                    <img src="{{ asset('uploads/cut-outs/' . $item->images->first()->image) }}" class="card-img-top" alt="{{ $item->name }}" />
                                @else
                                    <img src="{{ asset('uploads/cut-outs/default.jpg') }}" class="card-img-top" alt="{{ $item->name }}" />
                                @endif
                                <div class="p-0 card-body text-center">
                                    <div class="titleoverlay">
                                        <div>
                                            <span>{{ $item->id }}.</span> {{ $item->name }}
                                        </div>
                                        <div class="mt-1">
                                            <small class="text-uppercase">{{ $item->category?->name ?? '—' }}</small>
                                        </div>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#cutoutModal-{{ $item->id }}" class="btn-link">Quick View</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for this cut-out -->
                        <div class="modal fade" id="cutoutModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Left: Main image -->
                                            <div class="col-md-7 text-center">
                                                @if($item->images->first())
                                                    <img src="{{ asset('uploads/cut-outs/' . $item->images->first()->image) }}" class="product-main-img" alt="{{ $item->name }}" />
                                                @else
                                                    <img src="{{ asset('uploads/cut-outs/default.jpg') }}" class="product-main-img" alt="{{ $item->name }}" />
                                                @endif
                                            </div>

                                            <!-- Right: Product Info -->
                                            <div class="col-md-5">
                                                <h2 class="fw-bold fs-3">{{ $item->name }}</h2>
                                                <p class="small mb-2">
                                                    <strong>Category:</strong> {{ $item->category?->name ?? '—' }}
                                                </p>
                                                <p class="small">
                                                    <strong>Series:</strong> {{ $item->series_type }}<br />
                                                    <strong>Price:</strong> ₹{{ $item->price }}<br />
                                                    <strong>Description:</strong> {{ $item->description }}
                                                </p>

                                                <!-- Form Fields -->
                                                <div class="row g-3 mb-4 mt-4">
                                                    <div class="col-md-12">
                                                        <div class="inputfild-box">
                                                            <label class="form-label">Number of recesses<sup>*</sup></label>
                                                            <select class="form-select cutout-recess-type" data-cutout-id="{{ $item->id }}"
                                                                    value="{{ $selectedCutoutId == $item->id ? $cutoutSelection['recess_type'] : '' }}">
                                                                <option value="">Choose...</option>
                                                                <option value="square" {{ $selectedCutoutId == $item->id && $cutoutSelection['recess_type'] == 'square' ? 'selected' : '' }}>Square</option>
                                                                <option value="round" {{ $selectedCutoutId == $item->id && $cutoutSelection['recess_type'] == 'round' ? 'selected' : '' }}>Round</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="d-flex justify-content-start gap-4 mt-5">
                                                    <button class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                                    <button class="btn btn-primary red-btn confirm-cutout" data-cutout-id="{{ $item->id }}">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.cutout-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.cutout-card:hover {
    transform: scale(1.02);
}
.cutout-card.selected {
    border: 3px solid #007bff;
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.5);
    position: relative;
}
.cutout-card.selected::after {
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
@php
$sinkSelection = session('sink_selection', [
    'sink_id' => null,
    'cutout' => null,
    'number' => null
]) ?? [];
$selectedSinkId = $sinkSelection['sink_id'] ?? null;
@endphp
<div class="materials">
    <div class="d-flex align-items-center justify-content-center my-5">
        <div class="headinfo d-flex align-items-center">
            <span class="me-3 cicle-t"></span><u>Already Have A Sink? (Select For No Sink)</u>
        </div>
    </div>

    @php
    // Build category list from sink->category->name with fallback to 'Other'
    $seriesList = $sinks
        ->map(function ($s) { return optional($s->category)->name ?: 'Other'; })
        ->unique()
        ->values();
    @endphp

    <!-- Nav Tabs -->
    <div class="d-flex align-items-center justify-content-center">
        <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
            @foreach($seriesList as $sIndex => $series)
            <li class="nav-item" role="presentation">
                @php
                $slug = Str::slug($series) ?: ('series-' . $sIndex);
                @endphp
                <button class="nav-link @if($sIndex==0) active @endif" id="{{ $slug }}-tab"
                    data-bs-toggle="tab" data-bs-target="#{{ $slug }}" type="button" role="tab">
                    {{ $series ?: 'Other' }}
                </button>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="materialsTabContent">
        @foreach($seriesList as $sIndex => $series)
        @php
        $slug = Str::slug($series) ?: ('series-' . $sIndex);
        @endphp
        <div class="tab-pane fade @if($sIndex==0) show active @endif" id="{{ $slug }}" role="tabpanel"
            aria-labelledby="{{ $slug }}-tab">
            <div class="row">
                @php
                // Filter sinks whose category name matches this tab
                $seriesSinks = $sinks->filter(function ($sink) use ($series) {
                    return (optional($sink->category)->name ?: 'Other') === $series;
                });
                @endphp

                @if($seriesSinks->count() > 0)
                @foreach($seriesSinks as $index => $sink)
                <div class="col-md-4 mb-4">
                    <div class="p-0 card border-0 rounded-0 position-relative product-col sink-card {{ $selectedSinkId == $sink->id ? 'selected' : '' }}"
                        data-id="{{ $sink->id }}">
                        <img src="{{ asset('uploads/sinks/'.$sink->images->first()->image ?? 'default.jpg') }}"
                            class="card-img-top" alt="{{ $sink->name }}" />
                        <div class="p-0 card-body text-center">
                            <div class="titleoverlay">
                                <div>
                                    <span>{{ $index + 1 }}</span> {{ $sink->name }}
                                </div>
                                @if(optional($sink->category)->name)
                                <div class="mt-1">
                                    <small class="text-uppercase">{{ $sink->category->name }}</small>
                                </div>
                                @endif
                                <a href="#" data-bs-toggle="modal" data-bs-target="#productModal-{{ $sink->id }}"
                                    class="btn-link">Quick View</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for each sink -->
                <div class="modal fade" id="productModal-{{ $sink->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-7 text-center">
                                        <img src="{{ asset('uploads/sinks/'.$sink->images->first()->image ?? 'default.jpg') }}"
                                            class="product-main-img" alt="{{ $sink->name }}" />
                                    </div>
                                    <div class="col-md-5">
                                        <h2 class="fw-bold fs-3">{{ $sink->name }}</h2>
                                        @if(optional($sink->category)->name)
                                        <p class="small mb-2">
                                            <strong>Category:</strong> {{ $sink->category->name }}
                                        </p>
                                        @endif
                                        <p class="small">
                                            {{ $sink->radius ?? '' }} Radius<br />
                                            <strong>Internal Dimensions:</strong> {{ $sink->internal_dimensions ?? '' }}<br />
                                            <strong>External Dimensions:</strong> {{ $sink->external_dimensions ?? '' }}<br />
                                            <strong>Depth:</strong> {{ $sink->depth ?? '' }}<br />
                                        </p>
                                        <!-- Form Fields -->
                                        <div class="row g-3 mb-4 mt-4">
                                            <div class="col-md-6">
                                                <div class="inputfild-box">
                                                    <label class="form-label">Cutout<sup>*</sup></label>
                                                    <select class="form-select sink-cutout" data-sink-id="{{ $sink->id }}"
                                                        value="{{ $selectedSinkId == $sink->id ? $sinkSelection['cutout'] : '' }}">
                                                        <option value="">Choose...</option>
                                                        <option value="vlakinbouw" {{ $selectedSinkId == $sink->id && $sinkSelection['cutout'] == 'vlakinbouw' ? 'selected' : '' }}>Vlakinbouw/inleg</option>
                                                        <option value="onderbouw" {{ $selectedSinkId == $sink->id && $sinkSelection['cutout'] == 'onderbouw' ? 'selected' : '' }}>Onderbouw</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="inputfild-box">
                                                    <label class="form-label">Number<sup>*</sup></label>
                                                    <input type="number" class="form-control sink-number" data-sink-id="{{ $sink->id }}"
                                                        value="{{ $selectedSinkId == $sink->id ? ($sinkSelection['number'] ?? 2) : 2 }}"
                                                        min="0" max="10">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 mt-5">
                                            <button class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary red-btn confirm-sink" data-sink-id="{{ $sink->id }}">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12 text-center">
                    <p>No sinks available for this series.</p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.sink-card {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.sink-card:hover {
    transform: scale(1.02);
}
.sink-card.selected {
    border: 3px solid #007bff;
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.5);
    position: relative;
}
.sink-card.selected::after {
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
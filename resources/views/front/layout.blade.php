@php
$layoutsByType = $layoutsByType ?? collect(); // Categories
$layoutTypes = $layoutTypes ?? collect(); // Category Names
$selectedLayoutId = (string)($selectedLayoutId ?? session('selected_layout_id'));
@endphp

<div class="materials">
    @if($layoutTypes->isNotEmpty())

    <!-- ================= TABS ================= -->
    <div class="d-flex align-items-center justify-content-center">
        <ul class="border-0 nav nav-tabs justify-content-center mb-5" id="materialsTab" role="tablist">
            @foreach($layoutTypes as $index => $type)
            @php $tabId = \Illuminate\Support\Str::slug($type ?: 'Other'); @endphp
            <li class="nav-item">
                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                    data-bs-target="#{{ $tabId }}" type="button">
                    {{ strtoupper($type ?: 'Other') }}
                </button>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- ================= CONTENT ================= -->
    <div class="tab-content" id="materialsTabContent">

        @foreach($layoutTypes as $index => $type)

        @php
        $tabId = \Illuminate\Support\Str::slug($type ?: 'Other');
        $category = $layoutsByType->get($type); // ✅ Category Model
        @endphp

        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $tabId }}">

            @if($category && $category->groups->isNotEmpty())

            @foreach($category->groups as $group)

            @if($group->shapes->isNotEmpty())

            <!-- ===== GROUP TITLE ===== -->
            <div class="col-12 mb-4">
                <h5 class="mb-3 text-primary fw-bold">
                    {{ $group->name }}
                </h5>

                <div class="row">

                    @foreach($group->shapes as $loopIndex => $layout)

                    @php
                    $layoutId = (string)$layout->id;
                    $imagePath = $layout->image
                    ? asset('uploads/layout-shapes/' . $layout->image)
                    : asset('assets/front/img/product-circle.jpg');
                    @endphp

                    <div class="col-md-4 mb-4">
                        <div class="p-0 card rounded-0 position-relative layout-card
                                         {{ $selectedLayoutId === $layoutId ? 'selected' : '' }}"
                            data-id="{{ $layoutId }}">

                            <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $layout->name }}">

                            <div class="p-0 card-body text-center">
                                <div class="titleoverlay">
                                    <div>
                                        <span>{{ $loopIndex + 1 }}.</span>
                                        {{ $layout->name }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @endforeach

                </div>
            </div>

            @endif
            @endforeach

            @else
            <div class="col-12 text-center py-5">
                <p class="mb-0">No layouts available.</p>
            </div>
            @endif

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
</style>
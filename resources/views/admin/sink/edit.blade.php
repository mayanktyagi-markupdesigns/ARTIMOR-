@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Sink</h3>
        <a href="{{ route('admin.sink.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')

            <form action="{{ route('admin.sink.update', $sink->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label>Name</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $sink->name) }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Sink  Category -->
                    <div class="col-md-4 mb-3">
                        <label for="sink_categorie_id">Sink Category</label><span style="color:red;">*</span>
                        <select class="form-select" name="sink_categorie_id" id="sink_categorie_id">
                            @foreach(($categories ?? []) as $category)
                            <option value="{{ $category->id }}"
                                {{ old('sink_categorie_id', $sink->sink_categorie_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('sink_categorie_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label for="price">Per Sq/Price</label><span style="color:red;">*</span>
                        <input type="number" step="0.01" class="form-control" name="price" id="price"
                            value="{{ old('price', $sink->price) }}" placeholder="Enter price">
                        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="user_price">Per Sq/User Price</label><span style="color:red;">*</span>
                        <input type="number" step="0.01" class="form-control" name="user_price" id="user_price"
                            value="{{ old('user_price', $sink->user_price) }}" placeholder="Enter price">
                        @error('user_price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Internal / External Dimensions -->
                    <div class="col-md-4 mb-3">
                        <label>Internal Dimensions</label>
                        <input type="text" class="form-control" name="internal_dimensions"
                            value="{{ old('internal_dimensions', $sink->internal_dimensions) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>External Dimensions</label>
                        <input type="text" class="form-control" name="external_dimensions"
                            value="{{ old('external_dimensions', $sink->external_dimensions) }}">
                    </div>

                    <!-- Depth / Radius -->
                    <div class="col-md-4 mb-3">
                        <label>Depth (mm)</label>
                        <input type="number" class="form-control" name="depth" value="{{ old('depth', $sink->depth) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Radius (mm)</label>
                        <input type="number" class="form-control" name="radius"
                            value="{{ old('radius', $sink->radius) }}">
                    </div>

                    <!-- Upload New Images -->
                    <div class="col-md-4 mb-3">
                        <label>Upload New Images</label>
                        <input type="file" class="form-control" name="images[]" id="images" multiple
                            accept=".jpg,.jpeg,.png,.svg">
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1" {{ old('status', $sink->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $sink->status) == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <!-- Image Preview Box -->
                    <div class="col-md-6 mb-3">
                        <label>Images</label>
                        <div id="preview-box" class="border p-3 rounded bg-light">
                            <p class="mb-2"><strong>Total Images:</strong> <span id="image-count">0</span></p>
                            <div id="image-preview" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.sink.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
const imageInput = document.getElementById('images');
const previewContainer = document.getElementById('image-preview');
const imageCount = document.getElementById('image-count');
let selectedFiles = [];

// Load existing images from server
let existingImages = @json($sink - > images - > map(fn($img) => $img - > image));
existingImages.forEach(img => {
    const wrapper = document.createElement('div');
    wrapper.classList.add('position-relative');

    const imageEl = document.createElement('img');
    imageEl.src = '{{ asset("uploads/sinks") }}/' + img;
    imageEl.classList.add('rounded');
    imageEl.style.width = '100px';
    imageEl.style.height = '100px';
    imageEl.style.objectFit = 'cover';

    const removeBtn = document.createElement('button');
    removeBtn.innerHTML = '&times;';
    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
    removeBtn.style.padding = '2px 6px';
    removeBtn.style.fontSize = '14px';
    removeBtn.onclick = function() {
        wrapper.remove();
        existingImages = existingImages.filter(i => i !== img);
        updateCount();
    };

    wrapper.appendChild(imageEl);
    wrapper.appendChild(removeBtn);
    previewContainer.appendChild(wrapper);
});
updateCount();

// Handle new image selection
imageInput.addEventListener('change', function(event) {
    selectedFiles = Array.from(event.target.files);
    renderPreviews();
});

function renderPreviews() {
    // Clear preview
    previewContainer.innerHTML = '';

    // Render existing images
    existingImages.forEach(img => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('position-relative');

        const imageEl = document.createElement('img');
        imageEl.src = '{{ asset("uploads/sinks") }}/' + img;
        imageEl.classList.add('rounded');
        imageEl.style.width = '100px';
        imageEl.style.height = '100px';
        imageEl.style.objectFit = 'cover';

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&times;';
        removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
        removeBtn.style.padding = '2px 6px';
        removeBtn.style.fontSize = '14px';
        removeBtn.onclick = function() {
            wrapper.remove();
            existingImages = existingImages.filter(i => i !== img);
            updateCount();
        };

        wrapper.appendChild(imageEl);
        wrapper.appendChild(removeBtn);
        previewContainer.appendChild(wrapper);
    });

    // Render newly selected files
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('position-relative');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('rounded');
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.objectFit = 'cover';

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '&times;';
            removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
            removeBtn.style.padding = '2px 6px';
            removeBtn.style.fontSize = '14px';
            removeBtn.onclick = function() {
                selectedFiles.splice(index, 1);
                renderPreviews();
                updateFileInput();
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });

    updateCount();
}

function updateFileInput() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    imageInput.files = dataTransfer.files;
}

function updateCount() {
    imageCount.textContent = existingImages.length + selectedFiles.length;
}
</script>
@endpush

@endsection
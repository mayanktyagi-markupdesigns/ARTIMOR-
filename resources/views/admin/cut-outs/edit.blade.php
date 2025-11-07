@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Edit Cut outs</h3>
        <a href="{{ route('admin.cut.outs.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <form action="{{ route('admin.cut.outs.update', $outs->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label>Name</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $outs->name) }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                   <!-- Cut Outs Category -->
                    <div class="col-md-4 mb-3">
                        <label for="cut_outs_category_id">Material Type</label><span style="color:red;">*</span>
                        <select class="form-select" name="cut_outs_category_id" id="cut_outs_category_id">
                            @foreach(($categories ?? []) as $category)
                            <option value="{{ $category->id }}"
                                {{ old('cut_outs_category_id', $outs->cut_outs_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('cut_outs_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>    

                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label for="price">Per Sq/Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" id="price" 
                            value="{{ old('price', $outs->price) }}" placeholder="Enter price">
                        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>              
                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1" {{ old('status', $outs->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $outs->status) == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>                  
                    <!-- Upload New Images -->
                    <div class="col-md-4 mb-3">
                        <label>Upload New Images</label>
                        <input type="file" class="form-control" name="images[]" id="images" multiple
                            accept=".jpg,.jpeg,.png,.svg">
                    </div>
                      <!-- Description -->
                    <div class="col-md-6 mb-3"> 
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"
                            placeholder="Enter description">{{ old('description', $outs->description) }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
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
                    <a href="{{ route('admin.cut.outs.list') }}" class="btn btn-danger ms-2">Cancel</a>
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
let existingImages = @json($outs->images->map(fn($img) => $img->image));
existingImages.forEach(img => {
    const wrapper = document.createElement('div');
    wrapper.classList.add('position-relative');

    const imageEl = document.createElement('img');
    imageEl.src = '{{ asset("uploads/cut-outs") }}/' + img;
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
        imageEl.src = '{{ asset("uploads/cut-outs") }}/' + img;
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
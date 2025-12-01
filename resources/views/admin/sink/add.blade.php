@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Add New Sink</h3>
        <a href="{{ route('admin.sink.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="">
                <form action="{{ route('admin.sink.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-4 mb-3">
                            <label for="name">Name</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                                placeholder="Enter name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Material Category -->
                        <div class="col-md-4 mb-3">
                            <label for="sink_categorie_id">Sink Category</label><span style="color:red;">*</span>
                            <select class="form-select" name="sink_categorie_id" id="sink_categorie_id">
                                <option value="">Select Sink Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('sink_categorie_id') == $category->id ? 'selected' : '' }}>
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
                                value="{{ old('price') }}" placeholder="Enter price">
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!--User Price -->
                        <div class="col-md-4 mb-3">
                            <label for="user_price">Per Sq/User Price</label><span style="color:red;">*</span>
                            <input type="number" step="0.01" class="form-control" name="user_price" id="user_price"
                                value="{{ old('user_price') }}" placeholder="Enter price">
                            @error('user_price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Internal Dimensions -->
                        <div class="col-md-4 mb-3">
                            <label for="internal_dimensions">Internal Dimensions</label>
                            <input type="text" class="form-control" name="internal_dimensions" id="internal_dimensions"
                                value="{{ old('internal_dimensions') }}" placeholder="e.g., 170x400 mm">
                            @error('internal_dimensions') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- External Dimensions -->
                        <div class="col-md-4 mb-3">
                            <label for="external_dimensions">External Dimensions</label>
                            <input type="text" class="form-control" name="external_dimensions" id="external_dimensions"
                                value="{{ old('external_dimensions') }}" placeholder="e.g., 210x440 mm">
                            @error('external_dimensions') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Depth -->
                        <div class="col-md-4 mb-3">
                            <label for="depth">Depth (mm)</label>
                            <input type="number" class="form-control" name="depth" id="depth" value="{{ old('depth') }}"
                                placeholder="e.g., 180">
                            @error('depth') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Radius -->
                        <div class="col-md-4 mb-3">
                            <label for="radius">Radius (mm)</label>
                            <input type="number" class="form-control" name="radius" id="radius"
                                value="{{ old('radius') }}" placeholder="e.g., 10">
                            @error('radius') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Additional Images -->
                        <div class="col-md-4 mb-3">
                            <label for="images">Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple
                                accept=".jpg,.jpeg,.png,.svg">
                            @error('images') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Image Preview Box -->
                        <div class="col-md-6 mb-3">
                            <label>Preview of Selected Images:</label>
                            <div id="preview-box" class="border p-3 rounded bg-light">
                                <p class="mb-2"><strong>Total Images:</strong> <span id="image-count">0</span></p>
                                <div id="image-preview" class="d-flex flex-wrap gap-2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('admin.sink.list') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
const imageInput = document.getElementById('images');
const previewContainer = document.getElementById('image-preview');
const imageCount = document.getElementById('image-count');
let selectedFiles = [];

imageInput.addEventListener('change', function(event) {
    selectedFiles = Array.from(event.target.files);
    renderPreviews();
});

function renderPreviews() {
    previewContainer.innerHTML = '';
    imageCount.textContent = selectedFiles.length;

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
            removeBtn.style.lineHeight = '1';
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
}

function updateFileInput() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    imageInput.files = dataTransfer.files;
    imageCount.textContent = selectedFiles.length;
}
</script>
@endpush

@endsection
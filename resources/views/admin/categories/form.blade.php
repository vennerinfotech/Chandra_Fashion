<div class="card shadow-sm p-4">
    <h4 class="mb-3">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h4>

    {{-- Category Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name ?? '') }}">
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="3"
            class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Image field -->
    <div class="mb-3">
        <label for="image" class="form-label">Category Image</label>
        <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
        @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        {{-- Existing Image (for Edit page only) --}}
        @if(isset($category) && $category->image)
            <div class="mt-2">
                <img src="{{ asset('images/categories/' . $category->image) }}" alt="Current Image" id="existingImage"
                    width="80" height="80" class="rounded border">
            </div>
        @endif

        {{-- Image Preview (for new uploads) --}}
        <div class="mt-2" id="previewContainer" style="display:none;">
            <img id="imagePreview" src="#" alt="Image Preview" width="80" height="80" class="rounded border">
        </div>
    </div>

    {{-- Status --}}
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="1" {{ old('status', $category->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $category->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    {{-- Submit --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn">
            {{ isset($category) ? 'Update Category' : 'Create Category' }}
        </button>
    </div>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const existingImage = document.getElementById('existingImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block';
                if (existingImage) {
                    existingImage.style.display = 'none';
                }
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

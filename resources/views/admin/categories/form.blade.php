<div class="card shadow-sm p-4">
    <h4 class="mb-3">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h4>

    {{-- Category Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" id="name"
            class="form-control"
            value="{{ old('name', $category->name ?? '') }}"
            required>
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="3"
                  class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

     <!-- Image field -->
    <div class="mb-3">
        <label for="image" class="form-label">Category Image</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>

    {{-- Status --}}
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="1" {{ old('status', $category->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $category->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>


    {{-- Submit --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn">
            {{ isset($category) ? 'Update Category' : 'Create Category' }}
        </button>
    </div>
</div>

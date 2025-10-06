<div class="card shadow-sm p-4">
    <h4 class="mb-3">{{ isset($subcategory) ? 'Edit SubCategory' : 'Add SubCategory' }}</h4>

    {{-- Category Dropdown --}}
    <div class="mb-3">
        <label for="category_id" class="form-label">Parent Category</label>
        <select name="category_id" id="category_id" class="form-select" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $subcategory->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- SubCategory Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">SubCategory Name</label>
        <input type="text" name="name" id="name"
               class="form-control"
               value="{{ old('name', $subcategory->name ?? '') }}" required>
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="3"
                  class="form-control">{{ old('description', $subcategory->description ?? '') }}</textarea>
    </div>

    {{-- Image --}}
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>

    {{-- Status --}}
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="1" {{ old('status', $subcategory->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $subcategory->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    {{-- Submit --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">
            {{ isset($subcategory) ? 'Update SubCategory' : 'Create SubCategory' }}
        </button>
    </div>
</div>

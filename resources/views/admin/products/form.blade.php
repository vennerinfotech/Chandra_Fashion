<div class="card shadow-sm p-4">
    <h4 class="mb-3">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h4>

    {{-- Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" name="name" id="name"
               class="form-control"
               value="{{ old('name', $product->name ?? '') }}"
               required>
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="3"
                  class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    {{-- Category & Fabric --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" id="category"
                   class="form-control"
                   value="{{ old('category', $product->category ?? '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="fabric" class="form-label">Fabric</label>
            <input type="text" name="fabric" id="fabric"
                   class="form-control"
                   value="{{ old('fabric', $product->fabric ?? '') }}">
        </div>
    </div>

    {{-- MOQ & Price --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="moq" class="form-label">Minimum Order Quantity (MOQ)</label>
            <input type="number" name="moq" id="moq"
                   class="form-control"
                   value="{{ old('moq', $product->moq ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" name="price" id="price"
                   class="form-control"
                   value="{{ old('price', $product->price ?? '') }}">
        </div>
    </div>

    {{-- Export Ready --}}
    <div class="form-check mb-3">
        <input type="checkbox" name="export_ready" id="export_ready"
               class="form-check-input"
               {{ old('export_ready', $product->export_ready ?? false) ? 'checked' : '' }}>
        <label for="export_ready" class="form-check-label">Export Ready</label>
    </div>


    <div class="row">
        <div class="col-lg-6 mb-3">
           <label for="image" class="form-label">Main Image</label>
        <input type="file" name="image" id="image" class="form-control">
        @if(!empty($product->image_url))
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="Product Image"
                     class="img-thumbnail" width="150">
            </div>
        @endif
        </div>
        <div class="col-lg-6 mb-3">
            <label for="gallery" class="form-label">Gallery Images</label>
        <input type="file" name="gallery[]" id="gallery" class="form-control" multiple>
        @if(!empty($product->gallery))
            <div class="mt-3 d-flex flex-wrap">
                @foreach($product->gallery as $img)
                    <img src="{{ asset('storage/' . $img) }}" alt="Gallery Image"
                         class="img-thumbnail me-2 mb-2" width="100">
                @endforeach
            </div>
        @endif
        </div>
    </div>

    {{-- Colors, Sizes, Tags --}}
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="colors" class="form-label">Colors (comma separated)</label>
            <input type="text" name="colors" id="colors"
                   class="form-control"
                   value="{{ old('colors', isset($product->colors) ? implode(',', $product->colors) : '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="sizes" class="form-label">Sizes (comma separated)</label>
            <input type="text" name="sizes" id="sizes"
                   class="form-control"
                   value="{{ old('sizes', isset($product->sizes) ? implode(',', $product->sizes) : '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="tags" class="form-label">Tags (comma separated)</label>
            <input type="text" name="tags" id="tags"
                   class="form-control"
                   value="{{ old('tags', isset($product->tags) ? implode(',', $product->tags) : '') }}">
        </div>
    </div>

    {{-- Submit --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn">
            {{ isset($product) ? 'Update Product' : 'Create Product' }}
        </button>
    </div>
</div>

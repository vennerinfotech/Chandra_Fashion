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

    {{-- Materials & Delivery Time --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="materials" class="form-label">Materials</label>
            <input type="text" name="materials" id="materials"
                   class="form-control"
                   value="{{ old('materials', $product->materials ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="delivery_time" class="form-label">Delivery Time</label>
            <input type="text" name="delivery_time" id="delivery_time"
                   class="form-control"
                   value="{{ old('delivery_time', $product->delivery_time ?? '') }}">
        </div>
    </div>

    <select name="category_id" id="category" class="form-control" required>
        <option value="">Select Category</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>


    {{-- Price --}}
    <div class="mb-3">
        <label for="price" class="form-label">Base Price</label>
        <input type="text" name="price" id="price"
               class="form-control"
               value="{{ old('price', $product->price ?? '') }}">
    </div>

    {{-- Export Ready --}}
    <div class="form-check mb-3">
        <input type="checkbox" name="export_ready" id="export_ready"
               class="form-check-input"
               {{ old('export_ready', $product->export_ready ?? false) ? 'checked' : '' }}>
        <label for="export_ready" class="form-check-label">Export Ready</label>
    </div>


    <hr>
    <h5 class="d-flex justify-content-between align-items-center">
        Product Variants
        {{-- <button type="button" id="add-variant" class="btn btn-sm btn-outline-primary">+ Add Variant</button> --}}
    </h5>

<div id="variants-wrapper">
    @if(isset($product) && $product->variants)
        @foreach($product->variants as $i => $variant)
            <div class="variant-item border rounded p-3 mb-3 position-relative">
                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label">Product Code</label>
                        <input type="text" name="variants[{{ $i }}][product_code]" class="form-control"
                               value="{{ old('variants.'.$i.'.product_code', $variant->product_code) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Color</label>
                        <input type="text" name="variants[{{ $i }}][color]" class="form-control"
                               value="{{ old('variants.'.$i.'.color', $variant->color) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size</label>
                        <input type="text" name="variants[{{ $i }}][size]" class="form-control"
                               value="{{ old('variants.'.$i.'.size', $variant->size) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">MOQ</label>
                        <input type="number" name="variants[{{ $i }}][moq]" class="form-control"
                               value="{{ old('variants.'.$i.'.moq', $variant->moq) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Images <span class="text-danger">*</span></label>
                        <input type="file"
                               name="variants[{{ $i }}][images][]"
                               class="form-control variant-images"
                               multiple
                               required>

                        <div class="mt-2 preview-wrapper" id="preview-{{ $i }}">
                            {{-- Show existing images if editing --}}
                            @if(isset($variant->images) && $variant->images)
                                @php
                                    $images = is_array($variant->images) ? $variant->images : json_decode($variant->images, true);
                                @endphp
                                @foreach($images as $img)
                                    <img src="{{ asset($img) }}" width="100" class="me-1 mb-1 img-thumbnail">
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        {{-- Default single variant --}}
        <div class="variant-item border rounded p-3 mb-3 position-relative">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label">Product Code</label>
                    <input type="text" name="variants[0][product_code]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Color</label>
                    <input type="text" name="variants[0][color]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Size</label>
                    <input type="text" name="variants[0][size]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">MOQ</label>
                    <input type="number" name="variants[0][moq]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Images <span class="text-danger">*</span></label>
                    <input type="file"
                           name="variants[0][images][]"
                           class="form-control variant-images"
                           multiple
                           required>
                    <div class="mt-2 preview-wrapper" id="preview-0"></div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    {{-- Add variant icon --}}
                    <a href="javascript:void(0);" title="Add" class="btn-action btn-sm me-2" id="add-variant">
                        <i class="fa-solid fa-circle-plus text-success"></i>
                    </a>

                    {{-- Cancel variant icon --}}
                    <a href="javascript:void(0);" title="Cancel" class="btn-action btn-sm remove-variant">
                        <i class="fa-solid fa-circle-xmark text-danger"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Submit --}}
<div class="d-flex justify-content-center">
    <button type="submit" class="btn btn-success">
        {{ isset($product) ? 'Update Product' : 'Create Product' }}
    </button>
</div>



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

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Price --}}
    <div class="mb-3">
        <label for="price" class="form-label">Base Price</label>
        <input type="text" name="price" id="price"
               class="form-control"
               value="{{ old('price', $product->price ?? '') }}">
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



    {{-- Export Ready --}}
    <div class="form-check mb-3">
        <input type="checkbox" name="export_ready" id="export_ready"
               class="form-check-input"
               {{ old('export_ready', $product->export_ready ?? false) ? 'checked' : '' }}>
        <label for="export_ready" class="form-check-label">Export Ready</label>
    </div>

    {{-- Main Image --}}
    {{-- <div class="mb-3">
        <label for="image" class="form-label">Main Image</label>
        <input type="file" name="image" id="image" class="form-control">
        @if(!empty($product->image_url))
            <div class="mt-2">
                <img src="{{ url($product->image_url) }}" alt="Product Image"
                     class="img-thumbnail" width="150">
            </div>
        @endif
    </div> --}}

    <hr>
    <h5>Product Variants</h5>

<div id="variants-wrapper">
    @php $variants = $product->variants ?? [null]; @endphp

    @foreach($variants as $index => $variant)
    <div class="variant-item border rounded p-3 mb-3 position-relative">
        <div class="row">
            <div class="col-md-3">
                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id ?? '' }}">
                <label class="form-label">Product Code</label>
                <input type="text" name="variants[{{ $index }}][product_code]" class="form-control"
                    value="{{ old("variants.$index.product_code", $variant->product_code ?? '') }}" required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Color</label>
                <input type="text" name="variants[{{ $index }}][color]" class="form-control"
                    value="{{ old("variants.$index.color", $variant->color ?? '') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Size</label>
                <input type="text" name="variants[{{ $index }}][size]" class="form-control"
                    value="{{ old("variants.$index.size", $variant->size ?? '') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">MOQ</label>
                <input type="number" name="variants[{{ $index }}][moq]" class="form-control"
                    value="{{ old("variants.$index.moq", $variant->moq ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Images</label>
                <input type="file" name="variants[{{ $index }}][images][]" class="form-control variant-images" multiple>
                <div class="variant-images-preview d-flex flex-wrap gap-2 mt-2">
                    @if(!empty($variant->images))
                        @foreach(json_decode($variant->images) as $img)
                            <img src="{{ asset($img) }}" class="img-thumbnail" style="width:70px;height:70px;object-fit:cover;">
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



    {{-- Button to add more variants dynamically (JS required) --}}
    <div class="mb-3">
        <button type="button" id="add-variant" class="btn btn-outline-primary btn-sm">+ Add Variant</button>
    </div>

    {{-- Submit --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success">
            {{ isset($product) ? 'Update Product' : 'Create Product' }}
        </button>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    // Add new variant
    $('#add-variant').click(function() {
        let wrapper = $('#variants-wrapper');
        let index = wrapper.find('.variant-item').length;

        let html = `
        <div class="variant-item border rounded p-3 mb-3 position-relative">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Product Code</label>
                    <input type="text" name="variants[${index}][product_code]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Color</label>
                    <input type="text" name="variants[${index}][color]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Size</label>
                    <input type="text" name="variants[${index}][size]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">MOQ</label>
                    <input type="number" name="variants[${index}][moq]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Images</label>
                    <input type="file" name="variants[${index}][images][]" class="form-control variant-images" multiple>
                    <div class="variant-images-preview d-flex flex-wrap gap-2 mt-2"></div>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-variant">X</button>
        </div>
        `;

        wrapper.append(html);
    });

    // Remove variant
    $(document).on('click', '.remove-variant', function() {
        $(this).closest('.variant-item').remove();
    });

    // Image preview
    $(document).on('change', '.variant-images', function() {
        let previewContainer = $(this).siblings('.variant-images-preview');
        previewContainer.empty();

        let files = this.files;
        if (files) {
            Array.from(files).forEach(file => {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = $('<img>')
                        .attr('src', e.target.result)
                        .css({'width':'70px','height':'70px','object-fit':'cover'})
                        .addClass('img-thumbnail');
                    previewContainer.append(img);
                }
                reader.readAsDataURL(file);
            });
        }
    });
});


</script>
@endpush

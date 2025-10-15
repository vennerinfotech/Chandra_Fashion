<div class="card shadow-sm p-4">
    <h4 class="mb-3">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h4>

    {{-- Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name ?? '') }}">
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    {{-- Category & Subcategory --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="subcategory_id" class="form-label">Subcategory</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control">
                <option value="">-- Select Subcategory --</option>
            </select>
            @error('subcategory_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    {{-- Description --}}
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <div id="description-toolbar-container"></div>
        <textarea name="description" id="description" rows="5"
            class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Short Description & Care Instructions --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="short_description" class="form-label">Short Description</label>
            <div id="short_description-toolbar-container"></div>
            <textarea name="short_description" id="short_description" rows="3"
                class="form-control">{{ old('short_description', $product->short_description ?? '') }}</textarea>
            @error('short_description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="care_instructions" class="form-label">Care Instructions</label>
            <div id="care_instructions-toolbar-container"></div>
            <textarea name="care_instructions" id="care_instructions" rows="3"
                class="form-control">{{ old('care_instructions', $product->care_instructions ?? '') }}</textarea>
            @error('care_instructions') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    {{-- Price - Materials & Delivery Time --}}
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-3">
            <label for="price" class="form-label">Base Price</label>
            <input type="text" name="price" id="price" class="form-control"
                value="{{ old('price', $product->price ?? '') }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <label for="materials" class="form-label">Materials</label>
            <input type="text" name="materials" id="materials" class="form-control"
                value="{{ old('materials', $product->materials ?? '') }}">
            @error('materials') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <label for="delivery_time" class="form-label">Delivery Time</label>
            <input type="text" name="delivery_time" id="delivery_time" class="form-control"
                value="{{ old('delivery_time', $product->delivery_time ?? '') }}">
            @error('delivery_time') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    {{-- Export Ready --}}
    {{-- <div class="form-check mb-3">
        <input type="checkbox" name="export_ready" id="export_ready" class="form-check-input" {{ old('export_ready',
            $product->export_ready ?? false) ? 'checked' : '' }}>
        <label for="export_ready" class="form-check-label">Export Ready</label>
    </div> --}}

    {{-- Variants --}}
    <div id="variants-wrapper">
        @php $variants = $product->variants ?? [null]; @endphp
        @foreach ($variants as $index => $variant)
            <div class="variant-item border rounded p-3 mb-3 position-relative">
                <a href="javascript:void(0);" class="btn-action btn-sm remove-variant position-absolute top-0 end-0 m-2">
                    <i class="fa-solid fa-circle-xmark text-danger"></i>
                </a>
                <div class="row g-2">
                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id ?? '' }}">

                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Product Code</label>
                        <input type="text" name="variants[{{ $index }}][product_code]" class="form-control"
                            value="{{ old("variants.$index.product_code", $variant->product_code ?? '') }}">
                        @error("variants.$index.product_code")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">MOQ (KG)</label>
                        <input type="number" name="variants[{{ $index }}][moq]" class="form-control"
                            value="{{ old("variants.$index.moq", $variant->moq ?? '') }}">
                        @error("variants.$index.moq")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Images</label>
                        <input type="file" name="variants[{{ $index }}][images][]" class="form-control variant-images"
                            multiple>
                        <div class="mt-2 preview-wrapper d-flex flex-wrap gap-1">
                            @if(!empty($variant->images))
                                @foreach(json_decode($variant->images) as $img)
                                    <div class="position-relative d-inline-block me-1 mb-1">
                                        <img src="{{ asset($img) }}" width="80" height="80" class="rounded border">
                                        <span class="position-absolute top-0 end-0 p-1 cursor-pointer remove-old-image">
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        </span>
                                        <input type="hidden" value="{{ $img }}">
                                    </div>
                                @endforeach
                            @endif
                            @error("variants.$index.images")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <input type="hidden" name="variants[{{ $index }}][removed_images]" class="removed-images" value="">
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-3">
        <button type="button" id="add-variant" class="btn btn-outline-primary btn-sm">+ Add Variant</button>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success">
            {{ isset($product) ? 'Update Product' : 'Create Product' }}
        </button>
    </div>
</div>
@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categorySelect = document.getElementById('category_id');
            var subcategorySelect = document.getElementById('subcategory_id');
            var selectedSubcategoryId = '{{ old('subcategory_id', $product->subcategory_id ?? '') }}';
            console.log()
            // If editing, fetch subcategories for current category
            if (categorySelect.value) {
                fetchSubcategories(categorySelect.value, selectedSubcategoryId);
            }

            categorySelect.addEventListener('change', function () {
                var categoryId = this.value;
                if (categoryId) {

                    fetchSubcategories(categoryId, null); // no selection on change
                } else {
                    subcategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
                }
            });

            function fetchSubcategories(categoryId, selectId = null) {
                fetch('/admin/get-subcategories/' + categoryId)
                    .then(response => response.json())
                    .then(data => {
                        subcategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
                        data.subcategories.forEach(function (subcategory) {
                            var option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name;
                            if (selectId && selectId == subcategory.id) {
                                option.selected = true; // mark the correct subcategory as selected
                            }
                            subcategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                    });
            }
        });



        // product variant - remove and Image perview in add-update product from
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('variants-wrapper');

            // Add new variant
            document.getElementById('add-variant').addEventListener('click', function () {
                const index = wrapper.querySelectorAll('.variant-item').length;
                const html = `
                                <div class="variant-item border rounded p-3 mb-3 position-relative">
                                    <a href="javascript:void(0);" class="btn-action btn-sm remove-variant position-absolute top-0 end-0 m-2">
                                        <i class="fa-solid fa-circle-xmark text-danger"></i>
                                    </a>
                                    <hr>
                                    <h5>Product Variants</h5>
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <label class="form-label">Product Code</label>
                                            <input type="text" name="variants[${index}][product_code]" class="form-control" >
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">MOQ</label>
                                            <input type="number" name="variants[${index}][moq]" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Images</label>
                                            <input type="file" name="variants[${index}][images][]" class="form-control variant-images" multiple>
                                            <div class="mt-2 preview-wrapper"></div>
                                            <input type="hidden" name="variants[${index}][removed_images]" class="removed-images" value="">
                                        </div>
                                    </div>
                                </div>`;
                wrapper.insertAdjacentHTML('beforeend', html);
            });

            // Remove variant
            wrapper.addEventListener('click', function (e) {
                if (e.target.closest('.remove-variant')) {
                    const item = e.target.closest('.variant-item');
                    if (item) item.remove();
                }
            });

            // Remove old images
            wrapper.addEventListener('click', function (e) {
                if (e.target.closest('.remove-old-image')) {
                    const container = e.target.closest('div.position-relative');
                    if (container) {
                        const input = container.querySelector('input[type=hidden]');
                        const removedInput = container.closest('.variant-item').querySelector('.removed-images');
                        if (input && removedInput) {
                            let removed = removedInput.value ? JSON.parse(removedInput.value) : [];
                            removed.push(input.value);
                            removedInput.value = JSON.stringify(removed);
                        }
                        container.remove();
                    }
                }
            });

            // Preview new images
            wrapper.addEventListener('change', function (e) {
                if (e.target.classList.contains('variant-images')) {
                    const previewWrapper = e.target.closest('.col-md-3').querySelector('.preview-wrapper');
                    if (!previewWrapper) return;

                    previewWrapper.innerHTML = '';
                    Array.from(e.target.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            const imgContainer = document.createElement('div');
                            imgContainer.classList.add('position-relative', 'd-inline-block', 'me-2', 'mb-2');
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.width = 100; img.height = 100;
                            img.classList.add('rounded', 'border');

                            const removeBtn = document.createElement('span');
                            removeBtn.innerHTML = `<i class="fa-solid fa-circle-xmark text-danger"></i>`;
                            removeBtn.classList.add('position-absolute', 'top-0', 'end-0', 'p-1', 'cursor-pointer');
                            removeBtn.addEventListener('click', () => imgContainer.remove());

                            imgContainer.appendChild(img);
                            imgContainer.appendChild(removeBtn);
                            previewWrapper.appendChild(imgContainer);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });
        });


        // CKEditor full-featured editors
        function createEditor(selector, toolbarContainer) {
            DecoupledEditor.create(document.querySelector(selector), {
                toolbar: {
                    items: [
                        'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                        'link', 'bulletedList', 'numberedList', 'todoList', '|', 'alignment', '|',
                        'indent', 'outdent', '|', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        'undo', 'redo', '|', 'fontColor', 'fontBackgroundColor', 'fontSize', 'fontFamily'
                    ]
                }
            }).then(editor => {
                const toolbarContainerEl = document.querySelector(toolbarContainer);
                toolbarContainerEl.appendChild(editor.ui.view.toolbar.element);
            }).catch(error => console.error(error));
        }

        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => console.error(error));

        ClassicEditor
            .create(document.querySelector('#short_description'))
            .catch(error => console.error(error));

        ClassicEditor
            .create(document.querySelector('#care_instructions'))
            .catch(error => console.error(error));
    </script>

@endpush

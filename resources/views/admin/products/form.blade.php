<div class="card shadow-sm p-4">
    {{-- <h4 class="mb-3">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h4> --}}
    {{-- <h4 class="mb-3">{{ $product->exists ? 'Edit Product' : 'Add Product' }}</h4> --}}

    <h4 class="mb-3">{{ isset($product) && $product->exists ? 'Edit Product' : 'Add Product' }}</h4>


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


    {{-- Variants --}}
    @php
        $oldVariants = old('variants', $product->variants ?? []);
    @endphp

    <div id="variants-wrapper">
        @foreach ($oldVariants as $index => $variant)
            <div class="variant-item border rounded p-3 mb-3 position-relative">
                <a href="javascript:void(0);" class="btn-action btn-sm remove-variant position-absolute top-0 end-0 m-2">
                    <i class="fa-solid fa-circle-xmark text-danger"></i>
                </a>
                <div class="row g-2">
                    <input type="hidden" name="variants[{{ $index }}][id]"
                        value="{{ $variant['id'] ?? $variant->id ?? '' }}">

                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Product Code</label>
                        <input type="text" name="variants[{{ $index }}][product_code]" class="form-control"
                            value="{{ $variant['product_code'] ?? $variant->product_code ?? '' }}">
                        @error("variants.$index.product_code")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">MOQ</label>
                        <input type="number" name="variants[{{ $index }}][moq]" class="form-control"
                            value="{{ $variant['moq'] ?? $variant->moq ?? '' }}">
                        @error("variants.$index.moq")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">GSM</label>
                        <input type="text" name="variants[{{ $index }}][gsm]" class="form-control"
                            value="{{ $variant['gsm'] ?? $variant->gsm ?? '' }}">
                        @error("variants.$index.gsm")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Dai</label>
                        <input type="text" name="variants[{{ $index }}][dai]" class="form-control"
                            value="{{ $variant['dai'] ?? $variant->dai ?? '' }}">
                        @error("variants.$index.dai")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Chadti</label>
                        <input type="text" name="variants[{{ $index }}][chadti]" class="form-control"
                            value="{{ $variant['chadti'] ?? $variant->chadti ?? '' }}">
                        @error("variants.$index.chadti")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="col-md-6 col-lg-4">
                        @php
                            $colors = [];

                            if (is_array($variant)) {
                                // When $variant is from old() input
                                $colors = !empty($variant['color']) ? json_decode($variant['color'], true) ?? [] : [];
                            } elseif (isset($variant->color)) {
                                // When $variant is a model instance
                                $colors = !empty($variant->color) ? json_decode($variant->color, true) ?? [] : [];
                            }
                        @endphp


                        <label class="form-label">Colors</label>
                        <div class="multi-color-picker border rounded p-2" data-variant-index="{{ $index }}">
                            <div class="d-flex flex-wrap gap-2 mb-2 selected-colors">
                                @foreach($colors as $color)
                                    <div class="position-relative" data-color="{{ $color }}">
                                        <div class="rounded-circle border"
                                            style="width:30px; height:30px; background-color: {{ $color }}; cursor:pointer;">
                                        </div>
                                        <span
                                            class="position-absolute top-0 end-0 translate-middle badge bg-danger remove-color"
                                            style="cursor:pointer;">×</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color add-color-picker"
                                    title="Pick color">
                                <button type="button" class="btn btn-sm btn-outline-primary add-color-btn">Add
                                    Color</button>
                            </div>

                            <!-- Hidden input to store colors as comma-separated for submission -->
                            <input type="hidden" name="variants[{{ $index }}][color]" class="color-values"
                                value="{{ implode(',', $colors) }}">
                        </div>
                    </div>




                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">Images</label>
                        <input type="file" name="variants[{{ $index }}][images][]" class="form-control variant-images"
                            multiple>


                        @error("variants.$index.images")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @foreach($errors->get("variants.$index.images.*") as $variantImageErrors)
                            @foreach($variantImageErrors as $error)
                                <small class="text-danger">{{ $error }}</small>
                            @endforeach
                        @endforeach
                        <div class="mt-2 preview-wrapper d-flex flex-wrap gap-1">
                            @php
                                $variantImages = [];
                                if (is_array($variant)) {
                                    $variantImages = $variant['images'] ?? '[]';
                                } else {
                                    $variantImages = $variant->images ?? '[]';
                                }

                                $variantImages = json_decode($variantImages, true) ?? [];
                            @endphp

                            @foreach($variantImages as $img)
                                <div class="position-relative d-inline-block me-1 mb-1">
                                    <img src="{{ asset($img) }}" width="80" height="80" class="rounded border" 
                                         onerror="this.onerror=null;this.src='{{ asset('images/cf-logo-1.png') }}';">
                                    <span class="position-absolute top-0 end-0 p-1 cursor-pointer remove-old-image">
                                        <i class="fa-solid fa-circle-xmark text-danger"></i>
                                    </span>
                                    <input type="hidden" value="{{ $img }}">
                                </div>
                            @endforeach
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

    {{-- <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success">
            {{ isset($product) ? 'Update Product' : 'Create Product' }}
        </button>
    </div> --}}

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success">
            {{ $product->exists ? 'Update Product' : 'Create Product' }}
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




        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('variants-wrapper');
            const addBtn = document.getElementById('add-variant');


            // function addVariant(defaultData = {}) {
            //     const index = wrapper.querySelectorAll('.variant-item').length;
            //     const html = `
            //             <div class="variant-item border rounded p-3 mb-3 position-relative">
            //                 <a href="javascript:void(0);" class="btn-action btn-sm remove-variant position-absolute top-0 end-0 m-2">
            //                     <i class="fa-solid fa-circle-xmark text-danger"></i>
            //                 </a>
            //                 <div class="row g-2">
            //                     <div class="col-md-6 col-lg-4">
            //                         <label class="form-label">Product Code</label>
            //                         <input type="text" name="variants[${index}][product_code]" class="form-control"
            //                             value="${defaultData.product_code || ''}">
            //                     </div>
            //                     <div class="col-md-6 col-lg-4">
            //                         <label class="form-label">MOQ</label>
            //                         <input type="number" name="variants[${index}][moq]" class="form-control"
            //                             value="${defaultData.moq || ''}">
            //                     </div>
            //                     <div class="col-md-6 col-lg-4">
            //                         <label class="form-label">Colors</label>
            //                         <div class="multi-color-picker border rounded p-2" data-variant-index="${index}">
            //                             <div class="d-flex flex-wrap gap-2 mb-2 selected-colors"></div>
            //                             <div class="d-flex align-items-center gap-2">
            //                                 <input type="color" class="form-control form-control-color add-color-picker" title="Pick color">
            //                                 <button type="button" class="btn btn-sm btn-outline-primary add-color-btn">Add Color</button>
            //                             </div>
            //                             <input type="hidden" name="variants[${index}][color]" class="color-values" value="">
            //                         </div>
            //                     </div>
            //                     <div class="col-md-6 col-lg-4">
            //                         <label class="form-label">Images</label>
            //                         <input type="file" name="variants[${index}][images][]" class="form-control variant-images" multiple>
            //                         <div class="mt-2 preview-wrapper"></div>
            //                         <input type="hidden" name="variants[${index}][removed_images]" class="removed-images" value="">
            //                     </div>
            //                 </div>
            //             </div>`;
            //     wrapper.insertAdjacentHTML('beforeend', html);
            // }

            function addVariant(defaultData = {}) {
                const index = wrapper.querySelectorAll('.variant-item').length;
                const html = `
                        <div class="variant-item border rounded p-3 mb-3 position-relative">
                            <a href="javascript:void(0);" class="btn-action btn-sm remove-variant position-absolute top-0 end-0 m-2">
                                <i class="fa-solid fa-circle-xmark text-danger"></i>
                            </a>
                            <div class="row g-2">
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">Product Code</label>
                                    <input type="text" name="variants[${index}][product_code]" class="form-control"
                                        value="${defaultData.product_code || ''}">
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">MOQ</label>
                                    <input type="number" name="variants[${index}][moq]" class="form-control"
                                        value="${defaultData.moq || ''}">
                                </div>

                                <!-- New fields -->
                                <div class="col-md-4">
                                    <label class="form-label">GSM</label>
                                    <input type="text" name="variants[${index}][gsm]" class="form-control"
                                        value="${defaultData.gsm || ''}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Dai</label>
                                    <input type="text" name="variants[${index}][dai]" class="form-control"
                                        value="${defaultData.dai || ''}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Chadti</label>
                                    <input type="text" name="variants[${index}][chadti]" class="form-control"
                                        value="${defaultData.chadti || ''}">
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">Colors</label>
                                    <div class="multi-color-picker border rounded p-2" data-variant-index="${index}">
                                        <div class="d-flex flex-wrap gap-2 mb-2 selected-colors"></div>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="color" class="form-control form-control-color add-color-picker" title="Pick color">
                                            <button type="button" class="btn btn-sm btn-outline-primary add-color-btn">Add Color</button>
                                        </div>
                                        <input type="hidden" name="variants[${index}][color]" class="color-values" value="">
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">Images</label>
                                    <input type="file" name="variants[${index}][images][]" class="form-control variant-images" multiple>
                                    <div class="mt-2 preview-wrapper"></div>
                                    <input type="hidden" name="variants[${index}][removed_images]" class="removed-images" value="">
                                </div>
                            </div>
                        </div>`;
                wrapper.insertAdjacentHTML('beforeend', html);
            }



            //  Default: Add one variant automatically
            // addVariant();
            // Only add default variant if no variants exist
            if (!document.querySelectorAll('#variants-wrapper .variant-item').length) {
                addVariant();
            }


            //  Add on button click
            addBtn.addEventListener('click', addVariant);

            //  Remove variant
            wrapper.addEventListener('click', function (e) {
                if (e.target.closest('.remove-variant')) {
                    const item = e.target.closest('.variant-item');
                    if (item) item.remove();
                }
            });

            //  Remove old images
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

            //  Preview new images
            wrapper.addEventListener('change', function (e) {
                if (e.target.classList.contains('variant-images')) {
                    const previewWrapper = e.target.closest('.col-md-4').querySelector('.preview-wrapper');
                    if (!previewWrapper) return;

                    previewWrapper.innerHTML = '';
                    Array.from(e.target.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            const imgContainer = document.createElement('div');
                            imgContainer.classList.add('position-relative', 'd-inline-block', 'me-2', 'mb-2');
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.width = 100;
                            img.height = 100;
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




        document.addEventListener('DOMContentLoaded', function () {
            function initMultiColorPickers() {
                document.querySelectorAll('.multi-color-picker').forEach(wrapper => {
                    if (wrapper.dataset.initialized === "true") return;
                    wrapper.dataset.initialized = "true";

                    const colorInput = wrapper.querySelector('.add-color-picker');
                    const addBtn = wrapper.querySelector('.add-color-btn');
                    const selectedWrapper = wrapper.querySelector('.selected-colors');
                    const hiddenInput = wrapper.querySelector('.color-values');

                    // Clear any accidental duplicates (avoid merging from others)
                    selectedWrapper.innerHTML = '';

                    // Load existing colors for this variant only
                    const existing = hiddenInput.value ? hiddenInput.value.split(',') : [];
                    existing.forEach(color => {
                        if (color.trim()) addColorBox(color.trim());
                    });

                    function addColorBox(color) {
                        const box = document.createElement('div');
                        box.className = 'position-relative';
                        box.dataset.color = color;
                        box.innerHTML = `
                                                    <div class="rounded-circle border"
                                                         style="width:30px; height:30px; background:${color}; cursor:pointer;"></div>
                                                    <span class="position-absolute top-0 end-0 translate-middle badge bg-danger remove-color"
                                                          style="cursor:pointer;">×</span>
                                                `;
                        selectedWrapper.appendChild(box);
                        updateHiddenInput();
                    }

                    function updateHiddenInput() {
                        const colors = Array.from(selectedWrapper.querySelectorAll('[data-color]'))
                            .map(el => el.dataset.color);
                        hiddenInput.value = colors.join(',');
                    }

                    // Add color
                    addBtn.addEventListener('click', function () {
                        const color = colorInput.value;
                        const currentColors = hiddenInput.value ? hiddenInput.value.split(',') : [];
                        if (color && !currentColors.includes(color)) {
                            addColorBox(color);
                        }
                    });

                    // Remove color
                    selectedWrapper.addEventListener('click', function (e) {
                        if (e.target.classList.contains('remove-color')) {
                            const box = e.target.closest('[data-color]');
                            if (box) box.remove();
                            updateHiddenInput();
                        }
                    });
                });
            }

            // Initialize all pickers once
            initMultiColorPickers();

            // Reinitialize if new variant is dynamically added
            const addVariantBtn = document.getElementById('add-variant');
            if (addVariantBtn) {
                addVariantBtn.addEventListener('click', function () {
                    setTimeout(initMultiColorPickers, 300);
                });
            }
        });



    </script>

@endpush

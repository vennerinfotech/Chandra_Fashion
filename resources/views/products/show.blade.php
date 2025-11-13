@extends('layouts.app')

@section('title', $product->name . ' - Product Details')

@section('content')
    <div class="product-detail-wrapper top-section-padding">
        <div class="container">
            <div class="row g-4">

                {{-- Display Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Left Side: Product Image & Thumbnails --}}
                <div class="col-md-6">
                    <div class="product-detail-left">
                        <div class="left-img zoom-container">
                            @php
                                $firstVariant = $product->variants->first();
                                $mainImage = $firstVariant
                                    ? (is_array($firstVariant->images)
                                        ? $firstVariant->images[0]
                                        : json_decode($firstVariant->images, true)[0])
                                    : $product->image_url;
                            @endphp

                            <img src="{{ asset('images/variants/' . basename($colorImages[$colors[0]][0])) }}"
                                id="mainProductImage" class="img-fluid selectable-image"
                                data-image="{{ asset('images/variants/' . basename($colorImages[$colors[0]][0])) }}">

                        </div>

                        <div id="colorGallery" class="img-thumbnail-main">
                            @foreach ($colorImages[$colors[0]] as $img)

                                <img src="{{ asset('images/variants/' . basename($img)) }}"
                                    class="img-thumbnail selectable-image"
                                    data-image="{{ asset('images/variants/' . basename($img)) }}">
                            @endforeach
                        </div>
                        <div class="badge-top d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-danger">New</span>
                            <span class="badge bg-warning">Best Seller</span>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Product Info --}}
                <div class="col-md-6">
                    <div class="product-detail-right">
                        <h2 class="product-title">{{ $product->name }}</h2>
                        <h6 class="product-price"> ₹{{ $product->price }}</h6>
                        <p class="product-desc">{!! $product->short_description ?? 'No short description available.' !!}</p>

                        <div class="sku-category">
                            <p>SKU: <span id="productSKU">{{ $product->variants->first()->product_code ?? 'N/A' }}</span>
                            </p>
                            <p>Category: <span>{{ $product->category->name ?? 'N/A' }}</span></p>
                            <p>Subcategory: <span>{{ $product->subcategory->name ?? 'N/A' }}</span></p>
                        </div>


                        {{-- Fabric & Materials --}}
                        <div class="fabric">
                            <h6 class="">Fabric & Materials:</h6>
                            <div class="row mt-2">
                                <div class="col-md-12 d-flex flex-column gap-2">
                                    <span>{{ $product->materials }}</span>
                                    {{-- <span>Breathable Weave</span> --}}
                                </div>

                            </div>
                        </div>


                        {{-- Available Colors --}}
                        <div class="color-variation mt-3">
                            {{-- <h6>Available Colors</h6> --}}
                            <div class="color d-flex flex-wrap gap-2">
                                @php
                                    $variant = $product->variants->first();
                                    $colorArray = [];

                                    if ($variant && !empty($variant->color)) {
                                        $decoded = json_decode($variant->color, true);
                                        if (is_array($decoded) && count($decoded) > 0) {
                                            $colorArray = $decoded;
                                        }
                                    }
                                @endphp

                                @if (!empty($colorArray))
                                    <div class="color-variation mt-3">
                                        <h6>Available Colors</h6>
                                        <div class="color d-flex flex-wrap gap-2">
                                            @foreach ($colorArray as $index => $color)
                                                <button class="btn border color-btn {{ $index === 0 ? 'selected' : '' }}"
                                                    data-color="{{ $color }}"
                                                    style="background-color: {{ $color }}; width: 32px; height: 32px; border-radius: 50%;"
                                                    title="{{ $color }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>



                        {{-- Available Colors --}}
                        {{-- <input type="hidden" name="selected_size" id="selected_size">
                        @if (!empty($colorArray))
                        <div class="color-variation mt-3">
                            <h6>Available Colors</h6>
                            <div class="color d-flex flex-wrap gap-2">
                                @foreach ($colorArray as $index => $color)
                                <button type="button" class="btn border color-btn {{ $index === 0 ? 'selected' : '' }}"
                                    data-color="{{ $color }}"
                                    style="background-color: {{ $color }}; width: 32px; height: 32px; border-radius: 50%;"
                                    title="{{ $color }}">
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif --}}

                        <div class="moq">
                            <div class="moq-order">
                                <h4 id="moqValue">{{ $product->variants->first()->moq }}</h4>
                                <p>Minimum Order Qty (KG)</p>
                            </div>
                            <div class="moq-delivery">
                                <h4 id="deliveryValue">{{ $product->delivery_time }}</h4>
                                <p>Days Delivery</p>
                            </div>
                        </div>

                        <a href="#" class="btn btn-price" data-bs-toggle="modal" data-bs-target="#inquiryModal"
                            data-product="{{ $product->id }}">
                            <i class="bi bi-cart-check"></i> Get a Quote
                        </a>
                    </div>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="inquiryModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Product Inquiry</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="inquiryForm" method="POST" action="{{ route('inquiries.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" id="product_id">
                                <input type="hidden" name="selected_size" id="selected_size">
                                <input type="hidden" name="selected_images" id="selected_images">
                                <input type="hidden" name="variant_details" id="variant_details">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Company</label>
                                            <input type="text" name="company" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Country</label>
                                            <select name="country_id" id="country" class="form-select" required>
                                                <option value="">Select your country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <select name="state_id" id="state" class="form-select" required disabled>
                                                <option value="">Select your state</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <select name="city_id" id="city" class="form-select" required disabled>
                                                <option value="">Select your city</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Quantity Interested (KG)</label>
                                            <input type="number" name="quantity" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- <button type="submit" class="btn w-100">Submit to Check Price</button> --}}
                                <button type="submit" class="btn w-100" id="inquirySubmitBtn">Submit to Check Price</button>

                                <!-- Loader -->
                                <div id="formLoader" style="display:none; text-align:center; margin-top:10px;">
                                    <img src="{{ asset('images/loading.gif') }}" alt="Loading..." style="width:50px;">
                                    <p>Submitting your inquiry, please wait...</p>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>



            {{-- Tabs: Specifications, Certifications, Care Instructions --}}
            <div class="product-description">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="desc-tab" data-bs-toggle="tab" href="#desc"
                            role="tab">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="care-tab" data-bs-toggle="tab" href="#care" role="tab">Care Instructions</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    {{-- Product Description --}}
                    <div class="tab-pane fade show active" id="desc" role="tabpanel">
                        <div class="col-12">
                            {!! $product->description ?? '<p>No description available.</p>' !!}
                        </div>
                    </div>

                    {{-- Care Instructions --}}
                    <div class="tab-pane fade" id="care" role="tabpanel">
                        <div class="col-12">
                            {!! $product->care_instructions ?? '<p>No care instructions available.</p>' !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="additional-info">
                <div class="row">
                    <h2 class="section-title">Why Choose Chandra Fashion</h2>
                    <p class="section-sub-title">Trusted by leading brands worldwide for premium quality and sustainable
                        manufacturing</p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon bg-green">
                                <img src="{{ asset('/images/vector.svg') }}" alt="vector" class="img-fluid">
                            </div>
                            <div class="feature-title">Sustainable Manufacturing</div>
                            <p>GOTS certified organic materials and eco-friendly processes</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon bg-blue">
                                <img src="{{ asset('/images/vector(1).svg') }}" alt="vector" class="img-fluid">
                            </div>
                            <div class="feature-title">Quality Certified</div>
                            <p>ISO 9001:2015 and OEKO-TEX Standard 100 certified</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon bg-purple">
                                <img src="{{ asset('/images/vector(2).svg') }}" alt="vector" class="img-fluid">
                            </div>
                            <div class="feature-title">Global Export</div>
                            <p>Serving 50+ countries with reliable shipping</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-related-product">
                <div class="row">
                    <h2 class="section-title">Related Products</h2>
                    <div class="custom-owl-carousel owl-carousel new-arrival-carousel">

                        @foreach ($relatedProducts as $rProduct)
                            <div class="new-arrival-box card">
                                <div class="new-arrival-box-img">
                                    @php
                                        $firstImage = $rProduct->variants->first()?->images;
                                        $firstImage = is_array($firstImage)
                                            ? $firstImage[0] ?? '/images/product2.jpg'
                                            : json_decode($firstImage, true)[0] ?? '/images/product2.jpg';
                                    @endphp
                                    <img src="{{ asset($firstImage) }}" alt="{{ $rProduct->name }}" class="img-fluid">
                                </div>
                                <div class="arrival-list">
                                    <p>{{ $rProduct->is_featured ? 'FEATURED' : 'TRENDING' }}</p>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $rProduct->name }}</h5>
                                    <p class="card-text">
                                        {!! $product->short_description ?? 'No short description available.' !!}
                                    </p>
                                    <div class="material-list">
                                        <small class="badge-material">{{ $rProduct->materials }}</small>
                                        <small class="badge-moq">MOQ: {{ $rProduct->moq ?? 50 }}</small>
                                    </div>
                                    <a href="{{ route('products.show', $rProduct->id) }}" class="btn">Check Price</a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(".new-arrival-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 1500,
                autoplayHoverPause: true,
                navText: [
                    '<i class="fa-solid fa-chevron-left"></i>',
                    '<i class="fa-solid fa-chevron-right"></i>'
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    992: {
                        items: 3
                    },
                    1150: {
                        items: 4
                    }
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            var inquiryModal = document.getElementById('inquiryModal');
            inquiryModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var productId = button.getAttribute('data-product');
                var inputProduct = inquiryModal.querySelector('#product_id');
                inputProduct.value = productId;
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const colorButtons = document.querySelectorAll('.color-circle');
            const mainImage = document.getElementById('mainProductImage');
            const gallery = document.getElementById('colorGallery');
            const sizeContainer = document.getElementById('sizeContainer');

            const selectedSizeInput = document.getElementById('selected_size');
            const selectedImagesInput = document.getElementById('selected_images');
            const variantDetailsInput = document.getElementById('variant_details');

            // Current selection
            let currentSelection = {
                size: null,
                image: null, // only main image
                variant: {}
            };

            function updateHiddenInputs() {
                if (!currentSelection.size || !currentSelection.image || !currentSelection.variant) return;

                // Ensure variant object always has correct values
                currentSelection.variant.size = [currentSelection.size];
                currentSelection.variant.images = [currentSelection.image];

                selectedSizeInput.value = currentSelection.size;
                selectedImagesInput.value = JSON.stringify([currentSelection.image]);
                variantDetailsInput.value = JSON.stringify(currentSelection.variant);

                console.log("Saving:", {
                    size: selectedSizeInput.value,
                    images: selectedImagesInput.value,
                    variant: variantDetailsInput.value
                });
            }

            // Gallery image click
            gallery.addEventListener('click', (e) => {
                if (e.target.tagName === 'IMG') {
                    const newImage = e.target.dataset.image;
                    mainImage.src = newImage;
                    currentSelection.image = newImage;
                    updateHiddenInputs();
                }
            });

            // Size button click
            // sizeContainer.addEventListener('click', (e) => {
            //     if (e.target.tagName === 'BUTTON') {
            //         sizeContainer.querySelectorAll('button').forEach(b => b.classList.remove('selected'));
            //         e.target.classList.add('selected');

            //         currentSelection.size = e.target.textContent.trim();
            //         updateHiddenInputs();
            //     }
            // });


            function selectColor(colorBtn) {
                const color = colorBtn.dataset.color;
                const images = JSON.parse(colorBtn.dataset.images);
                const sizes = JSON.parse(colorBtn.dataset.sizes || "[]");
                const productCode = colorBtn.dataset.code;
                const moq = parseInt(colorBtn.dataset.moq || 1);

                // Highlight selected color
                colorButtons.forEach(c => c.classList.remove('selected'));
                colorBtn.classList.add('selected');

                //  Set main image (relative path only)
                let firstImg = '/images/variants/' + images[0].split('/').pop();
                mainImage.src = firstImg;
                currentSelection.image = firstImg;

                // Update gallery
                gallery.innerHTML = '';
                images.forEach(img => {
                    let relPath = '/images/variants/' + img.split('/').pop();
                    const imgTag = document.createElement('img');
                    imgTag.src = relPath;
                    // imgTag.className = 'img-thumbnail gallery-thumb zoomable';
                    imgTag.dataset.full = relPath;
                    gallery.appendChild(imgTag);

                    imgTag.addEventListener('click', () => {
                        mainImage.src = relPath;
                        currentSelection.image = relPath;
                        if (currentSelection.size) {
                            currentSelection.variant = {
                                product_code: productCode,
                                color: color,
                                size: [currentSelection.size],
                                min_order_qty: moq,
                                images: [relPath]
                            };
                        }
                        updateHiddenInputs();
                    });
                });

                // Update sizes
                sizeContainer.innerHTML = '';
                if (sizes.length === 0) {
                    sizeContainer.innerHTML = '<p class="text-muted">No sizes available</p>';
                    currentSelection.size = null;
                    currentSelection.variant = {};
                    updateHiddenInputs();
                    return;
                }

                sizes.forEach((sizeString, i) => {
                    sizeString.split(',').forEach((size, j) => {
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-sm btn-outline-primary m-1';
                        btn.textContent = size.trim().toUpperCase();

                        // Select first size by default
                        if (i === 0 && j === 0) {
                            btn.classList.add('selected');
                            currentSelection.size = size.trim();
                            currentSelection.variant = {
                                product_code: productCode,
                                color: color,
                                size: [size.trim()],
                                min_order_qty: moq,
                                images: [firstImg]
                            };
                            updateHiddenInputs();
                        }

                        btn.addEventListener('click', () => {
                            sizeContainer.querySelectorAll('button').forEach(b => b
                                .classList.remove('selected'));
                            btn.classList.add('selected');

                            currentSelection.size = size.trim();
                            currentSelection.variant = {
                                product_code: productCode,
                                color: color,
                                size: [size.trim()],
                                min_order_qty: moq,
                                images: [currentSelection.image]
                            };
                            updateHiddenInputs();
                        });

                        sizeContainer.appendChild(btn);
                    });
                });

                updateHiddenInputs();
            }

            // Auto-select first color
            if (colorButtons.length > 0) {
                selectColor(colorButtons[0]);
            }

            const inquiryForm = document.getElementById('inquiryForm');
            if (inquiryForm) {
                inquiryForm.addEventListener('submit', function () {
                    updateHiddenInputs();
                });
            }

            colorButtons.forEach(btn => {
                btn.addEventListener('click', () => selectColor(btn));
            });
        });




        document.addEventListener("DOMContentLoaded", function () {
            const colorButtons = document.querySelectorAll(".color-btn");
            const mainImage = document.querySelector(".col-md-6 img");
            const relatedDiv = document.getElementById("relatedProducts");

            colorButtons.forEach(btn => {
                btn.addEventListener("click", function () {
                    const selectedColor = btn.getAttribute("data-color");

                    // Update main image based on color
                    fetch(`/products/color/${selectedColor}/{{ $product->id }}`)
                        .then(res => res.json())
                        .then(data => {
                            mainImage.src = data.main_image;

                            // Update related products
                            relatedDiv.innerHTML = '';
                            data.related.forEach(p => {
                                const gallery = JSON.parse(p.gallery);
                                relatedDiv.innerHTML += `
                                                                                                            <div class="card" style="width:120px;">
                                                                                                                <img src="${gallery[0]}" class="card-img-top" style="height:100px; object-fit:cover;">
                                                                                                                <div class="card-body p-2 text-center">
                                                                                                                    <small>${p.name}</small>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        `;
                            });
                        });
                });
            });
        });

        // img zoom script
        document.addEventListener("DOMContentLoaded", function () {
            const mainImage = document.getElementById('mainProductImage');
            const thumbnails = document.querySelectorAll('.gallery-thumb');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function () {
                    const newSrc = this.getAttribute('data-full');
                    mainImage.src = newSrc;
                });
            });

            // Zoom effect
            const container = document.querySelector(".zoom-container");

            container.addEventListener("mousemove", function (e) {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const xPercent = (x / rect.width) * 100;
                const yPercent = (y / rect.height) * 100;

                mainImage.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                mainImage.style.transform = "scale(2)";
            });

            container.addEventListener("mouseleave", function () {
                mainImage.style.transform = "scale(1)";
                mainImage.style.transformOrigin = "center center";
            });
        });

        // color click changes img
        document.addEventListener("DOMContentLoaded", function () {
            const mainImage = document.getElementById('mainProductImage');
            const gallery = document.getElementById('colorGallery');
            const sizeContainer = document.getElementById('sizeContainer');
            const skuElement = document.getElementById('productSKU');

            const sizesByColor = @json($sizesByColor);
            const skuByColor = @json($skuByColor);

            // Color buttons
            document.querySelectorAll('.color-circle').forEach(circle => {
                circle.addEventListener('click', function () {
                    const color = this.dataset.color;
                    const images = JSON.parse(this.dataset.images);

                    // Remove selected from all colors
                    document.querySelectorAll('.color-circle').forEach(c => c.classList.remove(
                        'selected'));
                    // Add selected to clicked color
                    this.classList.add('selected');

                    // Update main image
                    mainImage.src = '/images/variants/' + images[0].split('/').pop();

                    // Update gallery thumbnails
                    gallery.innerHTML = '';
                    images.forEach(img => {
                        const imgTag = document.createElement('img');
                        imgTag.src = '/images/variants/' + img.split('/').pop();
                        // imgTag.className = 'img-thumbnail gallery-thumb zoomable';
                        imgTag.style =
                            'width:90px; height:90px; object-fit:cover; cursor:pointer;';
                        imgTag.dataset.full = '/images/variants/' + img.split('/').pop();
                        gallery.appendChild(imgTag);

                        imgTag.addEventListener('click', () => {
                            mainImage.src = imgTag.dataset.full;
                        });
                    });

                    // Update sizes dynamically
                    sizeContainer.innerHTML = '';
                    (sizesByColor[color] || []).forEach((sizeString, i) => {
                        sizeString.split(',').forEach((singleSize, j) => {
                            const btn = document.createElement('button');
                            btn.className = 'btn'; // base class
                            btn.textContent = singleSize.trim().toUpperCase();

                            // Make first size selected
                            if (i === 0 && j === 0) btn.classList.add('selected');

                            // Click to select size
                            btn.addEventListener('click', () => {
                                // Remove selected from all sizes
                                sizeContainer.querySelectorAll('.btn')
                                    .forEach(b => b.classList.remove(
                                        'selected'));
                                btn.classList.add('selected');
                            });

                            sizeContainer.appendChild(btn);
                        });
                    });

                    // Update SKU
                    skuElement.textContent = skuByColor[color] ?? 'N/A';
                });
            });

            // Optional: handle size selection on initial page load
            // sizeContainer.querySelectorAll('.btn').forEach(btn => {
            //     btn.addEventListener('click', () => {
            //         sizeContainer.querySelectorAll('.btn').forEach(b => b.classList.remove(
            //             'selected'));
            //         btn.classList.add('selected');
            //     });
            // });
        });


        const moqByColor = @json($moqByColor);
        const deliveryByColor = @json($deliveryByColor);

        document.querySelectorAll('.color-circle').forEach(circle => {
            circle.addEventListener('click', function () {
                const color = this.dataset.color;

                // Existing updates (images, gallery, sizes, SKU)...

                // Update MOQ & Delivery dynamically
                const moqElement = document.getElementById('moqValue');
                const deliveryElement = document.getElementById('deliveryValue');

                moqElement.textContent = moqByColor[color] ?? '{{ $product->moq ?? '100' }}';
                deliveryElement.textContent = deliveryByColor[color] ??
                    '{{ $product->delivery_time ?? '15-20' }}';
            });
        });


        document.addEventListener("DOMContentLoaded", function () {

            // Store selections
            let selectedSizes = [];
            let selectedImages = [];
            let variantDetails = [];

            // Example: user clicks on a variant color box
            const variantBoxes = document.querySelectorAll('.variant-box'); // add class to your variant options
            variantBoxes.forEach(box => {
                box.addEventListener('click', function () {
                    const color = this.dataset.color;
                    const sizeOptions = JSON.parse(this.dataset.sizes); // array of available sizes
                    const images = JSON.parse(this.dataset.images); // array of image URLs
                    const productCode = this.dataset.code;
                    const minOrderQty = this.dataset.moq;

                    // Example: select a size from size options
                    const size = prompt(
                        `Available sizes: ${sizeOptions.join(', ')}\nEnter your size:`);

                    if (!size || !sizeOptions.includes(size)) {
                        alert('Invalid size selected!');
                        return;
                    }

                    // Add to selection arrays
                    selectedSizes.push(size);
                    selectedImages.push(images[0]); // choose first image for this variant
                    variantDetails.push({
                        product_code: productCode,
                        color: color,
                        size: [size],
                        min_order_qty: parseInt(minOrderQty),
                        images: images
                    });

                    // Update hidden inputs
                    document.getElementById('selected_size').value = JSON.stringify(selectedSizes);
                    document.getElementById('selected_images').value = JSON.stringify(
                        selectedImages);
                    document.getElementById('variant_details').value = JSON.stringify(
                        variantDetails);

                    alert(`Selected ${color} - ${size}`);
                });
            });

        });




        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.getElementById('country');
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');

            const DEFAULT_COUNTRY = "India"; // country name to pre-select

            //  Set default country to India
            for (let option of countrySelect.options) {
                if (option.text === DEFAULT_COUNTRY) {
                    option.selected = true;
                    break;
                }
            }

            //  Function to load states
            function loadStates(countryId) {
                if (!countryId) return;
                stateSelect.disabled = false;
                stateSelect.innerHTML = '<option value="">Loading states...</option>';

                fetch(`/states/${countryId}`)
                    .then(res => res.json())
                    .then(data => {
                        stateSelect.innerHTML = '<option value="">Select your state</option>';
                        data.forEach(state => {
                            const option = document.createElement('option');
                            option.value = state.id;
                            option.textContent = state.name;
                            stateSelect.appendChild(option);
                        });
                        citySelect.disabled = true; // city disabled until state selected
                    })
                    .catch(err => {
                        stateSelect.innerHTML = '<option value="">No states available</option>';
                        console.error(err);
                    });
            }

            // Function to load cities
            function loadCities(stateId) {
                if (!stateId) return;
                citySelect.disabled = false;
                citySelect.innerHTML = '<option value="">Loading cities...</option>';

                fetch(`/cities/${stateId}`)
                    .then(res => res.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">Select your city</option>';
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(err => {
                        citySelect.innerHTML = '<option value="">No cities available</option>';
                        console.error(err);
                    });
            }

            //  Trigger load of India states on page load
            if (countrySelect.value) {
                loadStates(countrySelect.value);
            }

            //  Event listeners
            countrySelect.addEventListener('change', function () {
                loadStates(this.value);
            });

            stateSelect.addEventListener('change', function () {
                loadCities(this.value);
            });
        });



        // apture Selected Images in JavaScript
        document.addEventListener('DOMContentLoaded', function () {
            let selectedImages = [];

            // When user clicks any product image
            document.querySelectorAll('.selectable-image').forEach(img => {
                img.addEventListener('click', function () {
                    let imgPath = this.getAttribute('data-image');

                    if (!selectedImages.includes(imgPath)) {
                        selectedImages.push(imgPath);
                    }

                    // Save into hidden input
                    document.getElementById('selected_images').value = JSON.stringify(
                        selectedImages);
                    console.log("Selected Images:", selectedImages);
                });
            });

            // Before form submit
            document.getElementById('inquiryForm').addEventListener('submit', function () {
                document.getElementById('selected_images').value = JSON.stringify(selectedImages);
            });
        });



        document.addEventListener('DOMContentLoaded', function () {
            const inquiryForm = document.getElementById('inquiryForm');
            const selectedImagesInput = document.getElementById('selected_images');
            const mainImage = document.getElementById('mainProductImage');

            if (!inquiryForm || !mainImage) return;

            // On form submit, store the current main image into hidden input
            inquiryForm.addEventListener('submit', function () {
                const currentMainImage = mainImage.dataset.image || mainImage.src;
                selectedImagesInput.value = JSON.stringify([currentMainImage]); // store as array
                console.log('Storing Main Image to DB:', currentMainImage);
            });

            // Optional: if you want clicking gallery to also update main image visually
            document.getElementById('colorGallery').addEventListener('click', function (e) {
                if (e.target.tagName === 'IMG') {
                    const imgPath = e.target.dataset.image || e.target.src;
                    mainImage.src = imgPath;
                    mainImage.dataset.image = imgPath; // keep dataset updated
                }
            });
        });

        // show a inquiryModal mes
        document.addEventListener('DOMContentLoaded', function () {
            const inquiryForm = document.getElementById('inquiryForm');
            const submitBtn = document.getElementById('inquirySubmitBtn');
            const loader = document.getElementById('formLoader');
            const quantityInput = inquiryForm.querySelector('input[name="quantity"]');
            const moqElement = document.getElementById('moqValue');

            if (!inquiryForm) return;

            inquiryForm.addEventListener('submit', function (e) {
                const enteredQty = parseInt(quantityInput.value);
                const moq = parseInt(moqElement.textContent);

                //  VALIDATION
                if (isNaN(enteredQty)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Quantity',
                        text: 'Please enter a valid number for quantity.',
                    });
                    return;
                }

                if (enteredQty < moq) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Kg Too Low',
                        text: `Minimum order Kg is ${moq}. You entered ${enteredQty}.`,
                    });
                    return;
                }

                //  SUBMISSION LOADER
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }

                // Save hidden inputs before submit
                const mainImage = document.getElementById('mainProductImage');
                const selectedImagesInput = document.getElementById('selected_images');
                if (mainImage && selectedImagesInput) {
                    selectedImagesInput.value = JSON.stringify([mainImage.dataset.image || mainImage.src]);
                }

                submitBtn.disabled = true;
                submitBtn.innerText = "Submitting...";
                if (loader) loader.style.display = "block";
            });
        });


        // exsting user detalis fatch js
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.querySelector('#inquiryForm input[name="name"]');
            const emailInput = document.querySelector('#inquiryForm input[name="email"]');
            const companyInput = document.querySelector('#inquiryForm input[name="company"]');
            const phoneInput = document.querySelector('#inquiryForm input[name="phone"]');
            const countrySelect = document.querySelector('#inquiryForm select[name="country_id"]');
            const stateSelect = document.querySelector('#inquiryForm select[name="state_id"]');
            const citySelect = document.querySelector('#inquiryForm select[name="city_id"]');
            // const quantityInput = document.querySelector('#inquiryForm input[name="quantity"]');

            function fetchUserDetails() {
                const name = nameInput.value.trim();
                const email = emailInput.value.trim();

                if (!name && !email) return;

                let url = `{{ route('inquiry.userCheck') }}?`;
                if (email) url += `email=${encodeURIComponent(email)}&`;
                if (name) url += `name=${encodeURIComponent(name)}`;

                fetch(url)
                    .then(res => res.json())
                    .then(res => {
                        if (res.exists) {
                            const data = res.data;

                            // Set basic fields
                            if (data.name) nameInput.value = data.name;
                            if (data.email) emailInput.value = data.email; // Fix for email
                            if (data.company) companyInput.value = data.company;
                            if (data.phone) phoneInput.value = data.phone;
                            // if (data.quantity) quantityInput.value = data.quantity; // Fix for quantity

                            // Country -> load states
                            if (data.country_id) {
                                countrySelect.value = data.country_id;
                                countrySelect.dispatchEvent(new Event('change'));
                            }

                            // Wait a little for states to populate, then select state & city
                            setTimeout(() => {
                                if (data.state_id) {
                                    stateSelect.value = data.state_id;
                                    stateSelect.dispatchEvent(new Event('change'));
                                }
                            }, 500);

                            setTimeout(() => {
                                if (data.city_id) {
                                    citySelect.disabled = false; // enable city
                                    citySelect.value = data.city_id;
                                }
                            }, 1000); // wait longer for states -> cities
                        }
                    });
            }

            nameInput.addEventListener('blur', fetchUserDetails);
            emailInput.addEventListener('blur', fetchUserDetails);
        });



        document.addEventListener("DOMContentLoaded", function () {
            const colorButtons = document.querySelectorAll('.color-btn');
            const selectedColorInput = document.getElementById('selected_size');
            const mainImage = document.getElementById('mainProductImage');
            const gallery = document.getElementById('colorGallery');

            // Array to store all selected colors
            let selectedColors = [];

            function toggleColor(btn) {
                const color = btn.dataset.color;

                // Toggle selection
                if (selectedColors.includes(color)) {
                    // Remove from selection
                    selectedColors = selectedColors.filter(c => c !== color);
                    btn.classList.remove('selected');
                } else {
                    // Add to selection
                    selectedColors.push(color);
                    btn.classList.add('selected');
                }

                // Save all selected colors in hidden input as JSON array
                selectedColorInput.value = JSON.stringify(selectedColors);
                console.log("Selected colors stored:", selectedColors);

                // Optional: if you want main image to always show the first selected color
                if (selectedColors.length > 0 && btn.dataset.images) {
                    const firstSelectedBtn = document.querySelector(`.color-btn[data-color="${selectedColors[0]}"]`);
                    if (firstSelectedBtn && firstSelectedBtn.dataset.images) {
                        const images = JSON.parse(firstSelectedBtn.dataset.images);
                        if (images.length > 0) {
                            mainImage.src = '/images/variants/' + images[0].split('/').pop();

                            // Update gallery
                            gallery.innerHTML = '';
                            images.forEach(img => {
                                const imgTag = document.createElement('img');
                                imgTag.src = '/images/variants/' + img.split('/').pop();
                                imgTag.dataset.image = '/images/variants/' + img.split('/').pop();
                                imgTag.className = 'img-thumbnail selectable-image';
                                gallery.appendChild(imgTag);

                                imgTag.addEventListener('click', () => {
                                    mainImage.src = imgTag.dataset.image;
                                });
                            });
                        }
                    }
                }
            }

            // Attach click listeners
            colorButtons.forEach(btn => {
                btn.addEventListener('click', () => toggleColor(btn));
            });
        });



    </script>
@endpush

@extends('layouts.app')

@section('title', $product->name . ' - Product Details')

@section('content')
    <div class="product-detail-wrapper top-section-padding">
        <div class="container">
            <div class="row g-4">
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
                                id="mainProductImage" class="img-fluid">
                        </div>

                        <div id="colorGallery" class="img-thumbnail-main">
                            @foreach ($colorImages[$colors[0]] as $img)
                                <img src="{{ asset('images/variants/' . basename($img)) }}"
                                    class="img-thumbnail gallery-thumb"
                                    data-full="{{ asset('images/variants/' . basename($img)) }}">
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
                        <p class="product-desc">{{ $product->description }}</p>

                        <div class="sku-category">
                            <p class="">SKU: <span
                                    id="productSKU">{{ $product->variants->first()->product_code ?? 'N/A' }}</span></p>

                            <p class="">
                                Category: {{ $product->category->name ?? 'N/A' }}
                            </p>
                        </div>

                        {{-- Fabric & Materials --}}
                        <div class="fabric">
                            <h6 class="">Fabric & Materials</h6>
                            <div class="row mt-2">
                                <div class="col-6 d-flex flex-column gap-2">
                                    <span>🌱 {{ $product->fabric ?? 'Organic Cotton' }}</span>
                                    <span>🌀 Breathable Weave</span>
                                </div>
                                <div class="col-6 d-flex flex-column gap-2">
                                    <span>💧 Moisture Wicking</span>
                                    <span>✨ Wrinkle Resistant</span>
                                </div>
                            </div>
                        </div>

{{-- Available Colors --}}
<div class="color-variation">
    <h6>Available Colors</h6>
    <div class="color" id="colorContainer">
        @foreach($colors as $index => $color)
            @php
                // Keep original CSS classes for design
                $colorClass = match(strtolower($color)) {
                    'red' => 'btn-red',
                    'blue' => 'btn-blue',
                    'green' => 'btn-green',
                    default => 'btn-dark' // fallback
                };
            @endphp
            <button
                class="btn {{ $colorClass }} {{ $index === 0 ? 'selected' : '' }} color-circle"
                data-color="{{ $color }}"
                data-images='@json($colorImages[$color])'
                title="{{ $color }}">
            </button>
        @endforeach
    </div>
</div>



{{-- Available Sizes --}}
<div class="size-variaton">
    <h6 class="">Available Sizes</h6>
    <div class="size" id="sizeContainer">
        @php
            $firstColor = $colors[0] ?? null;
            $initialSizes = $firstColor ? ($sizesByColor[$firstColor] ?? []) : [];
        @endphp

        @if(!empty($initialSizes))
            @foreach($initialSizes as $sizeString)
                @foreach(explode(',', $sizeString) as $size)
                    <button class="btn {{ $loop->first && $loop->parent->first ? 'selected' : '' }}">
                        {{ strtoupper(trim($size)) }}
                    </button>
                @endforeach
            @endforeach
        @else
            <p class="text-muted">No sizes available</p>
        @endif
    </div>
</div>

                        {{-- MOQ & Delivery --}}

                        <div class="moq">
                            <div class="moq-order">
                                <h4 id="moqValue">{{ $product->moq ?? '100' }}</h4>
                                <p>Minimum Order Qty</p>
                            </div>
                            <div class="moq-delivery">
                                <h4 id="deliveryValue">{{ $product->delivery_time ?? '15-20' }}</h4>
                                <p>Days Delivery</p>
                            </div>
                        </div>

                        {{-- <div class="d-flex gap-4 mb-3">
                            <div class="card shadow-sm p-3 text-center">
                                <h4 class="fw-bold">{{ $product->moq ?? '100' }}</h4>
                                <small class="text-muted">Minimum Order Qty</small>
                            </div>
                            <div class="card shadow-sm p-3 text-center">
                                <h4 class="fw-bold">{{ $product->delivery_time ?? '15–20' }}</h4>
                                <small class="text-muted">Days Delivery</small>
                            </div>
                        </div> --}}

                        {{-- CTA Button --}}
                        {{-- <a href="#" class="btn btn-dark w-100 py-3 fw-bold" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                    <i class="bi bi-cart-check"></i> Check Price & Get Quote
                </a> --}}
                        <a href="#" class="btn btn-price" data-bs-toggle="modal" data-bs-target="#inquiryModal"
                            data-product="{{ $product->id }}">
                            <i class="bi bi-cart-check"></i> Check Price & Get Quote
                        </a>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Check Price Inquiry</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="inquiryForm" method="POST" action="{{ route('inquiries.store') }}">
                                @csrf
                                {{-- hidded values product_id --}}
                                <input type="hidden" name="product_id" id="product_id">


                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Company</label>
                                    <input type="text" name="company" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <select name="country" class="form-select" required>
                                        <option value="">Select your country</option>
                                        <option value="India">India</option>
                                        <option value="USA">USA</option>
                                        <option value="UK">UK</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Quantity Interested</label>
                                    <input type="number" name="quantity" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Submit to Check Price</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>



            {{-- Tabs: Specifications, Certifications, Care Instructions --}}
            <div class="product-description">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="specs-tab" data-bs-toggle="tab" href="#specs"
                            role="tab">Specifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cert-tab" data-bs-toggle="tab" href="#cert"
                            role="tab">Certifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="care-tab" data-bs-toggle="tab" href="#care" role="tab">Care
                            Instructions</a>
                    </li>
                </ul>
                <div class="tab-content mt-3">
                    {{-- Specifications --}}
                    <div class="tab-pane fade show active" id="specs" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Technical Specifications</h6>
                                <p>Weight: {{ $product->weight ?? '180 GSM' }}</p>
                                <p>Weave: {{ $product->weave ?? 'Plain Weave' }}</p>
                                <p>Thread Count: {{ $product->thread_count ?? '120x80' }}</p>
                                <p>Shrinkage: {{ $product->shrinkage ?? '<5%' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Construction Details</h6>
                                <p>Collar: {{ $product->collar_type ?? 'Spread Collar' }}</p>
                                <p>Cuff: {{ $product->cuff_style ?? 'Barrel Cuff' }}</p>
                                <p>Buttons: {{ $product->buttons ?? 'Mother of Pearl' }}</p>
                                <p>Fit: {{ $product->fit ?? 'Regular Fit' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Certifications --}}
                    <div class="tab-pane fade" id="cert" role="tabpanel">
                        <p>✔ GOTS Certified</p>
                        <p>✔ OEKO-TEX® Standard 100</p>
                    </div>

                    {{-- Care Instructions --}}
                    <div class="tab-pane fade" id="care" role="tabpanel">
                        <p>Machine wash cold with like colors.</p>
                        <p>Do not bleach. Tumble dry low. Warm iron if needed.</p>
                    </div>
                </div>
            </div>
            <div class="additional-info">
                <div class="row">
                <h2 class="section-title">Why Choose Chandra Fashion</h2>
                <p class="section-sub-title">Trusted by leading brands worldwide for premium quality and sustainable manufacturing</p>
            </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon bg-green">
                               <img src="{{ asset('/images/vector.png') }}" alt="vector" class="img-fluid">
                            </div>
                            <div class="feature-title">Sustainable Manufacturing</div>
                            <p>GOTS certified organic materials and eco-friendly processes</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon bg-blue">
                                <img src="{{ asset('/images/vector (1).png') }}" alt="vector" class="img-fluid">
                            </div>
                            <div class="feature-title">Quality Certified</div>
                            <p>ISO 9001:2015 and OEKO-TEX Standard 100 certified</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-icon bg-purple">
                                <img src="{{ asset('/images/vector (2).png') }}" alt="vector" class="img-fluid">
                            </div>
                            <div class="feature-title">Global Export</div>
                            <p>Serving 50+ countries with reliable shipping</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inquiryModal = document.getElementById('inquiryModal');
            inquiryModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var productId = button.getAttribute('data-product');
                var inputProduct = inquiryModal.querySelector('#product_id');
                inputProduct.value = productId;
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const colorButtons = document.querySelectorAll(".color-btn");
            const mainImage = document.querySelector(".col-md-6 img");
            const relatedDiv = document.getElementById("relatedProducts");

            colorButtons.forEach(btn => {
                btn.addEventListener("click", function() {
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
        document.addEventListener("DOMContentLoaded", function() {
            const mainImage = document.getElementById('mainProductImage');
            const thumbnails = document.querySelectorAll('.gallery-thumb');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const newSrc = this.getAttribute('data-full');
                    mainImage.src = newSrc;
                });
            });

            // Zoom effect
            const container = document.querySelector(".zoom-container");

            container.addEventListener("mousemove", function(e) {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const xPercent = (x / rect.width) * 100;
                const yPercent = (y / rect.height) * 100;

                mainImage.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                mainImage.style.transform = "scale(2)";
            });

            container.addEventListener("mouseleave", function() {
                mainImage.style.transform = "scale(1)";
                mainImage.style.transformOrigin = "center center";
            });
        });

        // color click changes img
        document.addEventListener("DOMContentLoaded", function() {
            const mainImage = document.getElementById('mainProductImage');
            const gallery = document.getElementById('colorGallery');
            const sizeContainer = document.getElementById('sizeContainer');
            const skuElement = document.getElementById('productSKU');

            const sizesByColor = @json($sizesByColor);
            const skuByColor = @json($skuByColor);

            // Color buttons
            document.querySelectorAll('.color-circle').forEach(circle => {
                circle.addEventListener('click', function() {
                    const color = this.dataset.color;
                    const images = JSON.parse(this.dataset.images);

                    // Remove selected from all colors
                    document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
                    // Add selected to clicked color
                    this.classList.add('selected');

                    // Update main image
                    mainImage.src = '/images/variants/' + images[0].split('/').pop();

                    // Update gallery thumbnails
                    gallery.innerHTML = '';
                    images.forEach(img => {
                        const imgTag = document.createElement('img');
                        imgTag.src = '/images/variants/' + img.split('/').pop();
                        imgTag.className = 'img-thumbnail gallery-thumb zoomable';
                        imgTag.style = 'width:90px; height:90px; object-fit:cover; cursor:pointer;';
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
                                sizeContainer.querySelectorAll('.btn').forEach(b => b.classList.remove('selected'));
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
            sizeContainer.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    sizeContainer.querySelectorAll('.btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                });
            });
        });


        const moqByColor = @json($moqByColor);
        const deliveryByColor = @json($deliveryByColor);

        document.querySelectorAll('.color-circle').forEach(circle => {
            circle.addEventListener('click', function() {
                const color = this.dataset.color;

                // Existing updates (images, gallery, sizes, SKU)...

                // Update MOQ & Delivery dynamically
                const moqElement = document.getElementById('moqValue');
                const deliveryElement = document.getElementById('deliveryValue');

                moqElement.textContent = moqByColor[color] ?? '{{ $product->moq ?? "100" }}';
                deliveryElement.textContent = deliveryByColor[color] ?? '{{ $product->delivery_time ?? "15-20" }}';
            });
        });

    </script>
@endpush

@extends('layouts.app')

@section('title', $product->name . ' - Product Details')

@section('content')
<div class="container my-5">
    <div class="row g-4">
        {{-- Left Side: Product Image & Thumbnails --}}
<div class="col-md-6">
    {{-- Main Image --}}
    <div class="mb-3 position-relative overflow-hidden zoom-container">
        @php
            $firstVariant = $product->variants->first();
            $mainImage = $firstVariant
                ? (is_array($firstVariant->images) ? $firstVariant->images[0] : json_decode($firstVariant->images, true)[0])
                : $product->image_url;
        @endphp
        <img src="{{ asset('images/variants/' . basename($colorImages[$colors[0]][0])) }}"
            id="mainProductImage"
            class="img-fluid rounded shadow-sm w-100 zoom-image"
            style="max-height: 450px; object-fit: cover;">
    </div>

    {{-- Gallery Thumbnails --}}
    <div id="colorGallery" class="d-flex gap-2 mt-2 flex-wrap">
        @foreach($colorImages[$colors[0]] as $img)
            <img src="{{ asset('images/variants/' . basename($img)) }}"
                class="img-thumbnail rounded gallery-thumb zoomable"
                style="width:90px; height:90px; object-fit:cover; cursor:pointer;"
                data-full="{{ asset('images/variants/' . basename($img)) }}">
        @endforeach
    </div>

</div>



        {{-- Right Side: Product Info --}}
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-danger">New</span>
                <span class="badge bg-warning text-dark">Best Seller</span>
            </div>

            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->description }}</p>

{{-- SKU --}}
<p class="small text-secondary mb-1">SKU: <span id="productSKU">{{ $product->variants->first()->product_code ?? 'N/A' }}</span></p>


            {{-- Category --}}
            <p class="small text-secondary">
                Category: {{ $product->category->name ?? 'N/A' }}
            </p>

            {{-- Fabric & Materials --}}
            <div class="card shadow-sm p-3 mb-3">
                <h6 class="fw-bold">Fabric & Materials</h6>
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
<div class="mb-3">
    <h6 class="fw-bold">Available Colors</h6>
    @if(!empty($colors))
    <div class="d-flex gap-2 align-items-center" id="colorSelector">
        @foreach($colors as $index => $color)
            <div class="color-circle rounded-circle border"
                style="width:30px; height:30px; background:{{ $color }}; cursor:pointer;"
                data-color="{{ $color }}"
                data-images='@json($colorImages[$color])'
                @if($index === 0) data-default="1" @endif>
            </div>
        @endforeach
    </div>
    @else
        <p class="text-muted">No colors available</p>
    @endif
</div>


{{-- Available Sizes --}}
<div class="mb-3">
    <h6 class="fw-bold">Available Sizes</h6>
    <div class="d-flex gap-2 flex-wrap" id="sizeContainer">
        @if(!empty($sizesByColor[$colors[0]]))
            @foreach(explode(',', $sizesByColor[$colors[0]][0]) as $size)
                <button class="btn btn-outline-dark btn-sm">{{ strtoupper(trim($size)) }}</button>
            @endforeach
        @else
            <p class="text-muted">No sizes available</p>
        @endif
    </div>
</div>







            {{-- MOQ & Delivery --}}
            <div class="d-flex gap-4 mb-3">
                <div class="card shadow-sm p-3 text-center">
                    <h4 class="fw-bold">{{ $product->moq ?? '100' }}</h4>
                    <small class="text-muted">Minimum Order Qty</small>
                </div>
                <div class="card shadow-sm p-3 text-center">
                    <h4 class="fw-bold">{{ $product->delivery_time ?? '15–20' }}</h4>
                    <small class="text-muted">Days Delivery</small>
                </div>
            </div>

            {{-- CTA Button --}}
            {{-- <a href="#" class="btn btn-dark w-100 py-3 fw-bold" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                <i class="bi bi-cart-check"></i> Check Price & Get Quote
            </a> --}}
            <a href="#" class="btn btn-dark w-100 py-3 fw-bold" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-product="{{ $product->id }}">
                <i class="bi bi-cart-check"></i> Check Price & Get Quote
            </a>

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
    <div class="card shadow-sm mt-5 p-4">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="specs-tab" data-bs-toggle="tab" href="#specs" role="tab">Specifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="cert-tab" data-bs-toggle="tab" href="#cert" role="tab">Certifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="care-tab" data-bs-toggle="tab" href="#care" role="tab">Care Instructions</a>
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
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var inquiryModal = document.getElementById('inquiryModal');
    inquiryModal.addEventListener('show.bs.modal', function (event) {
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

    document.querySelectorAll('.color-circle').forEach(circle => {
        circle.addEventListener('click', function () {
            const color = this.dataset.color;
            const images = JSON.parse(this.dataset.images);

            // Update main image
            mainImage.src = '/images/variants/' + images[0].split('/').pop();

            // Update gallery thumbnails
            gallery.innerHTML = '';
            images.forEach(img => {
                const imgTag = document.createElement('img');
                imgTag.src = '/images/variants/' + img.split('/').pop();
                imgTag.className = 'img-thumbnail rounded gallery-thumb zoomable'; // <-- add zoomable class
                imgTag.style = 'width:90px; height:90px; object-fit:cover; cursor:pointer;';
                imgTag.dataset.full = '/images/variants/' + img.split('/').pop();
                gallery.appendChild(imgTag);

                imgTag.addEventListener('click', () => {
                    mainImage.src = imgTag.dataset.full;
                });
            });


            // Update sizes
            sizeContainer.innerHTML = '';
            (sizesByColor[color] || []).forEach(sizeString => {
                sizeString.split(',').forEach(singleSize => {
                    const btn = document.createElement('button');
                    btn.className = 'btn btn-outline-dark btn-sm';
                    btn.textContent = singleSize.trim().toUpperCase();
                    sizeContainer.appendChild(btn);
                });
            });

            // Update SKU
            skuElement.textContent = skuByColor[color] ?? 'N/A';
        });
    });
});




</script>
@endpush

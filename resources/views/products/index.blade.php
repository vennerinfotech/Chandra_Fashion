@extends('layouts.app')

@section('title', 'Chandra Fashion - Manufacturer of Lycra Fabric & Polyester Lycra Fabrics')

@section('content')
<div class="product-filter-wrapper top-section-padding">
    <div class="container">
        <div class="row">
            <!-- Filter Sidebar -->
            <aside class="col-md-3">
                <div class="product-filter-left">
                    <form method="GET" action="{{ route('products.index') }}">
                        <h5>Filter Products</h5>

                        <!-- Categories -->
                        <div class="mb-3">
                            <h6>Category</h6>
                            @foreach ($categories as $id => $name)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category[]" value="{{ $id }}" id="cat-{{ $id }}" {{ is_array(request('category')) && in_array($id, request('category')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat-{{ $id }}">{{ $name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Fabrics -->
                        <div class="mb-3">
                            <h6>Fabric</h6>
                            @foreach ($fabrics as $fabric)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fabric[]" value="{{ $fabric }}" id="fab-{{ $fabric }}" {{ is_array(request('fabric')) && in_array($fabric, request('fabric')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fab-{{ $fabric }}">{{ $fabric }}</label>
                            </div>
                            @endforeach
                        </div>

                        <!-- MOQ Ranges -->
                        <div class="mb-3">
                            <h6>MOQ Range</h6>
                            @foreach ($moqRanges as $range)
                            @php
                            $display = $range === '500+' ? '500+ pieces' : $range . ' pieces';
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="moq_range[]" value="{{ $range }}" id="moq-{{ $range }}" {{ is_array(request('moq_range')) && in_array($range, request('moq_range')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="moq-{{ $range }}">{{ $display }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="export_ready_only" id="export_ready_only" value="1" {{ request('export_ready_only') ? 'checked' : '' }}>
                                <label class="form-check-label" for="export_ready_only">Export Ready Only</label>
                            </div>
                        </div>

                        <button type="submit" class="btn">Apply Filters</button>
                    </form>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="col-md-9">
                <div class="product-filter-right">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="title">
                            <h4 class="mb-0">Fashion Collection</h4>
                            <span>{{ $totalProducts }} products available</span>
                        </div>
                        <div>
                            <form method="GET" action="{{ route('products.index') }}" class="d-inline-block">
                                {{-- Preserve current filters --}}
                                @foreach (request()->except('sort', 'page') as $key => $values)
                                @if (is_array($values))
                                @foreach ($values as $value)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $value }}">
                                @endforeach
                                @else
                                <input type="hidden" name="{{ $key }}" value="{{ $values }}">
                                @endif
                                @endforeach
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <span class="sort-by">Sort by:</span>
                                    <select name="sort" class="form-select" onchange="this.form.submit()">

                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest
                                        </option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            Price: Low to High</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            Price: High to Low</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>


                    @if ($products->count())

                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="card">
                                <div class="product-right-filter-img">
                                    @php
                                    $mainImage = null;

                                    // Check if the product has variants
                                    if ($product->variants->count()) {
                                    // Get the first variant
                                    $firstVariant = $product->variants->first();

                                    // Get the first image of that variant
                                    $images = is_array($firstVariant->images)
                                    ? $firstVariant->images
                                    : json_decode($firstVariant->images, true) ?? [];

                                    $mainImage = $images[0] ?? null;
                                    }

                                    // Fallback to main product image if no variant images exist
                                    if (!$mainImage) {
                                    $mainImage = $product->image_url;
                                    }
                                    @endphp

                                    <img src="{{ asset('images/variants/' . basename($mainImage)) }}" class="img-fluid" alt="{{ $product->name }}">

                                </div>

                                <div class="trending-feature-list">
                                    <p class="feature trending-feature">Trending</p>
                                    {{-- <p class="feature premium-feature">Premium</p>
                                                <p class="feature new-feature">New</p> --}}
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}
                                    </p>

                                    <div class="material-list">
                                        {{-- Materials --}}
                                        @if ($product->materials)
                                        <small class="badge-material">{{ $product->materials }}</small>
                                        @endif

                                        {{-- Export Ready --}}
                                        @if ($product->export_ready)
                                        <small class="badge-export">Export Ready</small>
                                        @endif

                                        {{-- MOQ --}}
                                        @php
                                        // If variants exist, get min MOQ from variants, else fallback to product's moq
                                        $moq = $product->variants->count()
                                        ? $product->variants->min('moq')
                                        : $product->moq;
                                        @endphp
                                        @if ($moq)
                                        <small class="badge-moq">MOQ: {{ $moq }}</small>
                                        @endif
                                    </div>

                                    <a href="{{ route('products.show', $product) }}" class="btn">Check
                                        Price</a>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>


                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                    @else
                    <p>No products found matching the filters.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

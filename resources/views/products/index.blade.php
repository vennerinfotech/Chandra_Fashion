@extends('layouts.app')

@section('title', 'Chandra Fashion - Manufacturer of Lycra Fabric & Polyester Lycra Fabrics')

@section('content')
<div class="container my-5">
  <div class="row">
    <!-- Filter Sidebar -->
    <aside class="col-md-3 mb-4">
      <form method="GET" action="{{ route('products.index') }}">
        <h5>Filter Products</h5>

        <div class="mb-3">
          <strong>Category</strong><br>
          @foreach(['Dresses', 'Tops & Blouses', 'Trousers', 'Jackets'] as $category)
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                name="category[]"
                value="{{ $category }}"
                id="cat-{{ $category }}"
                {{ (is_array(request('category')) && in_array($category, request('category'))) ? 'checked' : '' }}
              >
              <label class="form-check-label" for="cat-{{ $category }}">{{ $category }}</label>
            </div>
          @endforeach
        </div>

        <div class="mb-3">
          <strong>Fabric</strong><br>
          @foreach(['Cotton', 'Silk', 'Linen', 'Polyester', 'Wool'] as $fabric)
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                name="fabric[]"
                value="{{ $fabric }}"
                id="fab-{{ $fabric }}"
                {{ (is_array(request('fabric')) && in_array($fabric, request('fabric'))) ? 'checked' : '' }}
              >
              <label class="form-check-label" for="fab-{{ $fabric }}">{{ $fabric }}</label>
            </div>
          @endforeach
        </div>

        <div class="mb-3">
          <strong>MOQ Range</strong><br>
          @foreach(['50-100 pieces', '100-500 pieces', '500+ pieces'] as $range)
            @php
              $val = str_replace(' pieces', '', $range);
            @endphp
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                name="moq_range[]"
                value="{{ $val }}"
                id="moq-{{ $val }}"
                {{ (is_array(request('moq_range')) && in_array($val, request('moq_range'))) ? 'checked' : '' }}
              >
              <label class="form-check-label" for="moq-{{ $val }}">{{ $range }}</label>
            </div>
          @endforeach
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              name="export_ready_only"
              id="export_ready_only"
              value="1"
              {{ request('export_ready_only') ? 'checked' : '' }}
            >
            <label class="form-check-label" for="export_ready_only">Export Ready Only</label>
          </div>
        </div>

        <button type="submit" class="btn btn-black w-100">Apply Filters</button>
      </form>
    </aside>

    <!-- Products Grid -->
    <section class="col-md-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column">
                <h4 class="mb-0">Fashion Collection</h4>
                <span>{{ $totalProducts }} products available</span>
            </div>
            <div>
                <form method="GET" action="{{ route('products.index') }}" class="d-inline-block">
                {{-- Preserve current filters --}}
                @foreach(request()->except('sort', 'page') as $key => $values)
                    @if(is_array($values))
                    @foreach($values as $value)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $value }}">
                    @endforeach
                    @else
                    <input type="hidden" name="{{ $key }}" value="{{ $values }}">
                    @endif
                @endforeach

                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
                </form>
            </div>
        </div>


      @if($products->count())

        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm rounded-3">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ url($product->image_url) }}"
                                class="card-img-top rounded-top zoom-out-image"
                                alt="{{ $product->name }}"
                                style="height: 320px; object-fit: cover;">

                            @php
                                $badge = null;
                                $badgeColor = null;

                                if ($product->trending) {
                                    $badge = 'Trending';
                                    $badgeColor = '#FF4C60';  // red
                                } elseif ($product->new) {
                                    $badge = 'New';
                                    $badgeColor = '#0d6efd';  // blue
                                } elseif ($product->premium) {
                                    $badge = 'Premium';
                                    $badgeColor = '#6f42c1';  // purple
                                }
                            @endphp

                            @if ($badge)
                                <span class="badge position-absolute top-0 start-0 m-3 text-white px-3 py-2"
                                    style="background-color: {{ $badgeColor }}; font-weight: 600; font-size: 0.75rem; border-radius: 0.35rem;">
                                    {{ $badge }}
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            <p class="card-text text-muted" style="font-size: 0.9rem;">{{ $product->description }}</p>
                            <div class="mb-3">
                                <small class="badge bg-light text-dark me-2">{{ $product->fabric }}</small>
                                @if ($product->export_ready)
                                    <small class="badge bg-success text-white me-2">Export Ready</small>
                                @endif
                                <small class="text-muted">MOQ: {{ $product->moq }}</small>
                            </div>
                            {{-- <a href="" class="btn btn-dark w-100 fw-semibold py-2">Check Price</a> --}}
                            <a href="{{ route('products.show', $product) }}" class="btn btn-dark w-100 fw-semibold py-2">Check Price</a>

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
    </section>
  </div>
</div>
@endsection

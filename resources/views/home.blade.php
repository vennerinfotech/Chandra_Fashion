@extends('layouts.app')

@section('title', 'Welcome to Chandra Fashion')

@section('content')

    <!-- Hero Slider Section -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">

            @foreach ($heroSections as $index => $hero)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <section class="hero-section"
                        style="background: url('{{ asset($hero->background_image) }}') no-repeat center center/cover;">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="hero-content">
                                <h1>{{ $hero->title }}</h1>
                                <p>{{ $hero->subtitle }}</p>
                                <div class="hero-sectoin-btn">
                                    <a href="{{ $hero->btn1_link }}" class="btn btn-yellow">{{ $hero->btn1_text }}</a>
                                    {{-- <a href="{{ $hero->btn2_link }}" class="btn btn-outline">{{ $hero->btn2_text }}</a>
                                    <a href="{{ $hero->btn3_link }}" class="btn btn-light">{{ $hero->btn3_text }}</a> --}}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endforeach

        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    {{-- <section class="featured-section section-padding">
        <div class="container-fluid">
            <div class="row">
                <h2 class="section-title">
                    {{ $featured->main_title ?? 'Featured Collections' }}
                </h2>
                <p class="section-sub-title">
                    {{ $featured->main_subtitle ?? 'Discover our latest designs and seasonal highlights' }}
                </p>
            </div>
            <div class="row">
                <div class="custom-owl-carousel owl-carousel featured-carousel">
                    @foreach ($featuredCollections as $card)
                    <div class="featured-collection-grid">
                        <div class="featured-img">
                            @if ($card->image)
                            <img src="{{ asset($card->image) }}" alt="{{ $card->title }}">
                            @endif
                        </div>
                        <div class="featured-content">
                            <h2>{{ $card->title }}</h2>
                            <p>{{ $card->subtitle }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section> --}}


    <section class="featured-section section-padding">
        <div class="container-fluid">
            <div class="row">
                <h2 class="section-title">
                    {{ $featured->main_title ?? 'Featured Collections' }}
                </h2>
                <p class="section-sub-title">
                    {{ $featured->main_subtitle ?? 'Discover our latest designs and seasonal highlights' }}
                </p>
            </div>

            <div class="row">
                <div class="custom-owl-carousel owl-carousel featured-carousel">
                    @foreach ($categories as $category)
                        <div class="featured-collection-grid">
                            <a href="{{ route('allcollection') }}" class="featured-link">
                                <div class="featured-img">
                                    <img src="{{ $category->image ? asset('images/categories/' . $category->image) : asset('images/placeholder.png') }}"
                                        alt="{{ $category->name }}">
                                </div>
                                <div class="featured-content">
                                    <h2>{{ $category->name }}</h2>
                                    <p>{{ $category->description ?? '' }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    {{-- <section class="featured-section section-padding">
        <div class="container-fluid">
            <div class="row">
                <h2 class="section-title">
                    {{ $featured->main_title ?? 'Featured Collections' }}
                </h2>
                <p class="section-sub-title">
                    {{ $featured->main_subtitle ?? 'Discover our latest designs and seasonal highlights' }}
                </p>
            </div>

            Featured Collections
            <div class="row mb-5">
                <div class="custom-owl-carousel owl-carousel featured-carousel">
                    @foreach ($featuredCollections as $card)
                    <div class="featured-collection-grid">
                        <div class="featured-img">
                            @if ($card->image)
                            <img src="{{ asset($card->image) }}" alt="{{ $card->title }}">
                            @endif
                        </div>
                        <div class="featured-content">
                            <h2>{{ $category->name }}</h2>
                            <p>{{ $card->subtitle }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            Categories / Collections (merged section)
            <div class="row mt-5">
                <h2 class="section-title">
                    {{ $collections->title ?? 'Our Collections' }}
                </h2>
                <p class="section-sub-title">
                    {{ $collections->subtitle ?? 'Specialized manufacturing across diverse fashion categories with
                    uncompromising quality standards' }}
                </p>

                <div class="custom-owl-carousel owl-carousel collection-carousel">
                    @foreach ($categories as $category)
                    <div class="collection-item">
                        <a href="{{ route('allcollection') }}">
                            <img src="{{ $category->image ? asset('images/categories/' . $category->image) : asset('images/placeholder.png') }}"
                                alt="{{ $category->name }}">

                            <div class="collection-info">
                                <h3>{{ $category->name }}</h3>
                                <p>{{ $category->description ?? '' }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section> --}}


    <section class="new-arriaval section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">New Arrivals</h2>
                <p class="section-sub-title">Discover our latest designs and seasonal highlights</p>
            </div>

            <div class="row">
                <div class="custom-owl-carousel owl-carousel new-arrival-carousel">

                    @foreach ($newArrivals as $product)
                        @php
                            $mainImage = null;

                            // Check if the product has variants with images
                            if ($product->variants->count()) {
                                $firstVariant = $product->variants->first();
                                $images = is_array($firstVariant->images)
                                    ? $firstVariant->images
                                    : json_decode($firstVariant->images, true) ?? [];
                                $mainImage = $images[0] ?? null;
                            }

                            // Fallback to main product image if no variant images exist
                            if (!$mainImage) {
                                $mainImage = $product->image; // or $product->image_url
                            }

                            // Prepare final image path
                            $imagePath =
                                $mainImage && file_exists(public_path('images/variants/' . basename($mainImage)))
                                ? asset('images/variants/' . basename($mainImage))
                                : asset('images/default-product.jpg');

                            // Determine MOQ
                            $moq = $product->variants->count() ? $product->variants->min('moq') : $product->moq;
                        @endphp

                        <div class="new-arrival-box card">
                            <a href="{{ route('products.show', $product) }}">
                                <div class="new-arrival-box-img">
                                    <img src="{{ $imagePath }}" alt="{{ $product->name }}" class="img-fluid">
                                </div>
                            </a>
                            <div class="arrival-list">
                                @if ($product->is_featured)
                                    <p>FEATURED</p>
                                @elseif($product->is_trending)
                                    <p>TRENDING</p>
                                @endif
                            </div>

                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                <p class="card-text">{!! $product->short_description ?? 'No short description available.' !!}
                                </p>

                                <div class="material-list">
                                    @if ($product->materials)
                                        <small class="badge-material">{{ $product->materials }}</small>
                                    @endif
                                    @if ($moq)
                                        <small class="badge-moq">MOQ: {{ $moq }}</small>
                                    @endif
                                    @if ($product->export_ready)
                                        <small class="badge-export">Export Ready</small>
                                    @endif
                                </div>

                                <a href="{{ route('products.show', $product) }}" class="btn">Check Price</a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    {{-- <section class="collections-section section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">{{ $collections->title ?? 'Our Collections' }}</h2>
                <p class="section-sub-title">
                    {{ $collections->subtitle ?? 'Specialized manufacturing across diverse fashion categories with
                    uncompromising quality standards' }}
                </p>
            </div>

            <div class="custom-owl-carousel owl-carousel collection-carousel">
                @foreach ($categories as $category)
                <div class="collection-item">
                    <a href="{{ route('allcollection') }}">
                        <img src="{{ $category->image ? asset('images/categories/' . $category->image) : asset('images/placeholder.png') }}"
                            alt="{{ $category->name }}">

                        <div class="collection-info">
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $category->description ?? '' }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    <section class="card-section section-padding">
        <div class="container">
            <div class="row">

                @php
                    // Fetch 3 cards or use empty placeholders if DB has less
                    $cards = $featureCards->take(3)->all();
                    $staticSvgs = [
                        asset('images/svg/static1.svg'),
                        asset('images/svg/static2.svg'),
                        asset('images/svg/static3.svg'),
                    ];
                @endphp

                @for ($i = 0; $i < 3; $i++)
                        @php
                            $card = $cards[$i] ?? null;
                        @endphp
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body text-center d-flex flex-column align-items-center gap-3">

                                    <div class="svg-wrapper">
                                        @if ($card && $card->svg_path)
                                            <img src="{{ asset($card->svg_path) }}" alt="{{ $card->title }}">
                                        @else
                                            <img src="{{ $staticSvgs[$i] }}" alt="Static SVG">
                                        @endif
                                    </div>

                                    <h5 class="card-title m-0">
                                        {{ $card->title ?? ['Low MOQ', 'Global Export', 'Premium Quality'][$i] }}
                                    </h5>

                                    <p class="card-text">
                                        {{ $card->description ??
                    [
                        'Flexible minimum order quantities starting from 100 pieces per style',
                        'Serving 25+ countries across Europe, North America, and Asia',
                        'ISO certified facility with rigorous quality control processes.',
                    ][$i] }}
                                    </p>

                                </div>
                            </div>
                        </div>
                @endfor

            </div>
        </div>
    </section>

    {{-- Heritage Section --}}
    <section class="heritage-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="heritage-content">
                        <h2>{{ $heritage->title ?? 'Heritage of Excellence' }}</h2>

                        <p>{{ $heritage->paragraph1 ?? 'For over three decades, Chandra Fashion has been at the forefront of premium clothing manufacturing, blending traditional craftsmanship with modern innovation.' }}
                        </p>

                        <p>{{ $heritage->paragraph2 ?? 'Our commitment to quality, sustainability, and customer satisfaction has made us a trusted partner for fashion brands worldwide.' }}
                        </p>

                        @if ($heritage->button_text)
                            <a href="{{ route('about') }}" class="btn btn-yellow">{{ $heritage->button_text }}</a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="heritage-img">
                        @if ($heritage->image)
                            <img src="{{ asset($heritage->image) }}" alt="{{ $heritage->title }}">
                        @else
                            <img src="{{ asset('images/Heritage.png') }}" alt="Heritage Image">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Clients Section --}}
    <section class="client-section section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">Client Trust</h2>
                <p class="section-sub-title">What our global partners say about us</p>
            </div>

            <div class="row">
                <div class="owl-carousel client-carousel">
                    @forelse($clients as $client)
                        <div class="client-card">
                            <div class="client-img">
                                @if ($client->image)
                                    <img src="{{ asset($client->image) }}" alt="{{ $client->name }}">
                                @else
                                    <img src="{{ asset('images/client.png') }}" alt="{{ $client->name }}">
                                @endif
                                <div class="client-title">
                                    <h5 class="name">{{ $client->name }}</h5>
                                    <h6 class="designation">{{ $client->designation }}</h6>
                                </div>
                            </div>
                            <div class="client-quote">
                                <p class="quote">{{ $client->quote }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="client-card">
                            <div class="client-img">
                                <img src="/images/client.png" alt="Default Client">
                                <div class="client-title">
                                    <h5 class="name">John Doe</h5>
                                    <h6 class="designation">CEO</h6>
                                </div>
                            </div>
                            <div class="client-quote">
                                <p class="quote">"No clients added yet."</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- Subscription Section --}}
    {{-- <section class="subscription-section">
        <div class="subscription-content">
            <h2>{{ $subscription->title ?? 'Join Our Buyers Network' }}</h2>
            <p>{{ $subscription->subtitle ?? 'Get exclusive access to new collections, industry insights, and special
                offers' }}
            </p>
            <form action="#">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section> --}}


    <section class="subscription-section">
        <div class="subscription-content">
            <h2>{{ $subscription->title ?? 'Join Our Buyers Network' }}</h2>
            <p>{{ $subscription->subtitle ?? 'Get exclusive access to new collections, industry insights, and special offers' }}
            </p>

            {{-- @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mt-2">
                @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif --}}

            <form action="{{ route('subscribe') }}" method="POST">
                @csrf
                <input type="text" name="mobile" placeholder="Enter your mobile number" maxlength="10" required
                    pattern="[0-9]{10}" title="Please enter a valid 10-digit mobile number">

                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>
    @if(session('success') || $errors->any())
        <div id="toastMessage"
            class="toast align-items-center text-white {{ session('success') ? 'bg-success' : 'bg-danger' }} border-0 position-fixed bottom-0 end-0 m-4"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    {{-- ✅ Success Message --}}
                    @if(session('success'))
                        {{ session('success') }}
                    @endif

                    {{-- ❌ Error Messages --}}
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <style>
            #toastMessage {
                z-index: 9999;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            }
        </style>
    @endif



@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $(".featured-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
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
                     1200: {
                        items: 6
                    }
                }
            });

            $(".new-arrival-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 150000,
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
                    1300: {
                        items: 4
                    }
                }
            });

            $(".collection-carousel").owlCarousel({
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
                    1300: {
                        items: 4
                    }
                }
            });

            $(".client-carousel").owlCarousel({
                loop: false,
                margin: 20,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5100,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
            const toastEl = document.getElementById('toastMessage');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, { delay: 5000 }); //  stays 5 seconds
                toast.show();
            }
        });
    </script>
@endpush

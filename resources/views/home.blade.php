@extends('layouts.app')

@section('title', 'Welcome to Chandra Fashion')

@section('content')


    {{-- <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1>Crafting Excellence in <br><span>Fashion Manufacturing</span></h1>
                <p>Premium B2B clothing manufacturer with 35+ years of expertise in creating exceptional garments for global
                    fashion brands.</p>
                <div class="hero-sectoin-btn">
                    <a href="#" class="btn btn-yellow">Explore Collection</a>
                    <a href="#" class="btn btn-outline">Check Price</a>
                    <a href="#" class="btn btn-light">Get in Touch</a>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="hero-section" @if(!empty($hero->background_image))
    style="background-image:url('{{ asset($hero->background_image) }}');" @endif>

        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1>{{ $hero->title ?? 'Crafting Excellence in' }} <br>
                    <span>{{ $hero->subtitle ?? 'Fashion Manufacturing' }}</span>
                </h1>
                <p>{{ $hero->subtitle ?? 'Premium B2B clothing manufacturer with 35+ years of expertise.' }}</p>
                <div class="hero-sectoin-btn">
                    <a href="{{ $hero->btn1_link ?? '#' }}"
                        class="btn btn-yellow">{{ $hero->btn1_text ?? 'Explore Collection' }}</a>
                    <a href="{{ $hero->btn2_link ?? '#' }}"
                        class="btn btn-outline">{{ $hero->btn2_text ?? 'Check Price' }}</a>
                    <a href="{{ $hero->btn3_link ?? '#' }}"
                        class="btn btn-light">{{ $hero->btn3_text ?? 'Get in Touch' }}</a>
                </div>
            </div>
        </div>
    </section>


    <section class="collections-section section-padding">
        <div class="container">
            {{-- <div class="row">
                <h2 class="section-title">Our Collections</h2>
                <p class="section-sub-title">Specialized manufacturing across diverse fashion categories with uncompromising
                    quality standards</p>
            </div> --}}
            <div class="row">
                <h2 class="section-title">{{ $collections->title ?? 'Our Collections' }}</h2>
                <p class="section-sub-title">
                    {{ $collections->subtitle ?? 'Specialized manufacturing across diverse fashion categories with uncompromising quality standards' }}
                </p>
            </div>

            <div class="collection-grid">
                @foreach($categories as $category)
                    <div class="collection-item">
                        {{-- Image: show default if no image --}}
                        <img src="{{ $category->image ? asset('images/categories/' . $category->image) : asset('images/placeholder.png') }}"
                            alt="{{ $category->name }}">

                        <div class="collection-info">
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $category->description ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>



        </div>
    </section>

    {{-- <section class="card-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center gap-3">
                            <div class="svg-wrapper">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.9512 1.05469C14.8242 0.650391 15.832 0.650391 16.7051 1.05469L29.5137 6.97266C30.0117 7.20117 30.3281 7.69922 30.3281 8.25C30.3281 8.80078 30.0117 9.29883 29.5137 9.52734L16.7051 15.4453C15.832 15.8496 14.8242 15.8496 13.9512 15.4453L1.14258 9.52734C0.644531 9.29297 0.328125 8.79492 0.328125 8.25C0.328125 7.70508 0.644531 7.20117 1.14258 6.97266L13.9512 1.05469ZM26.3965 13.0313L29.5137 14.4727C30.0117 14.7012 30.3281 15.1992 30.3281 15.75C30.3281 16.3008 30.0117 16.7988 29.5137 17.0273L16.7051 22.9453C15.832 23.3496 14.8242 23.3496 13.9512 22.9453L1.14258 17.0273C0.644531 16.793 0.328125 16.2949 0.328125 15.75C0.328125 15.2051 0.644531 14.7012 1.14258 14.4727L4.25977 13.0313L13.166 17.1445C14.5371 17.7773 16.1191 17.7773 17.4902 17.1445L26.3965 13.0313ZM17.4902 24.6445L26.3965 20.5313L29.5137 21.9727C30.0117 22.2012 30.3281 22.6992 30.3281 23.25C30.3281 23.8008 30.0117 24.2988 29.5137 24.5273L16.7051 30.4453C15.832 30.8496 14.8242 30.8496 13.9512 30.4453L1.14258 24.5273C0.644531 24.293 0.328125 23.7949 0.328125 23.25C0.328125 22.7051 0.644531 22.2012 1.14258 21.9727L4.25977 20.5313L13.166 24.6445C14.5371 25.2773 16.1191 25.2773 17.4902 24.6445Z"
                                        fill="#D4AF37" />
                                </svg>
                            </div>
                            <h5 class="card-title m-0">Low MOQ</h5>
                            <p class="card-text">Flexible minimum order quantities starting from 100 pieces per style</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center gap-3">
                            <div class="svg-wrapper">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_0_1251)">
                                        <path
                                            d="M21.6094 15.75C21.6094 17.0508 21.5391 18.3047 21.416 19.5H10.5527C10.4238 18.3047 10.3594 17.0508 10.3594 15.75C10.3594 14.4492 10.4297 13.1953 10.5527 12H21.416C21.5449 13.1953 21.6094 14.4492 21.6094 15.75ZM23.2969 12H30.5098C30.8203 13.2012 30.9844 14.4551 30.9844 15.75C30.9844 17.0449 30.8203 18.2988 30.5098 19.5H23.2969C23.4199 18.293 23.4844 17.0391 23.4844 15.75C23.4844 14.4609 23.4199 13.207 23.2969 12ZM29.8945 10.125H23.0566C22.4707 6.38086 21.3105 3.24609 19.8164 1.24219C24.4043 2.45508 28.1367 5.7832 29.8887 10.125H29.8945ZM21.1582 10.125H10.8105C11.168 7.99219 11.7187 6.10547 12.3926 4.57617C13.0078 3.19336 13.6934 2.19141 14.3555 1.55859C15.0117 0.9375 15.5566 0.75 15.9844 0.75C16.4121 0.75 16.957 0.9375 17.6133 1.55859C18.2754 2.19141 18.9609 3.19336 19.5762 4.57617C20.2559 6.09961 20.8008 7.98633 21.1582 10.125ZM8.91211 10.125H2.07422C3.83203 5.7832 7.55859 2.45508 12.1523 1.24219C10.6582 3.24609 9.49805 6.38086 8.91211 10.125ZM1.45898 12H8.67187C8.54883 13.207 8.48438 14.4609 8.48438 15.75C8.48438 17.0391 8.54883 18.293 8.67187 19.5H1.45898C1.14844 18.2988 0.984375 17.0449 0.984375 15.75C0.984375 14.4551 1.14844 13.2012 1.45898 12ZM12.3926 26.918C11.7129 25.3945 11.168 23.5078 10.8105 21.375H21.1582C20.8008 23.5078 20.25 25.3945 19.5762 26.918C18.9609 28.3008 18.2754 29.3027 17.6133 29.9355C16.957 30.5625 16.4121 30.75 15.9844 30.75C15.5566 30.75 15.0117 30.5625 14.3555 29.9414C13.6934 29.3086 13.0078 28.3066 12.3926 26.9238V26.918ZM8.91211 21.375C9.49805 25.1191 10.6582 28.2539 12.1523 30.2578C7.55859 29.0449 3.83203 25.7168 2.07422 21.375H8.91211ZM29.8945 21.375C28.1367 25.7168 24.4102 29.0449 19.8223 30.2578C21.3164 28.2539 22.4707 25.1191 23.0625 21.375H29.8945Z"
                                            fill="#D4AF37" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_0_1251">
                                            <path d="M0.984375 0.75H30.9844V30.75H0.984375V0.75Z" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <h5 class="card-title m-0">Global Export</h5>
                            <p class="card-text">Serving 25+ countries across Europe, North America, and Asia</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center gap-3">
                            <div class="svg-wrapper">
                                <svg width="23" height="31" viewBox="0 0 23 31" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_0_1258)">
                                        <path
                                            d="M10.5898 1.07227C11.2344 0.644531 12.0781 0.644531 12.7226 1.07227L13.7656 1.75781C14.1172 1.98633 14.5273 2.09766 14.9433 2.07422L16.1914 1.99805C16.9648 1.95117 17.6914 2.37305 18.0371 3.06445L18.5996 4.18359C18.7871 4.55859 19.0918 4.85742 19.4609 5.04492L20.5918 5.61328C21.2832 5.95898 21.7051 6.68555 21.6582 7.45898L21.582 8.70703C21.5586 9.12305 21.6699 9.53906 21.8984 9.88477L22.5898 10.9277C23.0176 11.5723 23.0176 12.416 22.5898 13.0605L21.8984 14.1094C21.6699 14.4609 21.5586 14.8711 21.582 15.2871L21.6582 16.5352C21.7051 17.3086 21.2832 18.0352 20.5918 18.3809L19.4726 18.9434C19.0976 19.1309 18.7988 19.4355 18.6113 19.8047L18.0429 20.9355C17.6972 21.627 16.9707 22.0488 16.1972 22.002L14.9492 21.9258C14.5332 21.9023 14.1172 22.0137 13.7715 22.2422L12.7285 22.9336C12.084 23.3613 11.2402 23.3613 10.5957 22.9336L9.54685 22.2422C9.19529 22.0137 8.78513 21.9023 8.36912 21.9258L7.12107 22.002C6.34763 22.0488 5.62107 21.627 5.27537 20.9355L4.71287 19.8164C4.52537 19.4414 4.22068 19.1426 3.85154 18.9551L2.72068 18.3867C2.02928 18.041 1.6074 17.3145 1.65428 16.541L1.73045 15.293C1.75389 14.877 1.64256 14.4609 1.41404 14.1152L0.728495 13.0664C0.30076 12.4219 0.30076 11.5781 0.728495 10.9336L1.41404 9.89063C1.64256 9.53906 1.75389 9.12891 1.73045 8.71289L1.65428 7.46484C1.6074 6.69141 2.02928 5.96484 2.72068 5.61914L3.83982 5.05664C4.21482 4.86328 4.51951 4.55859 4.70701 4.18359L5.26951 3.06445C5.61521 2.37305 6.34178 1.95117 7.11521 1.99805L8.36326 2.07422C8.77928 2.09766 9.19529 1.98633 9.54099 1.75781L10.5898 1.07227ZM16.3437 12C16.3437 10.7568 15.8499 9.56451 14.9708 8.68544C14.0917 7.80636 12.8994 7.3125 11.6562 7.3125C10.413 7.3125 9.22074 7.80636 8.34167 8.68544C7.46259 9.56451 6.96873 10.7568 6.96873 12C6.96873 13.2432 7.46259 14.4355 8.34167 15.3146C9.22074 16.1936 10.413 16.6875 11.6562 16.6875C12.8994 16.6875 14.0917 16.1936 14.9708 15.3146C15.8499 14.4355 16.3437 13.2432 16.3437 12ZM0.482401 26.6367L3.00779 20.6309C3.01951 20.6367 3.02537 20.6426 3.03123 20.6543L3.59373 21.7734C4.27928 23.1328 5.7031 23.959 7.22654 23.8711L8.47459 23.7949C8.48631 23.7949 8.50388 23.7949 8.5156 23.8066L9.55857 24.498C9.8574 24.6914 10.1738 24.8438 10.5019 24.9492L8.29881 30.1816C8.16404 30.5039 7.86521 30.7207 7.51951 30.75C7.17381 30.7793 6.83982 30.6211 6.65232 30.3281L4.7656 27.4395L1.47849 27.9258C1.14451 27.9727 0.810526 27.8379 0.599588 27.5742C0.388651 27.3105 0.347635 26.9473 0.476541 26.6367H0.482401ZM15.0137 30.1758L12.8105 24.9492C13.1387 24.8438 13.4551 24.6973 13.7539 24.498L14.7969 23.8066C14.8086 23.8008 14.8203 23.7949 14.8379 23.7949L16.0859 23.8711C17.6094 23.959 19.0332 23.1328 19.7187 21.7734L20.2812 20.6543C20.2871 20.6426 20.2929 20.6367 20.3047 20.6309L22.8359 26.6367C22.9648 26.9473 22.9179 27.3047 22.7129 27.5742C22.5078 27.8437 22.1679 27.9785 21.834 27.9258L18.5469 27.4395L16.6601 30.3223C16.4726 30.6152 16.1387 30.7734 15.7929 30.7441C15.4472 30.7148 15.1484 30.4922 15.0137 30.1758Z"
                                            fill="#D4AF37" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_0_1258">
                                            <path d="M0.40625 0.75H22.9062V30.75H0.40625V0.75Z" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <h5 class="card-title m-0">Premium Quality</h5>
                            <p class="card-text">ISO certified facility with rigorous quality control processes.</p>
                        </div>
                    </div>
                </div>
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

                @for($i = 0; $i < 3; $i++)
                            @php
                                $card = $cards[$i] ?? null;
                            @endphp
                            <div class="col-lg-4 mb-4">
                                <div class="card">
                                    <div class="card-body text-center d-flex flex-column align-items-center gap-3">

                                        <div class="svg-wrapper">
                                            @if($card && $card->svg_path)
                                                <img src="{{ asset($card->svg_path) }}" alt="{{ $card->title }}">
                                            @else
                                                <img src="{{ $staticSvgs[$i] }}" alt="Static SVG">
                                            @endif
                                        </div>

                                        <h5 class="card-title m-0">
                                            {{ $card->title ?? ['Low MOQ', 'Global Export', 'Premium Quality'][$i] }}
                                        </h5>

                                        <p class="card-text">
                                            {{ $card->description ?? [
                                                'Flexible minimum order quantities starting from 100 pieces per style',
                                                'Serving 25+ countries across Europe, North America, and Asia',
                                                'ISO certified facility with rigorous quality control processes.'
                                            ][$i] }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                @endfor

            </div>
        </div>
    </section>

    {{-- <section class="featured-section section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">Featured Collections</h2>
                <p class="section-sub-title">Discover our latest designs and seasonal highlights</p>
            </div>
            <div class="row">
                @foreach($featuredCollections as $collection)
                    <div class="col-lg-4">
                        <div class="featured-collection-grid">
                            <div class="featured-img">
                                <img src="{{ asset($collection->image) }}" alt="{{ $collection->title }}">
                            </div>
                            <div class="featured-content">
                                <h2>{{ $collection->title }}</h2>
                                <p>{{ $collection->subtitle }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    <section class="featured-section section-padding">
        <div class="container">
            <div class="row">
             <h2 class="section-title">
                    {{ $featured->main_title ?? 'Featured Collections' }}
                </h2>
                <p class="section-sub-title">
                    {{ $featured->main_subtitle ?? 'Discover our latest designs and seasonal highlights' }}
                </p>
            </div>
            <div class="row">
                @foreach($featuredCollections as $card)
                    <div class="col-lg-4">
                        <div class="featured-collection-grid">
                            <div class="featured-img">
                                @if($card->image)
                                <img src="{{ asset($card->image) }}" alt="{{ $card->title }}">
                                @endif
                            </div>
                            <div class="featured-content">
                                <h2 >{{ $card->title }}</h2>
                                <p>{{ $card->subtitle }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>




    {{-- <section class="heritage-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="heritage-content">
                        <h2>Heritage of Excellence</h2>
                        <p>For over three decades, Chandra Fashion has been at the forefront of premium clothing
                            manufacturing, blending traditional craftsmanship with modern innovation.</p>
                        <p>Our commitment to quality, sustainability, and customer satisfaction has made us a trusted
                            partner for fashion brands worldwide.</p>
                        <a href="#" class="btn btn-yellow">Our Story</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="featured-collection-grid">
                        <div class="heritage-img">
                            <img src="/images/Heritage.png" alt="Men's Collection">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    {{-- Heritage Section --}}
    <section class="heritage-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="heritage-content">
                        <h2>{{ $heritage->title ?? 'Heritage of Excellence' }}</h2>

                        <p>{{ $heritage->paragraph1 ?? 'For over three decades, Chandra Fashion has been at the forefront of premium clothing manufacturing, blending traditional craftsmanship with modern innovation.' }}</p>

                        <p>{{ $heritage->paragraph2 ?? 'Our commitment to quality, sustainability, and customer satisfaction has made us a trusted partner for fashion brands worldwide.' }}</p>

                        @if($heritage->button_text)
                            <a href="#" class="btn btn-yellow">{{ $heritage->button_text }}</a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="featured-collection-grid">
                        <div class="heritage-img">
                            @if($heritage->image)
                                <img src="{{ asset($heritage->image) }}" alt="{{ $heritage->title }}">
                            @else
                                <img src="{{ asset('images/Heritage.png') }}" alt="Heritage Image">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="client-section section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">Client Trust</h2>
                <p class="section-sub-title">What our global partners say about us</p>
            </div>
            <div class="row">
                <div class="owl-carousel client-carousel">
                    <div class="client-card">
                        <div class="client-img">
                            <img src="/images/client.png" alt="">
                            <div class="client-title">
                                <h5 class="name">Mark Thompson</h5>
                                <h6 class="designation">Fashion Brand CEO</h6>
                            </div>
                        </div>
                        <div class="client-quote">
                            <p class="quote">"Exceptional quality and reliability. Chandra Fashion has been our
                                manufacturing partner for 5 years."</p>
                        </div>
                    </div>

                    <div class="client-card">
                        <div class="client-img">
                            <img src="/images/client.png" alt="">
                            <div class="client-title">
                                <h5 class="name">Sarah Chen</h5>
                                <h6 class="designation">Design Director</h6>
                            </div>
                        </div>
                        <div class="client-quote">
                            <p class="quote">"Exceptional quality and reliability. Chandra Fashion has been our
                                manufacturing partner for 5 years."</p>
                        </div>
                    </div>

                    <div class="client-card">
                        <div class="client-img">
                            <img src="/images/client.png" alt="">
                            <div class="client-title">
                                <h5 class="name">David Rodriguez</h5>
                                <h6 class="designation">Procurement Manager</h6>
                            </div>
                        </div>
                        <div class="client-quote">
                            <p class="quote">"Exceptional quality and reliability. Chandra Fashion has been our
                                manufacturing partner for 5 years."</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}


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
                                @if($client->image)
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


    {{-- <section class="subscription-section">
        <div class="subscription-content">
            <h2>Join Our Buyers Network</h2>
            <p>Get exclusive access to new collections, industry insights, and special offers</p>
            <form action="#">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section> --}}


    {{-- Subscription Section --}}
    <section class="subscription-section">
        <div class="subscription-content">
            <h2>{{ $subscription->title ?? 'Join Our Buyers Network' }}</h2>
            <p>{{ $subscription->subtitle ?? 'Get exclusive access to new collections, industry insights, and special offers' }}</p>
            <form action="#">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>


@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $(".client-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 1000,
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
    </script>
@endpush

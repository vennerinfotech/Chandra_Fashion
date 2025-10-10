@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <section class="breadcrumb-wrapper top-section-padding">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
            <h2 class="breadcrumb-title">About Company</h2>
        </nav>
    </section>

    <section class="about-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="position-relative about-img">
                        <img src="{{ asset($about->hero_image ?? 'images/hero-banner.png') }}" alt="Model"
                            class="img-fluid w-100">
                        <div class="experience-badge">
                            {{ $about->experience_years ?? 35 }} <br> <small>Years<br>Experience</small>
                        </div>
                        @if (!empty($about->testimonial_text))
                            <div class="testimonial-box">
                                <em>"{{ $about->testimonial_text }}"</em>
                                <br>
                                <small>- {{ $about->testimonial_author ?? '' }}</small>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="about-content">
                        <h6 class="sub-title">{{ $about->about_subtitle ?? 'About Company' }}</h6>
                        <h2 class="title">{{ $about->about_title ?? 'Well-Coordinated Teamwork Speaks About Us' }}</h2>
                        <p>{{ $about->paragraph1 ?? '' }}</p>
                        <p>{{ $about->paragraph2 ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why choose --}}
    <section class="why-about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="why-about-content">
                        <h2 class="title">{{ $about->why_title ?? 'Why Choose Us?' }}</h2>
                        <p>{{ $about->why_choose_us_1 ?? '' }}</p>
                        <p>{{ $about->why_choose_us_2 ?? '' }}</p>
                        <div class="listing">
                            <ul>
                                @foreach ($about->why_list ?? [] as $item)
                                    <li><i class="fa-solid fa-circle-check"></i> {{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="position-relative about-img">
                        @php
                            $whyChooseImg = $about->why_choose_us_image ?? null;
                        @endphp
                        <img src="{{ asset($whyChooseImg ?? 'images/product2.jpg') }}" alt="Why Choose Us"
                            class="img-fluid w-100">
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="states-section section-padding">
        <div class="container">
            <div class="stats-container">
                @foreach ($about->stats ?? [] as $s)
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-user"></i></div>
                        <div class="d-flex justify-content-center">
                            <div class="stat-number" data-count="{{ $s['number'] }}">{{ $s['number'] }}</div>
                            <span>{{ $s['suffix'] }}</span>
                        </div>
                        <div class="stat-label">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Team --}}
    <section class="team-leader-section section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">Our Team</h2>
                <p class="section-sub-title">Visionary leaders driving our success</p>
            </div>
            <div class="row">
                @foreach ($about->team ?? [] as $member)
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="team-leader-card">
                            <img src="{{ asset($member['image'] ?? 'images/team.png') }}" alt="{{ $member['name'] }}"
                                class="leader-photo">
                            <h2 class="name">{{ $member['name'] ?? '' }}</h2>
                            <p class="designation">{{ $member['designation'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

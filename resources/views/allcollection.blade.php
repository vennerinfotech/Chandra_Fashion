@extends('layouts.app')

@section('title', 'All Collection')

@section('content')

<section class="breadcrumb-wrapper top-section-padding">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">All Collection</li>
  </ol>
  <h2 class="breadcrumb-title">All Collection</h2>
</nav>
</section>

    <section class="collection-page-wrapper section-padding">
        <div class="container">
            {{-- <div class="row">
                <img src="{{ asset('images/contact-top.png') }}" alt="Contact Icon" class="img-fluid contact-top-img">
                <h2 class="section-title">All Collection</h2>
                <p class="section-sub-title">Explore our diverse range of fashion collections tailored to your unique style.
                </p>
            </div> --}}
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="collection-item">
                        <a href="{{ route('allcollection') }}">
                            <img src="{{ asset('images/product1.webp') }}" alt="">

                            <div class="collection-info">
                                <h3>Transfer Jacquard Fabric</h3>
                                <p>Fabrics with patterns</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="collection-item">
                        <a href="{{ route('allcollection') }}">
                            <img src="{{ asset('images/product2.jpg') }}" alt="">

                            <div class="collection-info">
                                <h3>Transfer Jacquard Fabric</h3>
                                <p>Fabrics with patterns</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="collection-item">
                        <a href="{{ route('allcollection') }}">
                            <img src="{{ asset('images/product3.webp') }}" alt="">

                            <div class="collection-info">
                                <h3>Transfer Jacquard Fabric</h3>
                                <p>Fabrics with patterns</p>
                            </div>
                        </a>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-3">
                    <div class="collection-item">
                        <a href="{{ route('allcollection') }}">
                            <img src="{{ asset('images/product1.webp') }}" alt="">

                            <div class="collection-info">
                                <h3>Transfer Jacquard Fabric</h3>
                                <p>Fabrics with patterns</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="collection-item">
                        <a href="{{ route('allcollection') }}">
                            <img src="{{ asset('images/product2.jpg') }}" alt="">

                            <div class="collection-info">
                                <h3>Transfer Jacquard Fabric</h3>
                                <p>Fabrics with patterns</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="collection-item">
                        <a href="{{ route('allcollection') }}">
                            <img src="{{ asset('images/product3.webp') }}" alt="">

                            <div class="collection-info">
                                <h3>Transfer Jacquard Fabric</h3>
                                <p>Fabrics with patterns</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

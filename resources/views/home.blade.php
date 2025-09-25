@extends('layouts.app')

@section('title', 'Welcome to Chandra Fashion')

@section('content')


    <section class="hero-section">
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
    </section>


    <section class="collections-section">
        <div class="container">
            <div class="row">
                <h2>Our Collections</h2>
                <p>Specialized manufacturing across diverse fashion categories with uncompromising quality standards</p>
            </div>
            <div class="collection-grid">
            <div class="collection-item">
                <img src="/images/hero-banner.png" alt="Men's Collection">
                <div class="collection-info">
                    <h3>Men's</h3>
                    <p>Formal & Casual</p>
                </div>
            </div>

            <div class="collection-item">
                <img src="/images/hero-banner.png" alt="Women's Collection">
                <div class="collection-info">
                    <h3>Women's</h3>
                    <p>Contemporary</p>
                </div>
            </div>

            <div class="collection-item">
                <img src="/images/hero-banner.png" alt="Ethnic Collection">
                <div class="collection-info">
                    <h3>Ethnic</h3>
                    <p>Traditional</p>
                </div>
            </div>

            <div class="collection-item">
                <img src="/images/hero-banner.png" alt="Casual Collection">
                <div class="collection-info">
                    <h3>Casual</h3>
                    <p>Everyday</p>
                </div>
            </div>

            <div class="collection-item">
                <img src="/images/hero-banner.png" alt="Formal Collection">
                <div class="collection-info">
                    <h3>Formal</h3>
                    <p>Business</p>
                </div>
            </div>
        </div>
        </div>



    </section>


@endsection

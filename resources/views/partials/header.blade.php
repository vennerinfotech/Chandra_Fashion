<div class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex align-items-center py-1">
                   <a href="#">
                     <i class="fa-solid fa-location-dot"></i>
                    <span>Surat, Gujarat</span>
                   </a>
                </div>
            </div>
            <div class="col-lg-6 top-bar">
                <div class="d-flex justify-content-end align-items-center py-1">
                    <div class="me-3">
                        <a href="tel:+910000000000">
                            <i class="fa-solid fa-phone"></i> +91 00000 00000
                        </a>
                    </div>
                    <div class="me-3">
                        <a href="mailto:info@chandrafashion.com">
                            <i class="fa-solid fa-envelope"></i> info@chandrafashion.com
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="header-wrapper navbar navbar-expand-lg">
    <div class="container">
        <!-- Logo + Brand Name -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('/images/cf-logo-1.png') }}" alt="Chandra Fashion Logo" width="180" height="120"
                class="me-2">
            <span class="fw-bold">Chandra Fashion</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                <li class="nav-item"><a href="{{ route('allcollection') }}" class="nav-link">All Collections</a></li>
                <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Shop</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>



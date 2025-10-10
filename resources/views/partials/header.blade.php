<div class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-6">
                <div class="header-location">
                    <a href="#">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Surat, Gujarat</span>
                    </a>
                </div>
            </div>
            <div class="col-md-8 col-lg-6 top-bar">
                <div class="d-flex justify-content-end align-items-center" style="gap: 15px;">
                    <div class="">
                        <a href="tel:+910000000000">
                            <i class="fa-solid fa-phone"></i> +91 00000 00000
                        </a>
                    </div>
                    <div class="">
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
    <div class="container d-flex align-items-center justify-content-between">

        <!-- Toggle Button on the Left -->
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa-solid fa-bars"></i>
            </span>
        </button>

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('/images/cf-logo-1.png') }}" alt="Chandra Fashion Logo" width="180" height="120"
                class="me-2">
            <span class="fw-bold">Chandra Fashion</span>
        </a>

        <div class="header-social d-none d-md-block d-lg-none">
                <ul>
                    <li> <a href="https://www.facebook.com/ChandraFabrics/" class="bi bi-facebook"><i
                                class="fa-brands fa-facebook"></i></a></li>
                    <li> <a href="https://www.instagram.com/chandrafashionofficial/" class="bi bi-instagram"><i
                                class="fa-brands fa-instagram"></i></a></li>
                    <li> <a href="https://in.linkedin.com/company/chandrafashion" class="bi bi-linkedin"><i
                                class="fa-brands fa-square-linkedin"></i></a></li>
                    <li> <a href="https://www.youtube.com/@chandrafashion" class="bi bi-linkedin"><i
                                class="fa-brands fa-youtube"></i></a></li>
                </ul>
            </div>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Close Button -->
            <button type="button" class="btn-close ms-auto d-lg-none" id="closeMenu" aria-label="Close"></button>

            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                <li class="nav-item"><a href="{{ route('allcollection') }}" class="nav-link">All Collections</a></li>
                <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Shop</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact Us</a></li>
            </ul>
            <div class="header-social d-md-none d-lg-block">
                <ul>
                    <li> <a href="https://www.facebook.com/ChandraFabrics/" class="bi bi-facebook"><i
                                class="fa-brands fa-facebook"></i></a></li>
                    <li> <a href="https://www.instagram.com/chandrafashionofficial/" class="bi bi-instagram"><i
                                class="fa-brands fa-instagram"></i></a></li>
                    <li> <a href="https://in.linkedin.com/company/chandrafashion" class="bi bi-linkedin"><i
                                class="fa-brands fa-square-linkedin"></i></a></li>
                    <li> <a href="https://www.youtube.com/@chandrafashion" class="bi bi-linkedin"><i
                                class="fa-brands fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

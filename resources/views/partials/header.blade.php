<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <!-- Logo + Brand Name -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('uploads/products/cf-logo.jpg') }}" alt="Chandra Fashion Logo" width="180" height="120" class="me-2 rounded-circle">
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
        <li class="nav-item"><a href="#" class="nav-link">About</a></li>
        <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Products</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Sustainability</a></li>
        <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

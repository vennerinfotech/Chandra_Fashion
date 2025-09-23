@extends('layouts.app')

@section('title', 'Welcome to Chandra Fashion')

@section('content')

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1 class="display-4">Welcome to Chandra Fashion</h1>
    <p class="lead">Your style, your statement.</p>
    <a href="#" class="btn btn-primary btn-lg">Shop Now</a>
  </div>
</section>

<!-- Product Cards -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <!-- Product Card Example -->
      @for ($i = 0; $i < 3; $i++)
      <div class="col-md-4">
        <div class="card product-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product">
          <div class="card-body">
            <h5 class="card-title">Product Title</h5>
            <p class="card-text">Short description goes here.</p>
            <a href="#" class="btn btn-outline-primary">View Details</a>
          </div>
        </div>
      </div>
      @endfor
    </div>
  </div>
</section>

@endsection

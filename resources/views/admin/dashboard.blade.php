@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Welcome, {{ Auth::user()->name }} 👋</h1>
    <p class="text-muted">You are logged in as an Admin.</p>

    {{-- Dashboard Stat Cards --}}
    <div class="row">
        <!-- Total Inquiries -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.inquiries.index') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 text-primary">
                            <i class="fas fa-envelope-open-text fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Total Inquiries</h5>
                            <h3 class="fw-bold">{{ $totalInquiries ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Categories -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 text-success">
                            <i class="fas fa-th-large fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Total Categories</h5>
                            <h3 class="fw-bold">{{ $totalCategories ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Products -->
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 text-warning">
                            <i class="fas fa-box-open fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Total Products</h5>
                            <h3 class="fw-bold">{{ $totalProducts ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

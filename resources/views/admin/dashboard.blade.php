@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">

    {{-- Welcome Message --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard</h3>
        <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}</p>
    </div>

    {{-- Dashboard Stat Cards --}}
    <div class="row g-4">
        {{-- Total Inquiries --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-primary fs-2">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Inquiries</h6>
                        <h4 class="fw-bold">{{ $totalInquiries ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Categories --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-success fs-2">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Categories</h6>
                        <h4 class="fw-bold">{{ $totalCategories ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-warning fs-2">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Products</h6>
                        <h4 class="fw-bold">{{ $totalProducts ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Toggle --}}
    <div class="d-flex justify-content-end mt-4">
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <select name="chart" onchange="this.form.submit()" class="form-select w-auto">
                <option value="month" {{ $chartType === 'month' ? 'selected' : '' }}>Month-wise</option>
                <option value="day" {{ $chartType === 'day' ? 'selected' : '' }}>Last 30 Days</option>
            </select>
        </form>
    </div>

    {{-- Line Chart --}}
    <div class="card mt-3 shadow-sm border-0 rounded-3">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ $chartType === "day" ? "Last 30 Days Inquiries" : "Monthly Inquiries (Current Year)" }}</h5>
        </div>
        <div class="card-body">
            <canvas id="inquiryChart" height="300"></canvas>
        </div>
    </div>

    {{-- Pie Charts --}}
    <div class="row g-4 mt-3">
        {{-- Product Pie --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Product-wise Inquiries</h5>
                </div>
                <div class="card-body">
                    <canvas id="productPieChart" height="300"></canvas>
                </div>
            </div>
        </div>

        {{-- User Pie --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">User-wise Inquiries</h5>
                </div>
                <div class="card-body">
                    <canvas id="userPieChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    //  Line Chart
    const ctx = document.getElementById('inquiryChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($days),
            datasets: [{
                label: 'Inquiries',
                data: @json($totals),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true, position: 'top' } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Product Pie Chart
    const productCtx = document.getElementById('productPieChart').getContext('2d');
    new Chart(productCtx, {
        type: 'pie',
        data: {
            labels: @json(array_keys($productInquiries->toArray())),
            datasets: [{
                label: 'Product Inquiries',
                data: @json(array_values($productInquiries->toArray())),
                backgroundColor: [
                    '#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF',
                    '#FF9F40','#C9CBCF','#FF6384','#36A2EB','#FFCE56'
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'right' } } }
    });

    //  User Pie Chart
    const userCtx = document.getElementById('userPieChart').getContext('2d');
    new Chart(userCtx, {
        type: 'pie',
        data: {
            labels: @json(array_keys($userInquiries->toArray())),
            datasets: [{
                label: 'User Inquiries',
                data: @json(array_values($userInquiries->toArray())),
                backgroundColor: [
                    '#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF',
                    '#FF9F40','#C9CBCF','#FF6384','#36A2EB','#FFCE56'
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'right' } } }
    });

});
</script>
@endsection

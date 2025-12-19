@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">

    {{-- Welcome Message --}}   <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard</h3>
        <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}</p>
    </div>

    {{-- Recent Import Notifications --}}
    @if(isset($recentImports) && $recentImports->count() > 0)
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-import me-2"></i>Recent Product Imports</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">View Products</a>
            </div>
            <div class="card-body">
                @foreach($recentImports as $import)
                    <div class="alert alert-{{ $import->status === 'completed' ? 'success' : ($import->status === 'failed' ? 'danger' : ($import->status === 'processing' ? 'info' : 'warning')) }} mb-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                @if($import->status === 'completed')
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Import Completed Successfully</strong>
                                    <p class="mb-0 mt-1 small">
                                        File: <code>{{ $import->file_name }}</code><br>
                                        Products Processed: <strong>{{ $import->processed_rows }}</strong> 
                                        @if($import->skipped_rows > 0)
                                            ({{ $import->skipped_rows }} skipped)
                                        @endif
                                    </p>
                                @elseif($import->status === 'processing')
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                    <strong>Import in Progress...</strong>
                                    <p class="mb-0 mt-1 small">
                                        File: <code>{{ $import->file_name }}</code><br>
                                        Progress: <strong>{{ $import->processed_rows }} / {{ $import->total_rows }}</strong>
                                    </p>
                                @elseif($import->status === 'failed')
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <strong>Import Failed</strong>
                                    <p class="mb-0 mt-1 small">
                                        File: <code>{{ $import->file_name }}</code><br>
                                        Error: {{ $import->error_message }}
                                    </p>
                                @else
                                    <i class="fas fa-clock me-2"></i>
                                    <strong>Import Pending</strong>
                                    <p class="mb-0 mt-1 small">
                                        File: <code>{{ $import->file_name }}</code><br>
                                        Waiting to start...
                                    </p>
                                @endif
                            </div>
                            <small class="text-muted">{{ $import->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

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

    //  Line Chart (Last 30 Days / Monthly)
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
        options: {
            responsive: true,
            maintainAspectRatio: false, // ensure same size
            plugins: { legend: { position: 'right' } }
        }
    });

    // User Pie Chart
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
        options: {
            responsive: true,
            maintainAspectRatio: false, // ensure same size
            plugins: { legend: { position: 'right' } }
        }
    });

});
</script>
@endsection

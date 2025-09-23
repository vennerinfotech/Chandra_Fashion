<div class="d-flex flex-column flex-shrink-0 p-3 bg-light shadow-sm" style="width: 250px; min-height: 100vh;">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.main') }}" class="nav-link {{ request()->routeIs('admin.main') ? 'active' : 'text-dark' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
       <a href="{{ route('admin.products.index') }}"
        class="nav-link {{ request()->routeIs('products.*') ? 'active' : 'text-dark' }}">
        <i class="bi bi-box-seam me-2"></i> Products
        </a>

        <li>
            <a href="#" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-cart-check me-2"></i> Orders
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-people me-2"></i> Customers
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-bar-chart-line me-2"></i> Reports
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->routeIs('settings') ? 'active' : 'text-dark' }}">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
        </li>
    </ul>
</div>

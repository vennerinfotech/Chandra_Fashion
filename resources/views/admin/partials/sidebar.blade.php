<style>
    /* Base Styles */
    .sidebar-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background: #fff;
        transition: left 0.3s ease;
        z-index: 1000;
        box-shadow: 0 8px 24px rgba(168, 180, 208, 0.1);
    }

    .sidebar-wrapper.open {
        left: -250px;
        /* Show sidebar when open */
    }

    .sidebar-wrapper ul {
        padding: 0;
        list-style-type: none;
        border-top: 1px solid #d6d8db;
    }

    .sidebar-wrapper ul li a {
        font-size: 15px;
        font-weight: 400;
        position: relative;
        display: block;
        align-items: center;
        text-decoration: none;
        color: #2b3d51;
        padding: 15px 20px;
    }

    .sidebar-wrapper ul li:hover {
        background-color: #f0f0f5;
    }

    .sidebar-wrapper ul li:hover a svg {
        fill: #fff;
    }

    .sidebar-wrapper ul li.active {
        background-color: #f0f0f5;
    }

    .sidebar-wrapper ul li.active a {
        color: #2b3d51;
        font-weight: 700;
    }


    .sidebar-wrapper ul li.active svg {
        fill: #fff;
    }

    .sidebar-logo {
        padding: 3px;
    }

    .sidebar-logo img {
        height: 60px;
    }

    .sidebar-wrapper .dropdown-toggle {
        position: relative;
    }

    .sidebar-wrapper .dropdown-toggle::after {
        position: absolute;
        right: 15px;
        top: 25px;
    }

    .sidebar-wrapper ul ul.dropdown-menu {
        width: 100%;
        border: none;
        /* background: #f0f0f5; */
    }

    .sidebar-wrapper ul ul.dropdown-menu li {
        padding-left: 20px;
    }

    @media (max-width: 991px) {
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: -260px;
            width: 250px;
            height: 100vh;
            transition: all 0.5s ease-in-out;
            z-index: 10000;
        }

        .sidebar-wrapper.open {
            left: 0;
        }

        .menu-bar {
            padding: 12px 15px;
            transition: all 0.5s ease-in-out;
        }

        .main-wrapper {
            padding: 20px 10px;
            transition: all 0.5s ease-in-out;
        }
        .header-top {
            margin-left: 0px;
        }
    }


    /* Responsive Design for Mobile and Tablet */
</style>

<div class="sidebar-wrapper">
    <div class="sidebar-logo text-center py-2">
        <img src="{{ asset('images/cf-logo-1.png') }}" alt="Chandra Admin Logo" class="img-fluid" style="max-height: 50px;">

    </div>
    <ul>
        <!-- Dashboard -->
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge me-2"></i> Dashboard
            </a>
        </li>

        <!-- Categories -->
        <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <a href="{{ route('admin.categories.index') }}">
                <i class="fa-solid fa-list me-2"></i> Categories
            </a>
        </li>

        <!-- SubCategories -->
        <li class="{{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
            <a href="{{ route('admin.subcategories.index') }}">
                <i class="fa-solid fa-layer-group me-2"></i> Sub Categories
            </a>
        </li>

        <!-- Products -->
        <li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <a href="{{ route('admin.products.index') }}">
                <i class="fa-solid fa-cart-shopping me-2"></i> Products
            </a>
        </li>

        <!-- Inquiries -->
        <li class="{{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
            <a href="{{ route('admin.inquiries.index') }}">
                <i class="fa-solid fa-user-pen me-2"></i> Inquiries
            </a>
        </li>

        <!-- Settings Dropdown -->
        <li
            class="{{ request()->routeIs('admin.settings.manage') || request()->routeIs('admin.about.manage') || request()->routeIs('admin.settings.*') || request()->routeIs('admin.about.*') ? 'active dropdown' : 'dropdown' }}">
            <a href="javascript:void(0);" class="dropdown-toggle">
                <i class="fa-solid fa-gear me-2"></i> Settings
            </a>
            <ul class="dropdown-menu">
                <li class="{{ request()->routeIs('admin.settings.manage') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.manage') }}">
                        <i class="fa-solid fa-gears me-2"></i> General Settings
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.about.manage') ? 'active' : '' }}">
                    <a href="{{ route('admin.about.manage') }}">
                        <i class="fa-solid fa-circle-info me-2"></i> About Us
                    </a>
                </li>
            </ul>
        </li>


        <!-- Chat Bot -->
        {{-- <li>
            <a href="#">
                <i class="fa-solid fa-headset me-2"></i> Chat Bot
            </a>
        </li> --}}
    </ul>
</div>

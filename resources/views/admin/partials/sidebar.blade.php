<style>
    /* Base Styles */
    .sidebar-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background-color: #ffffff;
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
        border-top: 1px solid #ddd;
    }

    .sidebar-wrapper ul li a {
        font-size: 16px;
        font-weight: 400;
        position: relative;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #2b3d51;
        padding: 15px 20px;
    }
    .sidebar-wrapper ul li a svg {
        padding-right: 10px;
    }

    .sidebar-wrapper ul li:hover {
        background-color: #2b3d51;
    }

    .sidebar-wrapper ul li:hover a {
        color: #fff;
    }

    .sidebar-wrapper ul li:hover a svg {
        fill: #fff;
    }

    .sidebar-wrapper ul li.active {
        background-color: #2b3d51;
    }

    .sidebar-wrapper ul li.active a{
        color: #fff;
    }
     .sidebar-wrapper ul li.active svg{
        fill: #fff;
    }
    .sidebar-logo {
        padding: 3px;
    }

    .sidebar-logo img {
        height: 60px;
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
            padding: 0px 5px;
            transition: all 0.5s ease-in-out;
        }

        .header-top {
            margin-left: 0px;
        }
    }


    /* Responsive Design for Mobile and Tablet */
</style>

<div class="sidebar-wrapper">
    <div class="sidebar-logo text-center py-3">
        <h2>Chandra Admin</h2>
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

        <!-- Settings -->
        <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.manage') }}">
                <i class="fa-solid fa-gear me-2"></i> Settings
            </a>
        </li>


        <!-- Chat Bot -->
        <li>
            <a href="#">
                <i class="fa-solid fa-headset me-2"></i> Chat Bot
            </a>
        </li>
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



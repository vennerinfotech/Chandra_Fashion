<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/cf-logo-1.png') }}">

    {{-- Bootstrap CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />

    {{-- Font Awesome CSS --}}
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">


    {{-- Custom Admin CSS --}}
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    {{-- Fonts Styles --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Open Sans', sans-serif;
    }


    /* Back Button Styling */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background-color: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 8px 14px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.2s ease-in-out;
    }

    .back-btn:hover {
        background-color: #0b5ed7;
    }

    canvas {
        width: 100% !important;
        height: 400px !important;
    }
</style>

<body>

    <header>
        @include('admin.partials.sidebar')
        @include('admin.partials.header')
    </header>
    <main class="main-wrapper" style="min-height: calc(100vh - 90px);">
        <div class="container-fluid">
            {{--Back Button Added Here --}}
            <div class="mb-3 mt-2">
                <button class="btn" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
            @yield('content')
        </div>
    </main>

    <footer>
        @include('admin.partials.footer')
    </footer>


    {{-- Jquery JS --}}
    <script src="{{ asset('js/jquery-min.js') }}"></script>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- Font Awesome JS --}}
    <script src="{{ asset('js/all.min.js') }}"></script>

    {{-- Custom Admin JS --}}
    <script src="{{ asset('admin/js/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- CKEditor js cnd link --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/decoupled-document/ckeditor.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     // Toggle dropdown menu
        //     $('.sidebar-wrapper .dropdown-toggle').on('click', function(e) {
        //         console.log('Click')
        //         e.preventDefault();
        //         $(this).next('.sidebar-wrapper .dropdown-menu').slideToggle();
        //     });

        //     // Close dropdown when clicking outside
        //     $(document).on('click', function(e) {
        //         if (!$(e.target).closest('.sidebar-wrapper .dropdown-toggle, .sidebar-wrapper .dropdown-menu').length) {
        //             $('.sidebar-wrapper .dropdown-menu').slideUp();
        //         }
        //     });
        // });

        // { --Back Button Script- }
        // function goBack() {
        //     window.history.back();
        // }

        function goBack() {
            if (document.referrer) {
                window.location.href = document.referrer; // go to previous page
            } else {
                window.location.href = '/'; // fallback to homepage
            }
        }

    </script>


    <script>

    </script>

    @stack('scripts')
</body>

</html>

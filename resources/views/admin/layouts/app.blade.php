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
</style>

<body>

    <header>
        @include('admin.partials.sidebar')
        @include('admin.partials.header')
    </header>
    <main class="main-wrapper" style="min-height: calc(100vh - 90px);">
        <div class="container-fluid">
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

    <script>
    $(document).ready(function() {
        // Toggle dropdown menu
        $('.sidebar-wrapper .dropdown-toggle').on('click', function(e) {
            console.log('Click')
            e.preventDefault();
            $(this).next('.sidebar-wrapper .dropdown-menu').slideToggle();
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.sidebar-wrapper .dropdown-toggle, .sidebar-wrapper .dropdown-menu').length) {
                $('.sidebar-wrapper .dropdown-menu').slideUp();
            }
        });
    });
    </script>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', // can be 'line', 'pie', 'doughnut', etc.
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 3, 5, 2],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @stack('scripts')
</body>

</html>

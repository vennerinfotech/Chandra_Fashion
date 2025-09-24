<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- Bootstrap CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

     {{-- Font Awesome CSS --}}
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">


    {{-- Custom Admin CSS --}}
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
</head>
<body>

  <header>
        @include('admin.partials.sidebar')
        @include('admin.partials.header')
    </header>
    <main class="main-wrapper" style="min-height: calc(100vh - 100px);">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

      <footer>
        @include('admin.partials.footer')
      </footer>



    {{-- Bootstrap JS --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- Font Awesome JS --}}
    <script src="{{ asset('js/all.min.js') }}"></script>

    {{-- Custom Admin JS --}}
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>

<script>
    $(document).ready(function () {
        // When the toggle button is clicked
        $('.sidebar-toggle').on('click', function (e) {
            e.preventDefault();  // Prevent the default action (e.g., following the link)

            $('.sidebar-wrapper').toggleClass('open');  // Toggle the 'open' class

            $('.menu-bar').toggleClass('collapsed');
            $('.main-wrapper').toggleClass('collapsed');
        });
    });

</script>

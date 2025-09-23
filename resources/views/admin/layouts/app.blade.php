<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FontAwesome Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

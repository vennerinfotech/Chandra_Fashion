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
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>

    {{-- Admin Header --}}
    @include('admin.partials.header')

    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar (Optional) --}}
            <div class="col-md-3 col-lg-2 bg-light py-3">
                @includeWhen(View::exists('admin.partials.sidebar'), 'admin.partials.sidebar')
            </div>

            {{-- Main Section --}}
            <div class="col-md-9 col-lg-10 p-4">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer (Optional) --}}
    @includeWhen(View::exists('admin.partials.footer'), 'admin.partials.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Custom Admin JS --}}
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>

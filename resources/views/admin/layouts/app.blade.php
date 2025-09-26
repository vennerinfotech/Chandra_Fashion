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
    <main class="main-wrapper" style="min-height: calc(100vh - 90px);">
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

    // Add new variant js
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('variants-wrapper');

    // Add new variant
    document.getElementById('add-variant').addEventListener('click', function() {
        const index = wrapper.querySelectorAll('.variant-item').length;
        const html = `
        <div class="variant-item border rounded p-3 mb-3 position-relative">
            <a href="javascript:void(0);" title="Cancel" class="btn-action btn-sm remove-variant position-absolute top-0 end-0 m-2">
                <i class="fa-solid fa-circle-xmark text-danger"></i>
            </a>
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label">Product Code</label>
                    <input type="text" name="variants[${index}][product_code]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Color</label>
                    <input type="text" name="variants[${index}][color]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Size</label>
                    <input type="text" name="variants[${index}][size]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">MOQ</label>
                    <input type="number" name="variants[${index}][moq]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Images</label>
                    <input type="file" name="variants[${index}][images][]"
                           class="form-control variant-images" multiple>
                    <div class="mt-2 preview-wrapper"></div>
                </div>
            </div>
        </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
    });

    // Remove variant
    wrapper.addEventListener('click', function(e) {
        if(e.target.closest('.remove-variant')) {
            const item = e.target.closest('.variant-item');
            if(item) item.remove();
        }
    });

    // Preview images (works for static + dynamically added)
    wrapper.addEventListener('change', function(e) {
        if(e.target.classList.contains('variant-images')) {
            const previewWrapper = e.target.closest('.col-md-3').querySelector('.preview-wrapper');
            previewWrapper.innerHTML = '';
            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.width = 100;
                    img.classList.add('me-1', 'mb-1', 'img-thumbnail');
                    previewWrapper.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    });
});


</script>

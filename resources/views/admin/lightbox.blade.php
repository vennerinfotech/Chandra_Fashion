    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.css" />
    @isset($images)
        <!-- Images used to open the lightbox -->
        <a data-fancybox="gallery" href="{{ asset($images[0]) }}">
            <i class="fa-solid fa-photo-film"></i>
        </a>
        <div style="display:none">
            @foreach ($images as $image)
                <a data-fancybox="gallery" href="{{ asset($image) }}">
                    <img src="{{ asset($image) }}" width="100" height="100" alt="" />
                </a>
            @endforeach
        </div>
    @endisset
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
    </script>

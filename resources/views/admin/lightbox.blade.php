<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.css" />

@php
    $galleryId = 'gallery-' . uniqid();
    // Ensure $images is always an array
    $images = isset($images) ? (is_array($images) ? $images : [$images]) : [];
@endphp

@if(count($images) > 0)
    <!-- First image as preview -->
    <a data-fancybox="{{ $galleryId }}" href="{{ asset($images[0]) }}">
        <img src="{{ asset($images[0]) }}" width="50" height="50" class="rounded" alt="" />
    </a>

    <!-- Hidden images for lightbox -->
    @if(count($images) > 1)
        <div style="display:none">
            @foreach($images as $key => $image)
                @if($key != 0)
                    <a data-fancybox="{{ $galleryId }}" href="{{ asset($image) }}">
                        <img src="{{ asset($image) }}" width="50" height="50" class="rounded" alt="" />
                    </a>
                @endif
            @endforeach
        </div>
    @endif
@else
    <!-- No images, show only icon -->
    <i class="fa-solid fa-photo-film"></i>
@endif

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox]', {});
</script>

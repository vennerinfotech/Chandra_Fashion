<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.css" />

@php $galleryId = 'gallery-' . uniqid(); @endphp

@isset($images)
    @if(count($images) > 0)
        <!-- First image as preview -->
        <a data-fancybox="{{ $galleryId }}" href="{{ asset($images[0]) }}">
            <img src="{{ asset($images[0]) }}" wwidth="50" height="50" class="rounded" alt="" />
        </a>

        <!-- Hidden images for lightbox -->
        <div style="display:none">
            @foreach($images as $key => $image)
                @if($key != 0)
                    <a data-fancybox="{{ $galleryId }}" href="{{ asset($image) }}">
                        <img src="{{ asset($image) }}" width="50" height="50" class="rounded" alt="" />
                    </a>
                @endif
            @endforeach
        </div>
    @else
        <!-- No images, show only icon -->
        <i class="fa-solid fa-photo-film"></i>
    @endif
@else
    <!-- $images not set, show icon -->
    <i class="fa-solid fa-photo-film"></i>
@endisset

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox]', {});
</script>

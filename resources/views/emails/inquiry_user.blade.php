<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Product Inquiry - Chandra Fashion</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f9f9f9; margin:0; padding:20px;">

    <!-- Header / Logo -->
    <div style="text-align:center; margin-bottom:20px;">
        <h1 style="color:#d32f2f; margin:0; font-size:28px;">✨ Chandra Fashion ✨</h1>
    </div>

    <!-- Container -->
    <div
        style="max-width:800px; margin:0 auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

        <!-- Variant Details -->
        @if($product)
            <h3>Product Details:</h3>
            <table>
                <tr>
                    <td>Name:</td>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>{{ $product->description }}</td>
                </tr>
                <tr>
                    <td>Category ID:</td>
                    <td>{{ $product->category_id }}</td>
                </tr>
                <tr>
                    <td>Materials:</td>
                    <td>{{ $product->materials }}</td>
                </tr>
                <tr>
                    <td>Delivery Time:</td>
                    <td>{{ $product->delivery_time ?? '-' }}</td>
                </tr>
            </table>

            <h4>Variant Details:</h4>
            @foreach($product->variants as $variant)
                <table border="1" cellpadding="5" cellspacing="0" style="margin-bottom:15px;">
                    <tr>
                        <td>Product Code:</td>
                        <td>{{ $variant->product_code }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Color:</td>
                        <td>{{ $variant->color ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Size:</td>
                        <td>{{ $variant->size ?? '-' }}</td>
                    </tr> --}}
                    <tr>
                        <td>MOQ:</td>
                        <td>{{ $variant->moq ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Images:</td>
                        <td>
                            @if($variant->images)
                                @php $images = json_decode($variant->images, true); @endphp
                                @foreach($images as $img)
                                    <img src="{{ asset($img) }}" width="100" style="margin:3px;" />
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif

        <p style="margin-top:20px; color:#555;">Thanks,<br><strong>{{ config('app.name') }}</strong></p>
    </div>
</body>

</html>

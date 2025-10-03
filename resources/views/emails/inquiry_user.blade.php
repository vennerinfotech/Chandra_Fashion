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
    <div style="max-width:800px; margin:0 auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

        <!-- Variant Details -->
        @if(!empty($data['inquiry']['variant_details']))
            <h3 style="color:#444; margin-top:25px;"> User Selected Variant</h3>
            <tr><td style="padding:6px;"><strong>ID:</strong></td><td>{{ $data['product']['id'] }}</td></tr>
            <tr><td style="padding:6px;"><strong>Name:</strong></td><td>{{ $data['product']['name'] }}</td></tr>
            <tr><td style="padding:6px;"><strong>Description:</strong></td><td>{{ $data['product']['description'] }}</td></tr>
            <tr><td style="padding:6px;"><strong>Category ID:</strong></td><td>{{ $data['product']['category_id'] }}</td></tr>
            <tr><td style="padding:6px;"><strong>Materials:</strong></td><td>{{ $data['product']['materials'] }}</td></tr>
            <tr><td style="padding:6px;"><strong>Delivery Time:</strong></td><td>{{ $data['product']['delivery_days'] }} days</td></tr>
            <tr><td style="padding:6px;"><strong>MOQ:</strong></td><td>{{ $data['inquiry']['variant_details']['min_order_qty'] ?? 'N/A' }}</td></tr>
            <tr><td style="padding:6px;"><strong>Quantity Interested:</strong></td><td>{{ $data['inquiry']['quantity'] }}</td></tr>
            <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
                <tr><td style="padding:6px;"><strong>Product Code:</strong></td><td>{{ $data['inquiry']['variant_details']['product_code'] ?? 'N/A' }}</td></tr>
                <tr><td style="padding:6px;"><strong>Color:</strong></td><td>{{ $data['inquiry']['variant_details']['color'] ?? 'N/A' }}</td></tr>
                <tr><td style="padding:6px;"><strong>Size:</strong></td>
                    <td>{{ is_array($data['inquiry']['variant_details']['size']) ? implode(',', $data['inquiry']['variant_details']['size']) : $data['inquiry']['variant_details']['size'] }}</td>
                </tr>

                @if(!empty($data['inquiry']['selected_images']))
                    <h3 style="color:#444;"> Selected Images</h3>
                    <div>
                        @foreach($data['inquiry']['selected_images'] as $img)
                            <img src="{{ asset($img) }}" alt="Selected Image" width="120"
                                style="margin:5px; border:1px solid #ddd; border-radius:6px;">
                        @endforeach
                    </div>
                @endif
                ----
                 @if(!empty($data['inquiry']['selected_size']))
                    <tr><td style="padding:6px;"><strong>Selected Size:</strong></td><td>{{ $data['inquiry']['selected_size'] }}</td></tr>
                @endif
            </table>

            @if(!empty($data['inquiry']['variant_details']['images']))

            @endif
        @endif

        <p style="margin-top:20px; color:#555;">Thanks,<br><strong>{{ config('app.name') }}</strong></p>
    </div>
</body>
</html>

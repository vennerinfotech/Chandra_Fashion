<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Product Inquiry - Chandra Fashion</title>
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        a {
            color: #d32f2f;
            text-decoration: none;
        }

        /* Container */
        .email-container {
            max-width: 800px;
            margin: 20px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Header */
        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .email-header h1 {
            color: #d32f2f;
            font-size: 32px;
            margin: 0;
        }

        /* Section Titles */
        h2, h3 {
            color: #444;
            margin-bottom: 10px;
            margin-top: 25px;
            font-weight: 600;
        }

        h2 {
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
            font-size: 22px;
        }

        h3 {
            font-size: 18px;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table tr td {
            padding: 8px 6px;
            vertical-align: top;
        }

        table tr td:first-child {
            font-weight: bold;
            width: 180px;
            color: #555;
        }

        /* Images */
        .variant-images img {
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 120px;
            height: auto;
        }

        /* Footer */
        .email-footer {
            margin-top: 30px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="email-container">

        <!-- Header / Logo -->
        <div class="email-header">
            <h1>✨ Chandra Fashion ✨</h1>
        </div>

        <!-- Customer Details -->
        <h2>👤 Customer Details</h2>
        <table>
            <tr><td>Name:</td><td>{{ $data['inquiry']['name'] }}</td></tr>
            <tr><td>Company:</td><td>{{ $data['inquiry']['company'] }}</td></tr>
            <tr><td>Email:</td><td>{{ $data['inquiry']['email'] }}</td></tr>
            <tr><td>Phone:</td><td>{{ $data['inquiry']['phone'] }}</td></tr>
            <tr><td>Country:</td><td>{{ $data['inquiry']['country'] }}</td></tr>
            <tr><td>Quantity Interested:</td><td>{{ $data['inquiry']['quantity'] }}</td></tr>
        </table>

        <!-- Variant Details -->
        @if(!empty($data['inquiry']['variant_details']))
        <h2>🛍 Product Details</h2>
        <table>
            <tr><td>Product ID:</td><td>{{ $data['product']['id'] }}</td></tr>
            <tr><td>Name:</td><td>{{ $data['product']['name'] }}</td></tr>
            <tr><td>Description:</td><td>{{ $data['product']['description'] }}</td></tr>
            <tr><td>Category ID:</td><td>{{ $data['product']['category_id'] }}</td></tr>
            <tr><td>Materials:</td><td>{{ $data['product']['materials'] }}</td></tr>
            <tr><td>Delivery Time:</td><td>{{ $data['product']['delivery_days'] }} days</td></tr>
            <tr><td>MOQ:</td><td>{{ $data['inquiry']['variant_details']['min_order_qty'] ?? 'N/A' }}</td></tr>
            <tr><td>Quantity Interested:</td><td>{{ $data['inquiry']['quantity'] }}</td></tr>
            <tr><td>Product Code:</td><td>{{ $data['inquiry']['variant_details']['product_code'] ?? 'N/A' }}</td></tr>
            <tr><td>Color:</td><td>{{ $data['inquiry']['variant_details']['color'] ?? 'N/A' }}</td></tr>
            <tr><td>Size:</td>
                <td>{{ is_array($data['inquiry']['variant_details']['size']) ? implode(',', $data['inquiry']['variant_details']['size']) : $data['inquiry']['variant_details']['size'] }}</td>
            </tr>
            @if(!empty($data['inquiry']['selected_size']))
            <tr><td>Selected Size:</td><td>{{ $data['inquiry']['selected_size'] }}</td></tr>
            @endif
        </table>

        @if(!empty($data['inquiry']['selected_images']))
        <h3>Selected Images</h3>
        <div class="variant-images">
            @foreach($data['inquiry']['selected_images'] as $img)
                <img src="{{ asset($img) }}" alt="Selected Image">
            @endforeach
        </div>
        @endif
        @endif

        <!-- Footer -->
        <p class="email-footer">
            Thanks,<br>
            <strong>{{ config('app.name') }}</strong>
        </p>
    </div>
</body>
</html>

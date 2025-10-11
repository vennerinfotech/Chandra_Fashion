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

  <div style="font-family:Arial,sans-serif; color:#333;">
    <h2>New Product Inquiry</h2>

    <h3>Customer Details:</h3>
    <table>
        <tr><td>Name:</td><td>{{ $inquiry->name }}</td></tr>
        <tr><td>Company:</td><td>{{ $inquiry->company ?? '-' }}</td></tr>
        <tr><td>Email:</td><td>{{ $inquiry->email }}</td></tr>
        <tr><td>Phone:</td><td>{{ $inquiry->phone ?? '-' }}</td></tr>
        <tr><td>Country:</td><td>{{ $inquiry->country->name ?? '-' }}</td></tr>
        <tr><td>State:</td><td>{{ $inquiry->state->name ?? '-' }}</td></tr>
        <tr><td>City:</td><td>{{ $inquiry->city->name ?? '-' }}</td></tr>
        <tr><td>Quantity Interested:</td><td>{{ $inquiry->quantity }}</td></tr>
    </table>

    @if($product)
    <h3>Product Details:</h3>
    <table>
        <tr><td>Name:</td><td>{{ $product->name }}</td></tr>
        <tr><td>Description:</td><td>{{ $product->description }}</td></tr>
        <tr><td>Category ID:</td><td>{{ $product->category_id }}</td></tr>
        <tr><td>Materials:</td><td>{{ $product->materials }}</td></tr>
        <tr><td>Delivery Time:</td><td>{{ $product->delivery_time ?? '-' }}</td></tr>
    </table>

    <h4>Variant Details:</h4>
    @foreach($product->variants as $variant)
        <table border="1" cellpadding="5" cellspacing="0" style="margin-bottom:15px;">
            <tr><td>Product Code:</td><td>{{ $variant->product_code }}</td></tr>
            {{-- <tr><td>Color:</td><td>{{ $variant->color ?? '-' }}</td></tr>
            <tr><td>Size:</td><td>{{ $variant->size ?? '-' }}</td></tr> --}}
            <tr><td>MOQ:</td><td>{{ $variant->moq ?? '-' }}</td></tr>
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
</div>

        <!-- Footer -->
        <p class="email-footer">
            Thanks,<br>
            <strong>{{ config('app.name') }}</strong>
        </p>
    </div>
</body>
</html>

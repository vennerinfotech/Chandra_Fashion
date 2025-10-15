<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product Inquiry - Chandra Fashion</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        /* Header Section */
        .email-header {
            background: linear-gradient(135deg, #c62828 0%, #d32f2f 50%, #e53935 100%);
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 42px;
            font-weight: 700;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .email-header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            font-weight: 300;
            position: relative;
            z-index: 1;
        }

        /* Content Section */
        .email-content {
            padding: 40px 35px;
        }

        /* Section Headers */
        .section-title {
            color: #d32f2f;
            font-size: 26px;
            font-weight: 700;
            margin: 0 0 25px 0;
            padding-left: 20px;
            border-left: 5px solid #d32f2f;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-icon {
            font-size: 28px;
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 35px;
            border: 2px solid #ffebee;
            box-shadow: 0 4px 15px rgba(211, 47, 47, 0.08);
        }

        /* Table Styling */
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .info-table tr {
            transition: background 0.2s ease;
        }

        .info-table tr:hover {
            background: rgba(211, 47, 47, 0.03);
        }

        .info-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f5f5f5;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .info-table td:first-child {
            font-weight: 600;
            color: #555;
            width: 220px;
            font-size: 14px;
        }

        .info-table td:last-child {
            color: #333;
            font-size: 15px;
        }

        .highlight-value {
            color: #d32f2f;
            font-weight: 700;
            font-size: 18px;
        }

        /* Email Link */
        .email-link {
            color: #d32f2f;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .email-link:hover {
            color: #b71c1c;
            text-decoration: underline;
        }

        /* Product Section */
        .product-header {
            background: linear-gradient(135deg, #f3e5f5 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border: 2px solid #e1bee7;
        }

        /* Variants Section */
        .variants-container {
            margin-top: 30px;
        }

        .variant-title {
            color: #666;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-left: 15px;
            border-left: 4px solid #ff9800;
        }

        .variant-card {
            background: #ffffff;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .variant-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            border-color: #d32f2f;
            transform: translateY(-2px);
        }

        .variant-header {
            background: linear-gradient(135deg, #d32f2f 0%, #e53935 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            margin: -25px -25px 20px -25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Images Gallery */
        .images-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 15px;
            margin-top: 15px;
            padding: 15px;
            background: #fafafa;
            border-radius: 8px;
        }

        .gallery-image {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 10px;
            border: 3px solid #e0e0e0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gallery-image:hover {
            border-color: #d32f2f;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(211, 47, 47, 0.3);
        }

        .no-images {
            color: #999;
            font-style: italic;
            padding: 20px;
            text-align: center;
            background: #f5f5f5;
            border-radius: 8px;
        }

        /* Footer */
        .email-footer {
            background: linear-gradient(135deg, #424242 0%, #212121 100%);
            color: #ffffff;
            padding: 35px 30px;
            text-align: center;
        }

        .footer-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .footer-greeting {
            font-size: 16px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .footer-brand {
            font-size: 24px;
            font-weight: 700;
            color: #d32f2f;
            margin: 15px 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .footer-note {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Badge */
        .badge {
            display: inline-block;
            background: #4caf50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-left: 10px;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .email-header {
                padding: 35px 20px;
            }

            .email-header h1 {
                font-size: 32px;
            }

            .email-content {
                padding: 25px 20px;
            }

            .section-title {
                font-size: 22px;
            }

            .info-table td:first-child {
                width: 140px;
                font-size: 13px;
            }

            .images-gallery {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 10px;
            }

            .gallery-image {
                height: 100px;
            }
        }

    </style>
</head>
<body>
    <div class="email-wrapper">

        <!-- Header -->
        <div class="email-header">
            <h1>✨ CHANDRA FASHION ✨</h1>
            <p>New Product Inquiry Received</p>
        </div>

        <!-- Content -->
        <div class="email-content">

            <!-- Customer Information -->
            <h2 class="section-title">
                <span class="section-icon">👤</span>
                Customer Information
            </h2>
            <div class="info-card">
                <table class="info-table">
                    <tr>
                        <td>Customer Name:</td>
                        <td><strong>{{ $inquiry->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Company:</td>
                        <td>{{ $inquiry->company ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Email Address:</td>
                        <td><a href="mailto:{{ $inquiry->email }}" class="email-link">{{ $inquiry->email }}</a></td>
                    </tr>
                    <tr>
                        <td>Phone Number:</td>
                        <td>{{ $inquiry->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td>{{ $inquiry->country->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>State:</td>
                        <td>{{ $inquiry->state->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>City:</td>
                        <td>{{ $inquiry->city->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Quantity Interested:</td>
                        <td><span class="highlight-value">{{ $inquiry->quantity }} Kg</span></td>
                    </tr>
                </table>
            </div>

            @if($product)
            <!-- Product Information -->
            <h2 class="section-title">
                <span class="section-icon">👗</span>
                Product Information
            </h2>
            <div class="product-header">
                <table class="info-table">
                    <tr>
                        <td>Product Name:</td>
                        <td><strong style="font-size: 17px; color: #d32f2f;">{{ $product->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td>{!! $product->short_description ?? 'No short description available.' !!}</td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Subcategory:</td>
                        <td>{{ $product->subcategory->name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Materials Used:</td>
                        <td><strong>{{ $product->materials }}</strong></td>
                    </tr>
                    <tr>
                        <td>Delivery Time:</td>
                        <td>{{ $product->delivery_time ?? '-' }}</td>
                    </tr>

                    @foreach($product->variants as $index => $variant)
                    <tr>
                        <td>Minimum Order Quantity:</td>
                        <td><strong>{{ $variant->moq ?? '-' }}</strong></td>
                    </tr>

                    <tr>
                        <td>User Quantity Interested:</td>
                        <td><span class="highlight-value">{{ $inquiry->quantity }} Kg</span></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Product Images:</td>
                        <td>
                            @php
                                $images = $inquiry->selected_images ?? [];
                                $img = is_array($images) && count($images) > 0 ? $images[0] : null;
                            @endphp

                            @if($img)
                                <img src="{{ asset($img) }}" alt="Selected Image" class="gallery-image" style="width: 150px; height: 150px; object-fit: cover;" />
                            @else
                                <div class="no-images">No images selected</div>
                            @endif
                        </td>


                    </tr>
                    @endforeach
                    @endif
                </table>
            </div>

        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <p class="footer-greeting">Thank you for your interest in</p>
                <div class="footer-brand">{{ config('app.name') }}</div>
                <p class="footer-note">
                    This is an automated notification email.<br>
                    Please do not reply directly to this email.
                </p>
            </div>
        </div>

    </div>
</body>
</html>

@component('mail::message')
# New Product Inquiry Received

**Product Details:**

- **Product Name:** {{ $data['product']['name'] ?? 'N/A' }}
- **Product ID:** {{ $data['product']['id'] ?? 'N/A' }}
- **Description:** {{ $data['product']['description'] ?? 'N/A' }}
- **Delivery Days:** {{ $data['product']['delivery_days'] ?? 'N/A' }}

@isset($data['product']['variants'])
**Variants:**
@foreach($data['product']['variants'] as $variant)
- **Product Code:** {{ $variant['product_code'] }}
- **Color:** {{ $variant['color'] }}
- **Size:** {{ $variant['size'] }}
- **Minimum Order Qty:** {{ $variant['min_order_qty'] }}
- **Images:**
    @if(!empty($variant['images']))
        @foreach($variant['images'] as $img)
            ![image]({{ asset($img) }})
        @endforeach
    @else
        N/A
    @endif
@endforeach
@endisset

**User Details:**

- Name: {{ $data['user_name'] }}
- Company: {{ $data['company'] }}
- Email: {{ $data['user_email'] }}
- Phone: {{ $data['phone'] }}
- Country: {{ $data['country'] }}
- Quantity Interested: {{ $data['quantity'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

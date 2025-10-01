@component('mail::message')
# Thank you {{ $data['user_name'] ?? 'Customer' }}

We received your inquiry for the product:

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

**Your Details:**

- Name: {{ $data['user_name'] ?? 'N/A' }}
- Company: {{ $data['company'] ?? 'N/A' }}
- Email: {{ $data['user_email'] ?? 'N/A' }}
- Phone: {{ $data['phone'] ?? 'N/A' }}
- Country: {{ $data['country'] ?? 'N/A' }}

We will contact you soon with price details.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

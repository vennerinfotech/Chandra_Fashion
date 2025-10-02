@component('mail::message')
# Thank you {{ $data['user_name'] ?? 'Customer' }}

We received your inquiry for the product:

- **Product Name:** {{ $data['product']['name'] ?? 'N/A' }}
- **Description:** {{ $data['product']['description'] ?? 'N/A' }}
- **Materials:** {{ $data['product']['materials'] ?? 'N/A' }}
- **Delivery Days:** {{ $data['product']['delivery_days'] ?? 'N/A' }}

@if(!empty($data['product']['variants']))
**Variants:**
@foreach($data['product']['variants'] as $variant)
- **Product Code:** {{ $variant['product_code'] ?? 'N/A' }}
- **Color:** {{ $variant['color'] ?? 'N/A' }}
- **Size:** {{ is_array($variant['size']) ? implode(', ', $variant['size']) : $variant['size'] }}
- **Minimum Order Qty:** {{ $variant['min_order_qty'] ?? 'N/A' }}
- **Images:**
    @foreach($variant['images'] ?? [] as $img)
        <br><img src="{{ asset($img) }}" style="max-width:200px;"/>
    @endforeach
@endforeach
@endif

@if(!empty($data['selected_images']))
**Selected Images:**
@foreach($data['selected_images'] as $img)
    <br><img src="{{ asset($img) }}" style="max-width:200px;"/>
@endforeach
@endif

**Your Details:**

- Name: {{ $data['user_name'] ?? 'N/A' }}
- Company: {{ $data['company'] ?? 'N/A' }}
- Email: {{ $data['user_email'] ?? 'N/A' }}
- Phone: {{ $data['phone'] ?? 'N/A' }}
- Country: {{ $data['country'] ?? 'N/A' }}
- Quantity Interested: {{ $data['quantity'] ?? 'N/A' }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

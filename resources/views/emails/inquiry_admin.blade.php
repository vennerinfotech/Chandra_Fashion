@component('mail::message')
# New Product Inquiry Received

**Product Details:**

- **Name:** {{ $data['product']->name ?? 'N/A' }}
- **ID:** {{ $data['product']->id ?? 'N/A' }}

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

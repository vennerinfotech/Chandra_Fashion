@component('mail::message')
# Thank you {{ $data['user_name'] ?? 'Customer' }}

We received your inquiry for the product:

- **Product Name:** {{ $data['product']->name ?? 'N/A' }}
- **Product ID:** {{ $data['product']->id ?? 'N/A' }}
- **Quantity Interested:** {{ $data['quantity'] ?? 'N/A' }}

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

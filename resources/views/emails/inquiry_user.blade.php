@component('mail::message')
# Thank you {{ $user_name }}

We received your inquiry for the product:

- **Product Name:** {{ $product->name ?? 'N/A' }}
- **Product ID:** {{ $product->id ?? 'N/A' }}
- **Quantity Interested:** {{ $quantity }}

**Your Details:**

- Name: {{ $user_name }}
- Company: {{ $company }}
- Email: {{ $user_email }}
- Phone: {{ $phone }}
- Country: {{ $country }}

We will contact you soon with price details.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

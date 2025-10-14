<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\Country;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\InquiryUserMail;
use App\Mail\InquiryAdminMail;
use App\Jobs\SendInquiryEmails;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{

    public function store(Request $request)
    {
        Log::info('Inquiry Submit Request:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'quantity' => 'required|integer',
            'product_id' => 'nullable|exists:products,id',
            'selected_size' => 'nullable|string',      // JSON string from JS
            'selected_images' => 'nullable|string',    // JSON string from JS
            'variant_details' => 'nullable|string',    // JSON string from JS
        ]);

        // Decode JSON inputs safely
        $selected_size = $validated['selected_size'] ? json_decode($validated['selected_size'], true) : [];
        $selected_images = $validated['selected_images'] ? json_decode($validated['selected_images'], true) : [];
        $variant_details = $validated['variant_details'] ? json_decode($validated['variant_details'], true) : [];

        // Create Inquiry
        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'company' => $validated['company'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'],
            'city_id' => $validated['city_id'],
            'quantity' => $validated['quantity'],
            'product_id' => $validated['product_id'] ?? null,
            'selected_size' => $selected_size,
            'selected_images' => $selected_images,
            'variant_details' => $variant_details,
        ]);

        // Fetch product info (optional for admin)
        $product = null;
        if ($validated['product_id']) {
        $product = \App\Models\Product::with(['variants', 'category', 'subcategory'])->find($validated['product_id']);
        }

        // Send email to admin
        \Mail::send('emails.inquiry_admin', [
            'inquiry' => $inquiry,
            'product' => $product,
        ], function($message) {
            $message->to('sejalcontact12@gmail.com', 'Admin')
                    ->subject('New Product Inquiry Received');
        });

        // Send confirmation email to user
        \Mail::send('emails.inquiry_user', [
            'inquiry' => $inquiry,
            'product' => $product,
        ], function($message) use ($inquiry) {
            $message->to($inquiry->email, $inquiry->name)
                    ->subject('Your Product Inquiry Confirmation');
        });

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
    }


}

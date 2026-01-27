<?php

namespace App\Http\Controllers;

use App\Jobs\SendInquiryEmails;
use App\Mail\InquiryAdminMail;
use App\Mail\InquiryUserMail;
use App\Models\Country;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'selected_size' => 'nullable|string',
            'selected_images' => 'nullable|string',
            'variant_details' => 'nullable|string',
            'color' => 'nullable|string|max:255',
        ]);

        // Check if this name + email combination already exists
        // $exists = Inquiry::where('name', $validated['name'])
        //                 ->where('email', $validated['email'])
        //                 ->exists();

        // if ($exists) {
        //     return redirect()->back()
        //         ->with('error', 'An inquiry with this name and email already exists.');
        // }

        // Decode JSON safely
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
            'color' => $validated['color'] ?? null,
        ]);

        // Fetch product info (optional for admin)
        $product = $validated['product_id']
            ? Product::with(['variants', 'category', 'subcategory'])->find($validated['product_id'])
            : null;

        // Send emails (Admin & User)
        // Send email to admin
        Mail::send('emails.inquiry_admin', [
            'inquiry' => $inquiry,
            'product' => $product,
        ], function ($message) {
            $adminEmail = env('ADMIN_EMAIL');
            $message
                ->to($adminEmail, 'Admin')
                ->subject('New Product Inquiry Received');
        });

        Mail::send('emails.inquiry_user', ['inquiry' => $inquiry, 'product' => $product], function ($message) use ($inquiry) {
            $message
                ->to($inquiry->email, $inquiry->name)
                ->subject('Your Product Inquiry Confirmation');
        });

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
    }

    public function checkUser(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $query = Inquiry::query();

        if ($request->email) {
            $query->where('email', $request->email);
        } elseif ($request->name) {
            $query->where('name', $request->name);
        } else {
            return response()->json(['exists' => false]);
        }

        $user = $query->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'company' => $user->company,
                    'phone' => $user->phone,
                    'country_id' => $user->country_id,
                    'state_id' => $user->state_id,
                    'city_id' => $user->city_id,
                    'quantity' => $user->quantity,
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }
}

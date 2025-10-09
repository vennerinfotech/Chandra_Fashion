<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\InquiryUserMail;
use App\Mail\InquiryAdminMail;
use App\Jobs\SendInquiryEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class InquiryController extends Controller
{

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('products.inquiry_form', compact('countries'));
    }
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
    ]);

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
        'selected_size' => $validated['selected_size'] ? json_decode($validated['selected_size'], true) : [],
        'selected_images' => $validated['selected_images'] ? json_decode($validated['selected_images'], true) : [],
        'variant_details' => $validated['variant_details'] ? json_decode($validated['variant_details'], true) : [],
    ]);

    SendInquiryEmails::dispatch($inquiry);

    return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
}






}

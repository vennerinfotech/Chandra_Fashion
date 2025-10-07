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

class InquiryController extends Controller
{

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('products.inquiry_form', compact('countries'));
    }
public function store(Request $request)
{
    // Validate request
    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email',
        'company'         => 'nullable|string|max:255',
        'phone'           => 'nullable|string|max:50',
        'country_id'      => 'required|exists:countries,id',  // Ensure it's a valid country ID
        'state_id'        => 'required|exists:states,id',      // Ensure it's a valid state ID
        'city_id'         => 'required|exists:cities,id',      // Ensure it's a valid city ID
        'quantity'        => 'required|integer',
        'product_id'      => 'nullable|exists:products,id',
        'selected_size'   => 'nullable|string',  // JSON string
        'selected_images' => 'nullable|string',  // JSON string
        'variant_details' => 'nullable|string',  // JSON string
    ]);

    // Store inquiry in DB
    $inquiry = Inquiry::create([
        'name'            => $request->name,
        'company'         => $request->company,
        'email'           => $request->email,
        'phone'           => $request->phone,
        'country_id'      => $request->country_id,      // Store country_id instead of country name
        'state_id'        => $request->state_id,        // Store state_id instead of state name
        'city_id'         => $request->city_id,         // Store city_id instead of city name
        'quantity'        => $request->quantity,
        'product_id'      => $request->product_id,
        'selected_size'   => $request->selected_size ? json_decode($request->selected_size, true) : [],
        'selected_images' => $request->selected_images ? json_decode($request->selected_images, true) : [],
        'variant_details' => $request->variant_details ? json_decode($request->variant_details, true) : [],
    ]);

    // Dispatch email job to send both admin & user emails
    SendInquiryEmails::dispatch($inquiry);

    return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
}





}

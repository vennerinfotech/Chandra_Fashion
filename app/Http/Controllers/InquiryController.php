<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\InquiryUserMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryAdminMail;

class InquiryController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'name'       => 'required|string|max:255',
        'email'      => 'required|email',
        'country'    => 'required|string',
        'quantity'   => 'required|integer',
        'product_id' => 'nullable|exists:products,id',
    ]);

    $inquiry = Inquiry::create($request->all());
    $product = $request->product_id ? Product::find($request->product_id) : null;

    $data = [
        'user_name'  => $request->name,
        'user_email' => $request->email,
        'company'    => $request->company ?? '',
        'phone'      => $request->phone ?? '',
        'country'    => $request->country,
        'quantity'   => $request->quantity,
        'product'    => $product,
    ];

    // Queue emails
    Mail::to($request->email)->queue(new InquiryUserMail($data));
    Mail::to(env('ADMIN_EMAIL'))->queue(new InquiryAdminMail($data));

    return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
}

}

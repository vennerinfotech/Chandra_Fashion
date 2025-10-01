<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\InquiryUserMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryAdminMail;
use App\Jobs\SendInquiryEmails;
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
    $product = $request->product_id ? Product::with('variants')->find($request->product_id) : null;

    $productData = null;

    if ($product) {
        $variantsData = $product->variants->map(function($variant) {
            return [
                'product_code'    => $variant->product_code,
                'color'           => $variant->color,
                'size'            => $variant->size,
                'min_order_qty'   => $variant->moq,
                'images'          => json_decode($variant->images, true), // decode JSON images
            ];
        })->toArray();

        $productData = [
            'id'          => $product->id,
            'name'        => $product->name,
            'description' => $product->description ?? '',
            'variants'    => $variantsData,
            'delivery_days' => $product->delivery_time ?? 'N/A',
        ];
    }

    $data = [
        'user_name'  => $request->name,
        'user_email' => $request->email,
        'company'    => $request->company ?? '',
        'phone'      => $request->phone ?? '',
        'country'    => $request->country,
        'quantity'   => $request->quantity,
        'product'    => $productData,
    ];

    // Dispatch job to send emails
    SendInquiryEmails::dispatch($data);

    return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
}



}

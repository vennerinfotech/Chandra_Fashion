<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'country'  => 'required|string',
            'quantity' => 'required|integer',
            'product_id' => 'nullable|exists:products,id',
        ]);

        Inquiry::create($request->all());

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
    }

}

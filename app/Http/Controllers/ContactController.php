<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     // Show contact form
    public function index()
    {
        return view('contact');
    }

    // Store form data into DB
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'message' => 'required|string'
        ]);

        Contact::create($validated);

        return back()->with('success', 'Thank you! Your message has been sent.');
    }
}

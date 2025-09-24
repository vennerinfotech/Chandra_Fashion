<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = Inquiry::with('product')->latest()->paginate(10);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = Inquiry::with('product')->findOrFail($id);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inquiry = Inquiry::findOrFail($id);

        try {
            $inquiry->delete();
            return redirect()->route('admin.inquiries.index')
                            ->with('success', 'Inquiry deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.inquiries.index')
                            ->with('error', 'Failed to delete inquiry.');
        }
    }
}

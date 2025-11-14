<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;
use App\Exports\NewsletterExport;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all subscriptions with pagination
        $subscriptions = NewsletterSubscription::latest()->paginate(20);

        return view('admin.newsletter.index', compact('subscriptions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subscription = NewsletterSubscription::findOrFail($id);

        return view('admin.newsletter.show', compact('subscription'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subscription = NewsletterSubscription::findOrFail($id);
            $subscription->delete();

            return redirect()->route('admin.newsletters.index')
                ->with('success', 'Subscription deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.newsletters.index')
                ->with('error', 'Failed to delete subscription.');
        }
    }

    public function export(Request $request)
    {
        return Excel::download(
            new NewsletterExport(
                $request->from_date,
                $request->to_date
            ),
            'newsletter_subscriptions.xlsx'
        );
    }
}

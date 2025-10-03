<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inquiry;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total counts
        $totalCategories = Category::count();
        $totalProducts   = Product::count();
        $totalInquiries  = Inquiry::count();

        // Determine chart type: 'month' or 'day' (default: day)
        $chartType = $request->get('chart', 'day'); // <-- changed here

        if ($chartType === 'day') {
            // Last 30 days
            $startDate = Carbon::now()->subDays(29)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();

            $inquiriesData = Inquiry::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');

            $days = [];
            $totals = [];
            for ($i = 0; $i < 30; $i++) {
                $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                $days[] = $startDate->copy()->addDays($i)->format('d M'); // e.g., 03 Oct
                $totals[] = $inquiriesData[$date] ?? 0;
            }

        } else {
            // Month-wise (current year)
            $inquiriesData = Inquiry::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('total', 'month');

            $days = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $totals = [];
            for ($m = 1; $m <= 12; $m++) {
                $totals[] = $inquiriesData[$m] ?? 0;
            }
        }

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalInquiries',
            'days',
            'totals',
            'chartType'
        ));
    }
}

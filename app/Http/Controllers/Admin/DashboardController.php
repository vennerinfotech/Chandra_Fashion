<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // -------------------
        // Total counts
        // -------------------
        $totalCategories = Category::count();
        $totalProducts   = Product::count();
        $totalInquiries  = Inquiry::count();

        // -------------------
        // Chart type: 'month' or 'day'
        // -------------------
        $chartType = $request->get('chart', 'day');

        // -------------------
        // Line chart data
        // -------------------
        if ($chartType === 'day') {
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
                $days[] = $startDate->copy()->addDays($i)->format('d M');
                $totals[] = $inquiriesData[$date] ?? 0;
            }

        } else {
            $inquiriesData = Inquiry::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('total', 'month');

            $days = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            $totals = [];
            for ($m = 1; $m <= 12; $m++) {
                $totals[] = $inquiriesData[$m] ?? 0;
            }
        }

        // -------------------
        // Product-wise inquiries (Pie chart)
        // Using inquiry 'name' as product/variant name
        // -------------------
        $productInquiries = Inquiry::select('name', DB::raw('COUNT(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name');

        // -------------------
        // User-wise inquiries (Pie chart)
        // -------------------
        $userInquiries = Inquiry::select('name', DB::raw('COUNT(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name');

        // -------------------
        // Pass all data to Blade
        // -------------------
        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalInquiries',
            'days',
            'totals',
            'chartType',
            'productInquiries',
            'userInquiries'
        ));
    }
}

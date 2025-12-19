<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductImportLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total counts
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalInquiries = Inquiry::count();

        // Chart type: 'month' or 'day'
        $chartType = $request->get('chart', 'day');

        // Line chart data
        if ($chartType === 'day') {
            $startDate = Carbon::now()->subDays(29)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

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

            $days = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $totals = [];
            for ($m = 1; $m <= 12; $m++) {
                $totals[] = $inquiriesData[$m] ?? 0;
            }
        }

        // Product-wise inquiries (Pie chart)  Using inquiry 'name' as product/variant name
        // $productInquiries = Inquiry::select('name', DB::raw('COUNT(*) as total'))
        //     ->groupBy('name')
        //     ->pluck('total', 'name');

        // Product-wise inquiries (Pie chart) using product name
        $productInquiries = Inquiry::join('products', 'inquiries.product_id', '=', 'products.id')
            ->select(DB::raw('products.name as product_name'), DB::raw('COUNT(*) as total'))
            ->groupBy('products.name')
            ->pluck('total', 'product_name');

        // User-wise inquiries (Pie chart)
        // $userInquiries = Inquiry::select('name', DB::raw('COUNT(*) as total'))
        //     ->groupBy('name')
        //     ->pluck('total', 'name');

        // User-wise inquiries (Pie chart) - Top 3 users
        $userInquiries = Inquiry::select('name', DB::raw('COUNT(*) as total'))
            ->groupBy('name')
            ->orderByDesc('total')  // order by highest count
            ->take(10)  // take only top 3
            ->pluck('total', 'name');

        // User-wise inquiries (Pie chart) using "Name (Email)" as label
        // $userInquiries = Inquiry::select(DB::raw("CONCAT(name, ' (', email, ')') as label"), DB::raw('COUNT(*) as total'))
        //     ->groupBy('label')
        //     ->pluck('total', 'label');

        // Fetch recent import logs (last 5)
        $recentImports = ProductImportLog::latest()
            ->take(5)
            ->get();

        // Pass all data to Blade
        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalInquiries',
            'days',
            'totals',
            'chartType',
            'productInquiries',
            'userInquiries',
            'recentImports'
        ));
    }

    // public function index(Request $request)
    // {
    //     // ------------------- Total counts -------------------
    //     $totalCategories = Category::count();
    //     $totalProducts   = Product::count();
    //     $totalInquiries  = Inquiry::count();

    //     // ------------------- Chart type -------------------
    //     $chartType = $request->get('chart', 'day');

    //     // ------------------- Line chart data -------------------
    //     if ($chartType === 'day') {
    //         $startDate = Carbon::now()->subDays(29)->startOfDay();
    //         $endDate   = Carbon::now()->endOfDay();

    //         $inquiriesData = Inquiry::whereBetween('created_at', [$startDate, $endDate])
    //             ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
    //             ->groupBy('date')
    //             ->orderBy('date')
    //             ->pluck('total', 'date');

    //         $days = [];
    //         $totals = [];
    //         for ($i = 0; $i < 30; $i++) {
    //             $date = $startDate->copy()->addDays($i)->format('Y-m-d');
    //             $days[] = $startDate->copy()->addDays($i)->format('d M');
    //             $totals[] = $inquiriesData[$date] ?? 0;
    //         }

    //     } else {
    //         $inquiriesData = Inquiry::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
    //             ->whereYear('created_at', date('Y'))
    //             ->groupBy('month')
    //             ->pluck('total', 'month');

    //         $days = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    //         $totals = [];
    //         for ($m = 1; $m <= 12; $m++) {
    //             $totals[] = $inquiriesData[$m] ?? 0;
    //         }
    //     }

    //     // ------------------- Product-wise inquiries -------------------
    //     $productInquiries = Inquiry::join('products', 'inquiries.product_id', '=', 'products.id')
    //         ->select('products.name', DB::raw('COUNT(inquiries.id) as total'))
    //         ->groupBy('products.name')
    //         ->pluck('total', 'products.name');

    //     // ------------------- User-wise inquiries -------------------
    //     $userInquiries = Inquiry::join('users', 'inquiries.user_id', '=', 'users.id')
    //         ->select('users.name', DB::raw('COUNT(inquiries.id) as total'))
    //         ->groupBy('users.name')
    //         ->pluck('total', 'users.name');

    //     // ------------------- Pass data to Blade -------------------
    //     return view('admin.dashboard', compact(
    //         'totalCategories',
    //         'totalProducts',
    //         'totalInquiries',
    //         'days',
    //         'totals',
    //         'chartType',
    //         'productInquiries',
    //         'userInquiries'
    //     ));
    // }

    // dashboard.blade file add chart code
    // // Product Pie Chart
    // labels: @json(array_keys($productInquiries->toArray())),
    // data: @json(array_values($productInquiries->toArray())),

    // // User Pie Chart
    // labels: @json(array_keys($userInquiries->toArray())),
    // data: @json(array_values($userInquiries->toArray())),
}

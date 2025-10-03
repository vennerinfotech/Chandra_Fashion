<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalCategories = Category::count();
        $totalProducts   = Product::count();
        $totalInquiries  = Inquiry::count();

        // Top inquired products (optional)
        $topInquiredProducts = Inquiry::select('product_id')
            ->withCount('product') // if Inquiry has relation with Product
            ->groupBy('product_id')
            ->orderByRaw('COUNT(*) DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalInquiries',
            'topInquiredProducts'
        ));
    }
}

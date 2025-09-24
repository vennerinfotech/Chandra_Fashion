<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->whereIn('category', $request->category);
        }

        if ($request->filled('fabric')) {
            $query->whereIn('fabric', $request->fabric);
        }

        if ($request->filled('moq_range')) {
            $query->where(function($q) use ($request) {
                foreach ($request->moq_range as $range) {
                    if ($range === '50-100') {
                        $q->orWhereBetween('moq', [50, 100]);
                    } elseif ($range === '100-500') {
                        $q->orWhereBetween('moq', [100, 500]);
                    } elseif ($range === '500+') {
                        $q->orWhere('moq', '>=', 500);
                    }
                }
            });
        }

        if ($request->has('export_ready_only')) {
            $query->where('export_ready', true);
        }

         $totalProducts = $query->count();

         $sort = $request->get('sort', 'latest');

        if ($sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(6)->withQueryString();

        return view('products.index', compact('products', 'totalProducts'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Decode JSON fields if stored as JSON strings
        // $product->gallery = json_decode($product->gallery, true);
        // $product->colors = json_decode($product->colors, true);
        // $product->sizes = json_decode($product->sizes, true);

        return view('products.show', compact('product'));
    }

}

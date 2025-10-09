<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductController extends Controller
{

    // public function index(Request $request)
    // {
    //     $query = Product::query()->with('variants', 'category')
    //         ->whereHas('category', function($q) {
    //             $q->where('status', 1);
    //         });


    //     // --- Dynamic Filters ---

    //     $categories = Category::where('status', 1)->pluck('name', 'id'); // key = id, value = name
    //     $fabrics = Product::select('materials')
    //                 ->distinct()
    //                 ->whereNotNull('materials')
    //                 ->pluck('materials');
    //     $moqRanges = ['50-100', '100-500', '500+'];

    //     // --- Apply Filters ---

    //     if ($request->filled('category')) {
    //         $query->whereIn('category_id', $request->category); // use category_id instead of category
    //     }

    //     if ($request->filled('fabric')) {
    //         $query->whereIn('materials', $request->fabric);
    //     }

    //     if ($request->filled('moq_range')) {
    //         $query->where(function($q) use ($request) {
    //             // Check variants
    //             $q->whereHas('variants', function($q2) use ($request) {
    //                 $q2->where(function($q3) use ($request) {
    //                     foreach ($request->moq_range as $range) {
    //                         if ($range === '50-100') $q3->orWhereBetween('moq', [50, 100]);
    //                         elseif ($range === '100-500') $q3->orWhereBetween('moq', [100, 500]);
    //                         elseif ($range === '500+') $q3->orWhere('moq', '>=', 500);
    //                     }
    //                 });
    //             })
    //             // Or check product itself if no variants
    //             ->orWhere(function($q2) use ($request) {
    //                 foreach ($request->moq_range as $range) {
    //                     if ($range === '50-100') $q2->orWhereBetween('moq', [50, 100]);
    //                     elseif ($range === '100-500') $q2->orWhereBetween('moq', [100, 500]);
    //                     elseif ($range === '500+') $q2->orWhere('moq', '>=', 500);
    //                 }
    //             });
    //         });
    //     }



    //     if ($request->has('export_ready_only')) {
    //         $query->where('export_ready', true);
    //     }

    //     $totalProducts = $query->count();

    //     $sort = $request->get('sort', 'latest');
    //     if ($sort == 'price_asc') {
    //         $query->orderBy('price', 'asc');
    //     } elseif ($sort == 'price_desc') {
    //         $query->orderBy('price', 'desc');
    //     } else {
    //         $query->orderBy('created_at', 'desc');
    //     }

    //     $products = $query->paginate(6)->withQueryString();

    //     return view('products.index', compact(
    //         'products',
    //         'totalProducts',
    //         'categories',
    //         'fabrics',
    //         'moqRanges'
    //     ));
    // }



    public function index(Request $request)
    {
        $query = Product::query()->with('variants', 'category', 'subcategory')
            ->whereHas('category', function ($q) {
                $q->where('status', 1);
            });

        // --- Dynamic Filters ---

        $categories = Category::where('status', 1)->pluck('name', 'id');
        $fabrics = Product::select('materials')->distinct()->whereNotNull('materials')->pluck('materials');
        $moqRanges = ['50-100', '100-500', '500+'];

        // --- Apply Filters ---

        if ($request->filled('category')) {
            $query->whereIn('category_id', (array) $request->category);
        }

        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        if ($request->filled('fabric')) {
            $query->whereIn('materials', (array) $request->fabric);
        }

        if ($request->filled('moq_range')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('variants', function ($q2) use ($request) {
                    $q2->where(function ($q3) use ($request) {
                        foreach ($request->moq_range as $range) {
                            if ($range === '50-100') $q3->orWhereBetween('moq', [50, 100]);
                            elseif ($range === '100-500') $q3->orWhereBetween('moq', [100, 500]);
                            elseif ($range === '500+') $q3->orWhere('moq', '>=', 500);
                        }
                    });
                })->orWhere(function ($q2) use ($request) {
                    foreach ($request->moq_range as $range) {
                        if ($range === '50-100') $q2->orWhereBetween('moq', [50, 100]);
                        elseif ($range === '100-500') $q2->orWhereBetween('moq', [100, 500]);
                        elseif ($range === '500+') $q2->orWhere('moq', '>=', 500);
                    }
                });
            });
        }

        if ($request->has('export_ready_only')) {
            $query->where('export_ready', true);
        }

        // --- Sorting ---
        $sort = $request->get('sort', 'latest');
        if ($sort == 'price_asc') $query->orderBy('price', 'asc');
        elseif ($sort == 'price_desc') $query->orderBy('price', 'desc');
        else $query->orderBy('created_at', 'desc');

        $totalProducts = $query->count();
        $products = $query->paginate(6)->withQueryString();

        return view('products.index', compact(
            'products',
            'totalProducts',
            'categories',
            'fabrics',
            'moqRanges'
        ));
    }
    public function show($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        $colors = $product->variants->pluck('color')->unique()->values()->all();
        $countries = Country::orderBy('name', 'asc')->get();

        $colorImages = [];
        $sizesByColor = [];
        $skuByColor = [];
        $moqByColor = [];
        $deliveryByColor = [];

        foreach ($product->variants as $variant) {
            // Ensure images are arrays
            $imgs = is_array($variant->images) ? $variant->images : json_decode($variant->images, true);
            $colorImages[$variant->color] = $imgs;

            // Collect sizes per color
            $sizesByColor[$variant->color][] = $variant->size;

            // Collect SKU per color
            $skuByColor[$variant->color] = $variant->product_code;

            // Collect MOQ per color (fallback to product MOQ)
            $moqByColor[$variant->color] = $variant->moq ?? $product->moq ?? 100;

            // Collect Delivery per color (fallback to product delivery_time)
            $deliveryByColor[$variant->color] = $variant->delivery_time ?? $product->delivery_time ?? '15-20';
        }

        // Pass everything to Blade
        return view('products.show', compact(
            'product',
            'colors',
            'countries',
            'colorImages',
            'sizesByColor',
            'skuByColor',
            'moqByColor',
            'deliveryByColor'
        ));
    }
}

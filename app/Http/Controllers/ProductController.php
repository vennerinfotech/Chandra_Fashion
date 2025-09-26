<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::query()->with('variants', 'category')
            ->whereHas('category', function($q) {
                $q->where('status', 1);
            });


        // --- Dynamic Filters ---

        $categories = Category::where('status', 1)->pluck('name', 'id'); // key = id, value = name
        $fabrics = Product::select('materials')
                    ->distinct()
                    ->whereNotNull('materials')
                    ->pluck('materials');
        $moqRanges = ['50-100', '100-500', '500+'];

        // --- Apply Filters ---

        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category); // use category_id instead of category
        }

        if ($request->filled('fabric')) {
            $query->whereIn('materials', $request->fabric);
        }

        if ($request->filled('moq_range')) {
            $query->where(function($q) use ($request) {
                // Check variants
                $q->whereHas('variants', function($q2) use ($request) {
                    $q2->where(function($q3) use ($request) {
                        foreach ($request->moq_range as $range) {
                            if ($range === '50-100') $q3->orWhereBetween('moq', [50, 100]);
                            elseif ($range === '100-500') $q3->orWhereBetween('moq', [100, 500]);
                            elseif ($range === '500+') $q3->orWhere('moq', '>=', 500);
                        }
                    });
                })
                // Or check product itself if no variants
                ->orWhere(function($q2) use ($request) {
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

        $colorImages = [];
        $sizesByColor = [];
        $skuByColor = [];

        foreach ($product->variants as $variant) {
            // Ensure images are arrays
            $imgs = is_array($variant->images) ? $variant->images : json_decode($variant->images, true);

            $colorImages[$variant->color] = $imgs;

            // Collect sizes per color
            $sizesByColor[$variant->color][] = $variant->size;

            // Collect SKU per color
            $skuByColor[$variant->color] = $variant->product_code;
        }

        // Pass everything to Blade
        return view('products.show', compact(
            'product',
            'colors',
            'colorImages',
            'sizesByColor',
            'skuByColor'
        ));

    }




}

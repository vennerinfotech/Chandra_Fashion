<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $products = Product::latest()->paginate(10); // paginate 10 per page
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.products.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'materials' => 'nullable|string|max:255',
            'export_ready' => 'boolean',
            'price' => 'nullable|numeric',
            'delivery_time' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',

            // Variants
            'variants' => 'required|array',
            'variants.*.product_code' => 'required|string|max:255',
            'variants.*.color' => 'nullable|string|max:100',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.moq' => 'nullable|integer',
            'variants.*.images' => 'nullable|array',
            'variants.*.images.*' => 'nullable|image|max:2048',
        ]);

        // Handle main product image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/'.$imageName;
        }

        // Create product
        $product = Product::create($data);

        // Handle variants
        foreach ($request->variants as $variantData) {
            $variant = ProductVariant::updateOrCreate(
                ['id' => $variantData['id'] ?? null],
                [
                    'product_id' => $product->id,
                    'product_code' => $variantData['product_code'],
                    'color' => $variantData['color'] ?? null,
                    'size' => $variantData['size'] ?? null,
                    'moq' => $variantData['moq'] ?? null,
                ]
            );

            // Handle variant images
            if(isset($variantData['images'])){
                $images = [];
                foreach ($variantData['images'] as $imageFile) {
                    $imageName = time().'_'.$imageFile->getClientOriginalName();
                    $imageFile->move(public_path('images/variants'), $imageName);
                    $images[] = 'images/variants/'.$imageName;
                }
                $variant->images = json_encode($images); // store as JSON
                $variant->save();
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 1)->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'fabric' => 'nullable|string|max:255',
            'moq' => 'nullable|integer',
            'export_ready' => 'boolean',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
            'colors' => 'nullable',
            'sizes' => 'nullable',
            'tags' => 'nullable',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        // Normalize arrays
        $data['colors'] = $request->filled('colors') ? (is_array($request->colors) ? $request->colors : explode(',', $request->colors)) : [];
        $data['sizes'] = $request->filled('sizes') ? (is_array($request->sizes) ? $request->sizes : explode(',', $request->sizes)) : [];
        $data['tags'] = $request->filled('tags') ? (is_array($request->tags) ? $request->tags : explode(',', $request->tags)) : [];

        // Handle main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image_url'] = 'images/products/'.$imageName;
        }

        // Handle gallery
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $imageName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/products/gallery'), $imageName);
                $galleryPaths[] = 'images/products/gallery/'.$imageName;
            }
            $data['gallery'] = json_encode($galleryPaths);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        if ($product->gallery) {
            $gallery = is_array($product->gallery)
                ? $product->gallery
                : json_decode($product->gallery, true);

            foreach ((array) $gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

}

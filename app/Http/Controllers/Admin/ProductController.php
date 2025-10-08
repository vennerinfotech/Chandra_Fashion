<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $subcategories = []; // empty initially
        return view('admin.products.create', compact('categories', 'subcategories'));
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
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'materials' => 'nullable|string|max:255',
            'export_ready' => 'boolean',
            'price' => 'required|numeric|min:1',
            'delivery_time' => ['nullable', 'regex:/^\d+(-\d+)?$/'],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'variants' => 'required|array|min:1',
            'variants.*.product_code' => 'required|integer|distinct',
            'variants.*.color' => 'nullable|string|max:100',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.moq' => 'nullable|integer',
            'variants.*.images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Check for duplicate colors
        $colors = array_map(fn($v) => strtolower(trim($v['color'] ?? '')), $data['variants']);
        if (count($colors) !== count(array_unique($colors))) {
            return back()->withInput()->withErrors(['variants' => 'Each variant must have a unique color.']);
        }

        // Handle main product image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        // Create product
        $product = Product::create($data);

        // Handle variants
        foreach ($data['variants'] as $variantData) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'product_code' => $variantData['product_code'],
                'color' => $variantData['color'] ?? null,
                'size' => $variantData['size'] ?? null,
                'moq' => $variantData['moq'] ?? null,
            ]);

            // Handle variant images
            if (!empty($variantData['images'])) {
                $images = [];
                foreach ($variantData['images'] as $imageFile) {
                    if ($imageFile) {  // ignore null
                        $imageName = time() . '_' . $imageFile->getClientOriginalName();
                        $imageFile->move(public_path('images/variants'), $imageName);
                        $images[] = 'images/variants/' . $imageName;
                    }
                }
                if (!empty($images)) {
                    $variant->images = json_encode($images);
                    $variant->save();
                }
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

        // Load subcategories of selected category
        $subcategories = $product->category_id
            ? \App\Models\SubCategory::where('category_id', $product->category_id)
            ->where('status', 1)->get()
            : [];

        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json(['subcategories' => $subcategories]);
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
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'materials' => 'nullable|string|max:255',
            'export_ready' => 'boolean',
            'price' => 'nullable|numeric',
            'delivery_time' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'variants' => 'required|array|min:1',
        ]);

        // Main product image
        if ($request->hasFile('image')) {
            if ($product->image) @unlink(public_path($product->image));
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product->update($data);

        $variantIds = [];

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

            $variantIds[] = $variant->id;

            // Remove old images
            $existing = $variant->images ? json_decode($variant->images, true) : [];
            if (!empty($variantData['removed_images'])) {
                $removed = json_decode($variantData['removed_images'], true);
                foreach ($removed as $img) {
                    @unlink(public_path($img));
                    $existing = array_filter($existing, fn($e) => $e != $img);
                }
            }

            // Add new images
            if (isset($variantData['images'])) {
                foreach ($variantData['images'] as $file) {
                    $imageName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('images/variants'), $imageName);
                    $existing[] = 'images/variants/' . $imageName;
                }
            }

            $variant->images = json_encode(array_values($existing));
            $variant->save();
        }

        // Remove variants that were deleted
        $product->variants()->whereNotIn('id', $variantIds)->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Product $product)
    {
        // Delete main product image
        if ($product->image) {
            @unlink(public_path($product->image));
        }

        // Delete all variant images
        foreach ($product->variants as $variant) {
            if ($variant->images) {
                foreach (json_decode($variant->images) as $img) {
                    @unlink(public_path($img));
                }
            }
            $variant->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}

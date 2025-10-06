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
        $products = Product::with('category')->latest()->paginate(10); // paginate 10 per page
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
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'materials' => 'required|string|max:255',
            'export_ready' => 'boolean',
            'price' => 'required|integer|min:1',
            'delivery_time' => ['required','regex:/^\d+(-\d+)?$/'], // 10 or 10-20
            // 'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',

            // Variants
            'variants' => 'required|array|min:1',
            'variants.*.product_code' => 'required|integer|unique:product_variants,product_code',
            'variants.*.color' => 'required|string|max:100',
            'variants.*.size' => ['required','regex:/^([a-zA-Z0-9]+)(,[a-zA-Z0-9]+)*$/'], // comma separated
            'variants.*.moq' => 'required|integer|min:1',
            'variants.*.images.*' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'name.required' => 'Product name is required.',
            'category_id.required' => 'Please select a category.',
            'price.required' => 'Base price is required.',
            'price.integer' => 'Base price must be a number.',
            'delivery_time.regex' => 'Delivery time must be like "10" or "10-20".',
            'variants.required' => 'At least one product variant is required.',
            'variants.*.product_code.required' => 'Each variant needs a product code.',
            'variants.*.product_code.integer' => 'Product code must be a number.',
            'variants.*.product_code.unique' => 'This product code already exists.',
            'variants.*.color.required' => 'Please enter a color for each variant.',
            'variants.*.size.regex' => 'Sizes must be comma separated like S,M,L.',
            'variants.*.moq.integer' => 'MOQ must be a number.',
            'variants.*.images.*.image' => 'Variant images must be valid image files.',
        ]);

        // Check for duplicate colors
        $colors = array_map(fn($v) => strtolower(trim($v['color'])), $data['variants']);
        if (count($colors) !== count(array_unique($colors))) {
            return back()->withInput()->withErrors(['variants' => 'Each variant must have a unique color.']);
        }

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
        foreach ($data['variants'] as $variantData) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'product_code' => $variantData['product_code'],
                'color' => $variantData['color'],
                'size' => $variantData['size'] ?? null,
                'moq' => $variantData['moq'] ?? null,
            ]);

            // Handle variant images
            if (!empty($variantData['images'])) {
                $images = [];
                foreach ($variantData['images'] as $imageFile) {
                    $imageName = time().'_'.$imageFile->getClientOriginalName();
                    $imageFile->move(public_path('images/variants'), $imageName);
                    $images[] = 'images/variants/'.$imageName;
                }
                $variant->images = json_encode($images);
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
            'materials' => 'nullable|string|max:255',
            'export_ready' => 'boolean',
            'price' => 'nullable|numeric',
            'delivery_time' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'variants' => 'required|array',
        ]);

        // Validate each variant separately
        foreach ($request->variants as $idx => $variantData) {
            $request->validate([
                "variants.$idx.product_code" => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('product_variants', 'product_code')
                        ->ignore($variantData['id'] ?? null), // ignore current variant
                ],
                "variants.$idx.color" => 'nullable|string|max:100',
                "variants.$idx.size" => 'nullable|string|max:50',
                "variants.$idx.moq" => 'nullable|integer',
                "variants.$idx.images.*" => 'nullable|image|max:2048',
            ]);
        }

        // Handle main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/'.$imageName;
        }

        $product->update($data);

        // Save/update variants
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

            // Handle images...
            if (isset($variantData['images'])) {
                $images = [];
                foreach ($variantData['images'] as $imageFile) {
                    $imageName = time().'_'.$imageFile->getClientOriginalName();
                    $imageFile->move(public_path('images/variants'), $imageName);
                    $images[] = 'images/variants/'.$imageName;
                }
                $existing = $variant->images ? json_decode($variant->images, true) : [];
                $variant->images = json_encode(array_merge($existing, $images));
                $variant->save();
            }
        }

        // Remove deleted variants
        // $product->variants()->whereNotIn('id', $variantIds)->delete();

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

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
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
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */


     public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
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
        $data['colors'] = $request->filled('colors') ? explode(',', $request->input('colors')) : [];
        $data['sizes']  = $request->filled('sizes') ? explode(',', $request->input('sizes')) : [];
        $data['tags']   = $request->filled('tags') ? explode(',', $request->input('tags')) : [];

        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $data['image_url'] = 'uploads/products/'.$imageName; // save relative path
        }

        // Handle gallery upload
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/products/gallery'), $fileName);
                $galleryPaths[] = 'uploads/products/gallery/'.$fileName;
            }
            $data['gallery'] = $galleryPaths; // save array of relative paths
        }

        Product::create($data);

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

        return view('admin.products.edit', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
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

        //  Normalize arrays
        $data['colors'] = $request->filled('colors')
            ? (is_array($request->colors) ? $request->colors : explode(',', $request->colors))
            : [];

        $data['sizes'] = $request->filled('sizes')
            ? (is_array($request->sizes) ? $request->sizes : explode(',', $request->sizes))
            : [];

        $data['tags'] = $request->filled('tags')
            ? (is_array($request->tags) ? $request->tags : explode(',', $request->tags))
            : [];

        //  Handle image upload
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        //  Handle gallery upload
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
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

<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductImportFormatExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $subcategories = [];

        // Auto-generate next product code
        // $lastCode = ProductVariant::max('product_code');
        // $nextCode = $lastCode ? $lastCode + 1 : 1001; // Starting from 1001

        // Create an empty product instance so Blade has it
        $product = new Product();
        return view('admin.products.create', compact('categories', 'subcategories', 'product'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        // Increase execution time and memory for large imports with images
        set_time_limit(0);  // Unlimited execution time
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '1024M');  // 1GB memory for large imports (1800-2000+ products)

        try {
            $file = $request->file('file');

            // Clear any previous import cancellation flag
            session()->forget('import_cancelled');

            // Create session key for progress tracking
            $sessionKey = 'import_progress_' . time();
            session(['current_import_key' => $sessionKey]);

            // Initialize progress
            \Cache::put($sessionKey, [
                'total' => 0,
                'current' => 0,
                'percentage' => 0,
                'status' => 'starting'
            ], now()->addHours(1));

            // Try to count rows (best effort)
            $totalRows = 0;
            try {
                $tempImport = new \App\Imports\ProductsImport(0, 'temp_count_' . time());
                $reader = \Maatwebsite\Excel\Facades\Excel::toCollection($tempImport, $file);
                $totalRows = $reader->first()->count();
            } catch (\Exception $e) {
                // If counting fails, proceed without exact count
                \Log::warning('Could not count rows for progress: ' . $e->getMessage());
            }

            // Create import instance with total rows
            $importWithProgress = new \App\Imports\ProductsImport($totalRows, $sessionKey);

            // Perform the import
            Excel::import($importWithProgress, $file);

            // Mark as completed
            \Cache::put($sessionKey, [
                'total' => $totalRows,
                'current' => $totalRows,
                'percentage' => 100,
                'status' => 'completed'
            ], now()->addHours(1));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $messages = [];

            foreach ($e->failures() as $failure) {
                $row = $failure->row();
                $errors = implode(', ', $failure->errors());
                $messages[] = "Row {$row}: {$errors}";
            }

            return back()
                ->withErrors(['import_error' => 'Import validation failed. Please check the error details below.'])
                ->with('validation_details', $messages);
        } catch (\Exception $e) {
            \Log::error('Product import failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()->withErrors([
                'import_error' => 'Import failed. Please verify your file format is correct and all required columns are present. If the issue persists, please contact support.'
            ]);
        }

        return back()->with('success', 'Products imported successfully!');
    }

    public function importProgress()
    {
        $sessionKey = session('current_import_key', 'import_progress');
        $progress = \Cache::get($sessionKey, [
            'total' => 0,
            'current' => 0,
            'percentage' => 0,
            'status' => 'idle'
        ]);

        return response()->json($progress);
    }

    public function cancelImport()
    {
        // Set cancel flag in session
        $sessionKey = session('current_import_key', 'import_progress');
        session(['import_cancelled' => true]);

        // Update cache status
        \Cache::put($sessionKey, [
            'total' => 0,
            'current' => 0,
            'percentage' => 0,
            'status' => 'cancelled'
        ], now()->addHours(1));

        \Log::info('🛑 Import cancellation requested by user');

        return response()->json(['success' => true, 'message' => 'Import cancellation requested']);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function downloadImportFormat()
    // {
    //     $filename = "product_import_format.csv";
    //     $headers = [
    //         "Content-type"        => "text/csv",
    //         "Content-Disposition" => "attachment; filename=$filename",
    //         "Pragma"              => "no-cache",
    //         "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
    //         "Expires"             => "0"
    //     ];
    //     $columns = [
    //         'name',
    //         'description',
    //         'short_description',
    //         'care_instructions',
    //         'materials',
    //         'price',
    //         'category',
    //         'subcategory',
    //         'product_code',
    //         'images',
    //         'moq',
    //         'gsm',
    //         'dai',
    //         'chadti'
    //     ];
    //     // Convert all column headers to uppercase
    //     $columns = array_map('strtoupper', $columns);
    //     $callback = function () use ($columns) {
    //         $file = fopen('php://output', 'w');
    //         fputcsv($file, $columns);
    //         fclose($file);
    //     };
    //     return response()->stream($callback, 200, $headers);
    // }
    public function downloadImportFormat()
    {
        return Excel::download(new ProductImportFormatExport, 'product_import_format.xlsx');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'care_instructions' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'materials' => 'required|string|max:255',
            'export_ready' => 'boolean',
            'price' => 'required|regex:/^[0-9]+$/',
            'delivery_time' => ['required', 'regex:/^\d+(-\d+)?$/'],
            'variants' => 'required|array|min:1',
            // 'variants.*.product_code' => 'required|integer|distinct',
            'variants.*.product_code' => ['required', 'string', 'distinct', Rule::unique('product_variants', 'product_code')],
            'variants.*.moq' => 'required|integer|min:1',
            'variants.*.color' => 'nullable',
            'variants.*.images' => 'required|array|min:1',
            'variants.*.images.*' => 'image|mimes:jpg,jpeg,png,webp|min:1|max:5120',
            'variants.*.gsm' => 'nullable|string|max:50',
            'variants.*.dai' => 'nullable|string|max:50',
            'variants.*.chadti' => 'nullable|string|max:50',
        ], [
            'name.required' => 'Product Name is required.',
            'description.required' => 'Description is required.',
            'short_description.required' => 'Short Description is required.',
            'care_instructions.required' => 'Care Instructions are required.',
            'category_id.required' => 'Please select a category.',
            'subcategory_id.required' => 'Please select a subcategory.',
            'materials.required' => 'Materials field is required.',
            'price.required' => 'Base Price is required.',
            'price.regex' => 'Base Price must be a valid number only.',
            'delivery_time.regex' => 'Delivery Time must be in format 10 or 10-20.',
            'variants.required' => 'At least one variant is required.',
            'variants.*.product_code.required' => 'Product Code is required.',
            'variants.*.product_code.distinct' => 'Product Code must be unique.',
            'variants.*.product_code.integer' => 'Product Code must be a number.',
            'variants.*.moq.required' => 'MOQ (kg) is required.',
            'variants.*.moq.integer' => 'MOQ must be a number.',
            'variants.*.images.required' => 'Product image is required.',
            'variants.*.images.*.image' => 'Product image is (jpg, jpeg, png, webp).',
            'variants.*.product_code.unique' => 'Product Code already exists.',
            'variants.*.gsm' => 'Product GSM is required.',
            'variants.*.dai' => 'Product DAI is required.',
            'variants.*.chadti' => 'Product CHADTI is required.',
        ]);

        // 🔹 Step 1: Check duplicate product codes inside the same form submission
        $productCodes = array_map(fn($v) => $v['product_code'], $data['variants']);
        if (count($productCodes) !== count(array_unique($productCodes))) {
            return back()->withInput()->withErrors(['variants' => 'Duplicate Product Codes are not allowed.']);
        }

        // 🔹 Step 2: Check duplicate product codes in DB
        foreach ($data['variants'] as $index => $variant) {
            if (ProductVariant::where('product_code', $variant['product_code'])->exists()) {
                return back()->withInput()->withErrors([
                    "variants.$index.product_code" => "Product Code {$variant['product_code']} already exists."
                ]);
            }
        }

        // 🔹 Step 3: Check duplicate colors
        $colors = array_filter(array_map(fn($v) => strtolower(trim($v['color'] ?? '')), $data['variants']));
        if (count($colors) !== count(array_unique($colors))) {
            return back()->withInput()->withErrors(['variants' => 'Each variant must have a unique color.']);
        }

        // 🔹 Step 4: Handle main product image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        // 🔹 Step 5: Create Product
        $product = Product::create($data);

        // 🔹 Step 6: Handle variants and images
        foreach ($data['variants'] as $variantData) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'product_code' => $variantData['product_code'],
                'color' => isset($variantData['color'])
                    ? json_encode(array_filter(explode(',', $variantData['color'])))
                    : null,
                'size' => $variantData['size'] ?? null,
                'moq' => $variantData['moq'] ?? null,
                'gsm' => $variantData['gsm'] ?? null,
                'dai' => $variantData['dai'] ?? null,
                'chadti' => $variantData['chadti'] ?? null,
            ]);

            // Handle variant images
            $images = [];
            foreach ($variantData['images'] as $imageFile) {
                $imageName = time() . '_' . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('images/variants'), $imageName);
                $images[] = 'images/variants/' . $imageName;
            }

            if (!empty($images)) {
                $variant->images = json_encode($images);
                $variant->save();
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully!');
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
                ->where('status', 1)
                ->get()
            : [];

        // Get the product variants and parse colors
        $colors = json_decode($product->variants->pluck('color')->implode(','), true);  // Decode JSON string to array

        return view('admin.products.edit', compact('product', 'categories', 'subcategories', 'colors'));
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
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'care_instructions' => 'required|string|',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'materials' => 'nullable|string|max:255',
            'export_ready' => 'boolean',
            'price' => 'required|numeric',
            'delivery_time' => ['required', 'regex:/^\d+(-\d+)?$/'],
            'variants' => 'required|array|min:1',
            'variants.*.product_code' => ['required', 'string', Rule::unique('product_variants', 'product_code')->ignore($product->id, 'product_id')],
            'variants.*.moq' => 'required|integer|min:1',
            'variants.*.gsm' => 'nullable|string|max:50',
            'variants.*.dai' => 'nullable|string|max:50',
            'variants.*.chadti' => 'nullable|string|max:50',
        ], [
            'name.required' => 'Product Name is required.',
            'description.required' => 'Description is required.',
            'short_description.required' => 'Short Description is required.',
            'care_instructions.required' => 'Care Instructions are required.',
            'category_id.required' => 'Please select a category.',
            'subcategory_id.required' => 'Please select a subcategory.',
            'price.required' => 'Base Price is required.',
            'price.numeric' => 'Base Price must be a valid number.',
            'delivery_time.regex' => 'Delivery Time must be a number or range like 10 or 10-20.',
            'variants.required' => 'At least one variant is required.',
            'variants.*.product_code.required' => 'Product Code is required.',
            'variants.*.product_code.integer' => 'Product Code must be a number.',
            'variants.*.product_code.unique' => 'Product Code must be unique.',
            'variants.*.moq.required' => 'MOQ (kg) is required.',
            'variants.*.moq.integer' => 'MOQ must be a number.',
            'variants.*.gsm' => 'Product GSM is required.',
            'variants.*.dai' => 'Product DAI is required.',
            'variants.*.chadti' => 'Product CHADTI is required.',
        ]);

        // Validate variant images
        foreach ($request->variants as $index => $variantData) {
            $existingImages = [];

            // Existing images in DB
            if (isset($variantData['id'])) {
                $variant = ProductVariant::find($variantData['id']);
                if ($variant && $variant->images) {
                    $existingImages = json_decode($variant->images, true);
                }
            }

            // New uploaded images
            $newImages = $variantData['images'] ?? [];

            // Check if after removing old images, there are any left
            $removedImages = isset($variantData['removed_images']) ? json_decode($variantData['removed_images'], true) : [];
            $remainingImages = array_diff($existingImages, $removedImages);

            if (empty($remainingImages) && empty($newImages)) {
                return back()->withInput()->withErrors([
                    "variants.$index.images" => 'Variant images are required.'
                ]);
            }
        }

        // Main product image
        if ($request->hasFile('image')) {
            if ($product->image)
                @unlink(public_path($product->image));
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
                    // 'color' => $variantData['color'] ?? null,
                    // 'color' => isset($variantData['colors'])
                    //     ? json_encode(array_filter(explode(',', $variantData['colors'])))
                    //     : null,
                    'color' => isset($variantData['color']) && $variantData['color'] !== null
                        ? json_encode(array_filter(explode(',', $variantData['color'])))
                        : $variant->color,  // keep old value if not provided
                    'size' => $variantData['size'] ?? null,
                    'moq' => $variantData['moq'] ?? null,
                    'gsm' => $variantData['gsm'] ?? null,
                    'dai' => $variantData['dai'] ?? null,
                    'chadti' => $variantData['chadti'] ?? null,
                ]
            );

            // Update color separately to avoid overwriting
            // if (isset($variantData['color'])) {
            //     // Split by comma, trim spaces, filter empty
            //     $colorsArray = array_filter(array_map('trim', explode(',', $variantData['color'])));
            //     // Encode once
            //     $variant->color = json_encode($colorsArray);
            //     $variant->save();
            // }

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

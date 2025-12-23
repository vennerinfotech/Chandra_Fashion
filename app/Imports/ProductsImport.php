<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, SkipsOnFailure
{
    use SkipsFailures;

    private static $importedCount = 0;
    private static $currentBatch = 0;
    // private static $totalRows = 0;
    // private static $sessionKey = '';
    private int $totalRows;
    private string $sessionKey;
    private $importLogId;
    // public function __construct($totalRows = 0, $sessionKey = 'import_progress')
    // {
    //     // Reset counters when new import starts
    //     self::$importedCount = 0;
    //     self::$currentBatch = 0;
    //     self::$totalRows = $totalRows;
    //     self::$sessionKey = $sessionKey;

    //     // Clear any previous cancel flag
    //     session(['import_cancelled' => false]);

    //     // Initialize progress in cache
    //     cache()->put($sessionKey, [
    //         'total' => $totalRows,
    //         'current' => 0,
    //         'percentage' => 0,
    //         'status' => 'starting'
    //     ], now()->addHours(1));

    //     Log::info('=== Product Import Started ===');
    //     Log::info('Total rows: ' . $totalRows);
    // }

    public function __construct(int $totalRows, string $sessionKey, $importLogId = null)
    {
        $this->totalRows = $totalRows;
        $this->sessionKey = $sessionKey;
        $this->importLogId = $importLogId;

        // Clear any previous cancellation flag
        session()->forget('import_cancelled');

        cache()->put($sessionKey, [
            'total' => $totalRows,
            'current' => 0,
            'percentage' => 0,
            'status' => 'starting'
        ], now()->addHour());

        cache()->put("{$sessionKey}_cancel", false, now()->addHour());

        Log::info("=== Product Import Started ({$totalRows}) ===");
    }

    public function chunkSize(): int
    {
        return 2;  // Process 2 products at a time for real-time progress
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'care_instructions' => 'nullable|string',
            'category' => 'required|string',
            'subcategory' => 'required|string',
            'materials' => 'required|string|max:255',
            'export_ready' => 'nullable|boolean',
            'price' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Allow empty strings or null
                    if ($value !== null && $value !== '' && !is_numeric($value)) {
                        $fail('Price must be a valid number.');
                    }
                },
            ],
            'delivery_time' => 'nullable|string',
            // 'product_code'    => ['required', 'string', Rule::unique('product_variants', 'product_code')],
            'product_code' => [
                'required',
                'string',
                // function ($attribute, $value, $fail) {
                //     if (\App\Models\ProductVariant::where('product_code', $value)->exists()) {
                //         $fail("The product code '{$value}' already exists.");
                //     }
                // },
            ],
            'moq' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Accept both "150" and "150 Kgs" formats
                    $cleanedValue = preg_replace('/[^0-9]/', '', $value);
                    if (empty($cleanedValue) || !is_numeric($cleanedValue) || $cleanedValue <= 0) {
                        $fail('MOQ must be a positive number (e.g., 150 or 150 Kgs).');
                    }
                },
            ],
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'images' => 'nullable|string',
            'gsm' => 'nullable|string',
            'dai' => 'nullable|string',
            'chadti' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be valid text.',
            'name.max' => 'Product name cannot exceed 255 characters.',
            // 'description.required'         => 'Product description is required.',
            // 'description.string'           => 'Description must be valid text.',
            // 'short_description.string'     => 'Short description must be valid text.',
            'short_description.max' => 'Short description cannot exceed 500 characters.',
            // 'care_instructions.required'   => 'Care instructions are required.',
            // 'care_instructions.string'     => 'Care instructions must be valid text.',
            // Category Fields
            'category.required' => 'Category is required.',
            // 'category.string'              => 'Category must be valid text.',
            'subcategory.required' => 'Subcategory is required.',
            // 'subcategory.string'           => 'Subcategory must be valid text.',
            // Material
            'materials.required' => 'Materials field is required.',
            // 'materials.string'             => 'Materials must be valid text.',
            'materials.max' => 'Materials cannot exceed 255 characters.',
            // Export Ready
            // 'export_ready.boolean'         => 'Export ready must be true or false.',
            // Price
            // 'price.required'               => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            // Delivery Time
            // 'delivery_time.string'         => 'Delivery time must be valid text.',
            // Product Code (IMPORTANT)
            'product_code.required' => 'Product code is required.',
            'product_code.string' => 'Product code must be valid text.',
            'product_code.unique' => 'This product code already exists.',
            // MOQ
            'moq.required' => 'MOQ is required.',
            'moq.integer' => 'MOQ must be a whole number.',
            // Color + Size
            // 'color.string'                 => 'Color must be valid text.',
            // 'size.string'                  => 'Size must be valid text.',
            // Images
            // 'images.required'              => 'Image URLs are required.',
            // 'images.string'                => 'Images must be provided as a text list.',
            // GSM / DAI / CHADTI
            'gsm.required' => 'GSM value is required.',
            // 'gsm.string'                   => 'GSM must be valid text.',
            'dai.required' => 'Dai value is required.',
            // 'dai.string'                   => 'Dai must be valid text.',
            'chadti.required' => 'Chadti value is required.',
            // 'chadti.string'                => 'Chadti must be valid text.',
        ];
    }

    private function parseMoq($value)
    {
        if (empty($value))
            return null;

        // Extract numeric value from formats like "150 Kgs" or "150"
        $cleanedValue = preg_replace('/[^0-9]/', '', $value);

        return !empty($cleanedValue) && is_numeric($cleanedValue) ? (int) $cleanedValue : null;
    }

    private function convertDriveLink($url)
    {
        if (!$url)
            return null;

        if (str_contains($url, 'drive.google.com')) {
            preg_match('/\/d\/(.*?)\//', $url, $matches);
            if (isset($matches[1])) {
                return 'https://drive.google.com/uc?export=download&id=' . $matches[1];
            }
        }
        return $url;
    }

    private function extractMultipleUrls($string)
    {
        if (!$string)
            return [];

        return preg_split('/\s*,\s*|\s+/', trim($string));
    }

    private function downloadAndSaveImage($url)
    {
        if (!$url)
            return null;

        try {
            // Add timeout to prevent hanging on slow image downloads
            $context = stream_context_create([
                'http' => [
                    'timeout' => 15,  // 15 seconds timeout per image
                    'user_agent' => 'Mozilla/5.0'
                ]
            ]);

            $imageContent = file_get_contents($url, false, $context);
            if (!$imageContent)
                return null;

            $folder = public_path('images/variants/');
            if (!file_exists($folder))
                mkdir($folder, 0777, true);

            $filename = time() . '_' . uniqid() . '.jpg';
            $path = $folder . $filename;
            file_put_contents($path, $imageContent);

            return 'images/variants/' . $filename;
        } catch (\Exception $e) {
            // Log error but continue with import
            Log::warning("Failed to download image: {$url}. Error: " . $e->getMessage());
            return null;
        }
    }

    public function model(array $row)
    {
        // Check if import has been cancelled
        if (session('import_cancelled')) {
            Log::warning('🛑 Import cancelled by user at product ' . (self::$importedCount + 1));
            throw new \Exception('Import cancelled by user');
        }

        // Skip completely empty rows
        if (!array_filter($row)) {
            return null;
        }

        // Increment counter
        self::$importedCount++;

        // Log batch start
        if (self::$importedCount % 2 == 1) {
            self::$currentBatch++;
            Log::info('📦 Batch #' . self::$currentBatch . ' (Products ' . self::$importedCount . '-' . (self::$importedCount + 1) . ')');
        }

        // Add delay after every 10 products (5 batches) to prevent gateway timeout
        // This is crucial for large imports (1800-2000+ products)
        if (self::$importedCount % 10 == 0 && self::$importedCount > 0) {
            Log::info('⏸️  Pausing for 2 seconds after ' . self::$importedCount . ' products (Batch #' . self::$currentBatch . ') to prevent timeout...');
            sleep(2);  // Wait 2 seconds
            Log::info('▶️  Resuming import...');
        }

        // Log product start
        Log::info("[{$row['product_code']}] Starting: {$row['name']}");

        // ------------------------------------------
        // EXTRA VALIDATION: product_code already exists?
        // ------------------------------------------
        $exists = ProductVariant::where('product_code', $row['product_code'])->exists();

        if ($exists) {
            Log::warning("[{$row['product_code']}] ⏭️ SKIPPED - Product code already exists in database");

            // Log detail to DB
            if ($this->importLogId) {
                $importLog = \App\Models\ProductImportLog::find($this->importLogId);
                if ($importLog) {
                    $skippedDetails = $importLog->skipped_details ?? [];
                    $skippedDetails[] = [
                        'row' => self::$importedCount,
                        'product_code' => $row['product_code'],
                        'reason' => "The product code '{$row['product_code']}' already exists."
                    ];

                    $importLog->update([
                        'skipped_rows' => ($importLog->skipped_rows ?? 0) + 1,
                        'skipped_details' => $skippedDetails
                    ]);
                }
            }

            // Update progress even for skipped products
            if ($this->totalRows > 0) {
                $percentage = round((self::$importedCount / $this->totalRows) * 100, 2);
                cache()->put($this->sessionKey, [
                    'total' => $this->totalRows,
                    'current' => self::$importedCount,
                    'percentage' => $percentage,
                    'status' => 'importing'
                ], now()->addHours(1));
            }

            return null;  // Return null to skip this row and continue with next product
        }

        // ------------------------------------------
        // CATEGORY: Handle duplicates (1062)
        // ------------------------------------------
        $categoryName = trim($row['category']);
        $category = Category::where('name', $categoryName)->first();

        if (!$category) {
            try {
                $category = Category::create(['name' => $categoryName]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $category = Category::where('name', $categoryName)->first();
                } else {
                    throw $e;
                }
            }
        }

        // ------------------------------------------
        // SUBCATEGORY: Handle duplicates (1062 - Global Name Constraint)
        // ------------------------------------------
        $subCategoryName = trim($row['subcategory'] ?? 'General');

        // Try finding by name AND category first
        // If the same subcategory name exists in another category, and the DB enforces unique names globally,
        // we must reuse the existing one to avoid a crash, OR we simply catch the error.

        $subcategory = SubCategory::where('name', $subCategoryName)->where('category_id', $category->id)->first();

        if (!$subcategory) {
            // Check if name exists globally (if strict unique constraint exists on 'name' only)
            $existingGlobal = SubCategory::where('name', $subCategoryName)->first();

            if ($existingGlobal) {
                // Use existing globally to avoid crash.
                // This effectively links the product to the existing SubCategory, regardless of its parent Category.
                $subcategory = $existingGlobal;
            } else {
                try {
                    $subcategory = SubCategory::create([
                        'name' => $subCategoryName,
                        'category_id' => $category->id
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->errorInfo[1] == 1062) {
                        // Race condition or global unique hit
                        $subcategory = SubCategory::where('name', $subCategoryName)->first();
                    } else {
                        throw $e;
                    }
                }
            }
        }

        $imageUrls = $this->extractMultipleUrls($row['images'] ?? null);

        $savedImages = [];
        if (!empty($imageUrls)) {
            Log::info("[{$row['product_code']}] Downloading " . count($imageUrls) . ' image(s)');
        }
        foreach ($imageUrls as $index => $url) {
            $directUrl = $this->convertDriveLink($url);
            $savedPath = $this->downloadAndSaveImage($directUrl);
            if ($savedPath) {
                $savedImages[] = $savedPath;
                Log::info("[{$row['product_code']}] ✅ Image " . ($index + 1));
            } else {
                Log::warning("[{$row['product_code']}] ❌ Image " . ($index + 1) . ' failed');
            }
        }

        // Use first image as product image, or null if no images
        $productImage = !empty($savedImages) ? $savedImages[0] : null;

        // Parse MOQ to extract numeric value (handles "150 Kgs" and "150")
        $moqValue = $this->parseMoq($row['moq'] ?? null);

        $product = Product::create([
            'name' => $row['name'],
            'description' => $row['description'],
            'short_description' => $row['short_description'],
            'care_instructions' => $row['care_instructions'],
            'materials' => $row['materials'],
            'export_ready' => $row['export_ready'] ?? 0,
            'price' => !empty($row['price']) ? $row['price'] : null,
            'image' => $productImage,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'product_code' => $row['product_code'],
            'images' => !empty($savedImages) ? json_encode($savedImages) : null,
            'image_url' => $productImage,
            'moq' => $moqValue,
            'gsm' => $row['gsm'],
            'dai' => $row['dai'],
            'chadti' => $row['chadti'],
        ]);

        Log::info("[{$row['product_code']}] ✅ COMPLETED (Total: " . self::$importedCount . ')');

        // Update progress in cache (BEFORE returning product, so it updates for ALL products)
        if ($this->totalRows > 0) {
            $percentage = round((self::$importedCount / $this->totalRows) * 100, 2);
            cache()->put($this->sessionKey, [
                'total' => $this->totalRows,
                'current' => self::$importedCount,
                'percentage' => $percentage,
                'status' => 'importing'
            ], now()->addHours(1));

            Log::info('📊 Progress updated: ' . $percentage . '% (' . self::$importedCount . '/' . $this->totalRows . ')');
        }

        return $product;
    }

    // public function model(array $row)
    // {
    //     $category = Category::firstOrCreate([
    //         'name' => $row['category']
    //     ]);

    //     $subcategory = SubCategory::firstOrCreate([
    //         'name'        => $row['subcategory'] ?? 'General',
    //         'category_id' => $category->id
    //     ]);

    //     // MULTIPLE IMAGE URL SUPPORT -----------------------------
    //     $imageUrls = $this->extractMultipleUrls($row['images'] ?? null);

    //     $savedImages = [];
    //     foreach ($imageUrls as $url) {
    //         $directUrl = $this->convertDriveLink($url);
    //         $savedPath = $this->downloadAndSaveImage($directUrl);

    //         if ($savedPath) {
    //             $savedImages[] = $savedPath;
    //         }
    //     }

    //     $productImage = $savedImages[0] ?? null;  // main image

    //     $product = Product::create([
    //         'name'              => $row['name'],
    //         'description'       => $row['description'],
    //         'short_description' => $row['short_description'],
    //         'care_instructions' => $row['care_instructions'],
    //         'materials'         => $row['materials'],
    //         'export_ready'      => $row['export_ready'] ?? 0,
    //         'price'             => $row['price'] ?? 0,
    //         'image'             => $productImage,
    //         'category_id'       => $category->id,
    //         'subcategory_id'    => $subcategory->id,
    //     ]);

    //     ProductVariant::create([
    //         'product_id'   => $product->id,
    //         'product_code' => $row['product_code'],
    //         'images'       => json_encode($savedImages),
    //         'image_url'    => $productImage,
    //         'moq'          => $row['moq'] ?? 0,
    //         'gsm'          => $row['gsm'],
    //         'dai'          => $row['dai'],
    //         'chadti'       => $row['chadti'],
    //     ]);

    //     return $product;
    // }
}

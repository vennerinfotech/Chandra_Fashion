<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'care_instructions' => 'nullable|string',
            'category'        => 'required|string',
            'subcategory'     => 'required|string',
            'materials'       => 'required|string|max:255',
            'export_ready'    => 'nullable|boolean',
            'price'           => 'required|numeric',
            'delivery_time'   => 'nullable|string',
            // 'product_code'    => ['required', 'string', Rule::unique('product_variants', 'product_code')],
            'product_code' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (\App\Models\ProductVariant::where('product_code', $value)->exists()) {
                        $fail("The product code '{$value}' already exists.");
                    }
                },
            ],
            'moq'             => 'required|integer',
            'color'           => 'nullable|string',
            'size'            => 'nullable|string',
            'images'          => 'required|string',
            'gsm'             => 'nullable|string',
            'dai'             => 'nullable|string',
            'chadti'          => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required'                => 'Product name is required.',
            'name.string'                  => 'Product name must be valid text.',
            'name.max'                     => 'Product name cannot exceed 255 characters.',

            // 'description.required'         => 'Product description is required.',
            // 'description.string'           => 'Description must be valid text.',

            // 'short_description.string'     => 'Short description must be valid text.',
            'short_description.max'        => 'Short description cannot exceed 500 characters.',

            // 'care_instructions.required'   => 'Care instructions are required.',
            // 'care_instructions.string'     => 'Care instructions must be valid text.',

            // Category Fields
            'category.required'            => 'Category is required.',
            // 'category.string'              => 'Category must be valid text.',

            'subcategory.required'         => 'Subcategory is required.',
            // 'subcategory.string'           => 'Subcategory must be valid text.',

            // Material
            'materials.required'           => 'Materials field is required.',
            // 'materials.string'             => 'Materials must be valid text.',
            'materials.max'                => 'Materials cannot exceed 255 characters.',

            // Export Ready
            // 'export_ready.boolean'         => 'Export ready must be true or false.',

            // Price
            'price.required'               => 'Price is required.',
            'price.numeric'                => 'Price must be a number.',

            // Delivery Time
            // 'delivery_time.string'         => 'Delivery time must be valid text.',

            // Product Code (IMPORTANT)
            'product_code.required'        => 'Product code is required.',
            'product_code.string'          => 'Product code must be valid text.',
            'product_code.unique'          => 'This product code already exists.',

            // MOQ
            'moq.required'                 => 'MOQ is required.',
            'moq.integer'                  => 'MOQ must be a whole number.',

            // Color + Size
            // 'color.string'                 => 'Color must be valid text.',
            // 'size.string'                  => 'Size must be valid text.',

            // Images
            'images.required'              => 'Image URLs are required.',
            // 'images.string'                => 'Images must be provided as a text list.',

            // GSM / DAI / CHADTI
            'gsm.required'                 => 'GSM value is required.',
            // 'gsm.string'                   => 'GSM must be valid text.',

            'dai.required'                 => 'Dai value is required.',
            // 'dai.string'                   => 'Dai must be valid text.',

            'chadti.required'              => 'Chadti value is required.',
            // 'chadti.string'                => 'Chadti must be valid text.',
        ];
    }


    private function convertDriveLink($url)
    {
        if (!$url) return null;

        if (str_contains($url, 'drive.google.com')) {
            preg_match('/\/d\/(.*?)\//', $url, $matches);
            if (isset($matches[1])) {
                return "https://drive.google.com/uc?export=download&id=" . $matches[1];
            }
        }
        return $url;
    }

    private function extractMultipleUrls($string)
    {
        if (!$string) return [];

        return preg_split('/\s*,\s*|\s+/', trim($string));
    }
    private function downloadAndSaveImage($url)
    {
        if (!$url) return null;

        try {
            $imageContent = file_get_contents($url);
            if (!$imageContent) return null;

            $folder = public_path('images/variants/');
            if (!file_exists($folder)) mkdir($folder, 0777, true);

            $filename = time() . '_' . uniqid() . '.jpg';
            $path = $folder . $filename;
            file_put_contents($path, $imageContent);

            return "images/variants/" . $filename;
        } catch (\Exception $e) {
            return null;
        }
    }


    public function model(array $row)
    {
        // ------------------------------------------
        // EXTRA VALIDATION: product_code already exists?
        // ------------------------------------------
        $exists = ProductVariant::where('product_code', $row['product_code'])->exists();

        if ($exists) {
            throw new \Maatwebsite\Excel\Validators\ValidationException(
                \Illuminate\Validation\ValidationException::withMessages([
                    "product_code" => ["Product code '{$row['product_code']}' already exists!"],
                ])
            );
        }

        $category = Category::firstOrCreate([
            'name' => $row['category']
        ]);

        $subcategory = SubCategory::firstOrCreate([
            'name'        => $row['subcategory'] ?? 'General',
            'category_id' => $category->id
        ]);

        $imageUrls = $this->extractMultipleUrls($row['images'] ?? null);

        $savedImages = [];
        foreach ($imageUrls as $url) {
            $directUrl = $this->convertDriveLink($url);
            $savedPath = $this->downloadAndSaveImage($directUrl);
            if ($savedPath) $savedImages[] = $savedPath;
        }

        $productImage = $savedImages[0] ?? null;

        $product = Product::create([
            'name'              => $row['name'],
            'description'       => $row['description'],
            'short_description' => $row['short_description'],
            'care_instructions' => $row['care_instructions'],
            'materials'         => $row['materials'],
            'export_ready'      => $row['export_ready'] ?? 0,
            'price'             => $row['price'] ?? 0,
            'image'             => $productImage,
            'category_id'       => $category->id,
            'subcategory_id'    => $subcategory->id,
        ]);


        ProductVariant::create([
            'product_id'   => $product->id,
            'product_code' => $row['product_code'],
            'images'       => json_encode($savedImages),
            'image_url'    => $productImage,
            'moq'          => $row['moq'] ?? 0,
            'gsm'          => $row['gsm'],
            'dai'          => $row['dai'],
            'chadti'       => $row['chadti'],
        ]);

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

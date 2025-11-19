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

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'care_instructions' => 'nullable|string',
            'category'      => 'required|string',
            'subcategory'   => 'nullable|string',
            'materials'     => 'nullable|string|max:255',
            'export_ready'  => 'nullable|boolean',
            'price'         => 'nullable|numeric',
            'delivery_time' => 'nullable|string',
            'product_code'  => ['required', 'string', Rule::unique('product_variants', 'product_code')],
            'moq'           => 'nullable|integer',
            'color'         => 'nullable|string',
            'size'          => 'nullable|string',
            'images'        => 'nullable|string',
            'gsm'           => 'nullable|string',
            'dai'           => 'nullable|string',
            'chadti'        => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required'          => 'Product name is required.',
            'category.required'      => 'Category is required.',
            'product_code.required'  => 'Product code is required.',
            'product_code.unique'    => 'Product code already exists.',
            'moq.integer'            => 'MOQ must be a number.',
            'price.numeric'          => 'Price must be numeric.',
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

    // public function model(array $row)
    // {
    //     $category = Category::firstOrCreate([
    //         'name' => $row['category']
    //     ]);

    //     $subcategory = SubCategory::firstOrCreate([
    //         'name'        => $row['subcategory'] ?? 'General',
    //         'category_id' => $category->id
    //     ]);

    //     $directLink = $this->convertDriveLink($row['images'] ?? null);
    //     $savedImagePath = $this->downloadAndSaveImage($directLink);

    //     $product = Product::create([
    //         'name'              => $row['name'],
    //         'description'       => $row['description'],
    //         'short_description' => $row['short_description'],
    //         'care_instructions' => $row['care_instructions'],
    //         'materials'         => $row['materials'],
    //         'export_ready'      => $row['export_ready'] ?? 0,
    //         'price'             => $row['price'] ?? 0,
    //         'image'             => $savedImagePath,
    //         // 'delivery_time'     => $row['delivery_time'],
    //         'category_id'       => $category->id,
    //         'subcategory_id'    => $subcategory->id,
    //     ]);

    //     ProductVariant::create([
    //         'product_id'   => $product->id,
    //         'product_code' => $row['product_code'],
    //         // 'color'        => $row['color'],
    //         // 'size'         => $row['size'],
    //         'images'       => json_encode([$savedImagePath]),
    //         'image_url'    => $savedImagePath,
    //         'moq'          => $row['moq'] ?? 0,
    //         'gsm'          => $row['gsm'],
    //         'dai'          => $row['dai'],
    //         'chadti'       => $row['chadti'],
    //     ]);

    //     return $product;
    // }


    public function model(array $row)
    {
        $category = Category::firstOrCreate([
            'name' => $row['category']
        ]);

        $subcategory = SubCategory::firstOrCreate([
            'name'        => $row['subcategory'] ?? 'General',
            'category_id' => $category->id
        ]);

        // MULTIPLE IMAGE URL SUPPORT -----------------------------
        $imageUrls = $this->extractMultipleUrls($row['images'] ?? null);

        $savedImages = [];
        foreach ($imageUrls as $url) {
            $directUrl = $this->convertDriveLink($url);
            $savedPath = $this->downloadAndSaveImage($directUrl);

            if ($savedPath) {
                $savedImages[] = $savedPath;
            }
        }

        $productImage = $savedImages[0] ?? null;  // main image


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
}

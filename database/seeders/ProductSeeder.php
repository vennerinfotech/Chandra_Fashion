<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Elegant Evening Dress',
                'description' => 'Premium silk blend with intricate embroidery details.',
                'category' => 'Dresses',
                'fabric' => 'Silk',
                'moq' => 100,
                'export_ready' => true,
                'price' => 250.00,
                'image_url' => 'https://via.placeholder.com/400x300?text=Elegant+Evening+Dress',
            ],
            [
                'name' => 'Contemporary Blouse',
                'description' => 'Modern cut with premium cotton blend fabric.',
                'category' => 'Tops & Blouses',
                'fabric' => 'Cotton',
                'moq' => 150,
                'export_ready' => true,
                'price' => 80.00,
                'image_url' => 'https://via.placeholder.com/400x300?text=Contemporary+Blouse',
            ],
            [
                'name' => 'Tailored Trousers',
                'description' => 'Classic fit with modern styling and comfort.',
                'category' => 'Trousers',
                'fabric' => 'Cotton',
                'moq' => 150,
                'export_ready' => true,
                'price' => 120.00,
                'image_url' => 'https://via.placeholder.com/400x300?text=Tailored+Trousers',
            ],
            [
                'name' => 'Designer Jacket',
                'description' => 'Luxurious wool blend with contemporary design.',
                'category' => 'Jackets',
                'fabric' => 'Wool',
                'moq' => 75,
                'export_ready' => true,
                'price' => 350.00,
                'image_url' => 'https://via.placeholder.com/400x300?text=Designer+Jacket',
            ],
            [
                'name' => 'Summer Midi Dress',
                'description' => 'Lightweight linen with floral print pattern.',
                'category' => 'Dresses',
                'fabric' => 'Linen',
                'moq' => 120,
                'export_ready' => true,
                'price' => 180.00,
                'image_url' => 'https://via.placeholder.com/400x300?text=Summer+Midi+Dress',
            ],
            [
                'name' => 'Executive Top',
                'description' => 'Professional styling with premium finish.',
                'category' => 'Tops & Blouses',
                'fabric' => 'Cotton',
                'moq' => 180,
                'export_ready' => true,
                'price' => 110.00,
                'image_url' => 'https://via.placeholder.com/400x300?text=Executive+Top',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

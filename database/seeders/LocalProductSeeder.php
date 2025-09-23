<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Modern Silk Dress',
                'description' => 'Elegant silk dress perfect for formal evenings.',
                'category' => 'Dresses',
                'fabric' => 'Silk',
                'moq' => 100,
                'export_ready' => true,
                'price' => 250.00,
                'image_url' => 'uploads/products/download.jpeg',
                'colors' => json_encode(['red','blue','yellow','green']),
                'sizes' => json_encode(['S','M','L']),
                'gallery' => json_encode([
                    'uploads/products/download.jpeg',
                    'uploads/products/download (1).jpeg',
                    'uploads/products/images (1).jpeg'
                ]),
                'tags' => json_encode(['New','Best Seller']),
            ],
            [
                'name' => 'Stylish Casual Top',
                'description' => 'Comfortable and trendy top for daily wear.',
                'category' => 'Tops & Blouses',
                'fabric' => 'Cotton',
                'moq' => 50,
                'export_ready' => true,
                'price' => 120.00,
                'image_url' => 'uploads/products/download (1).jpeg',
                'colors' => json_encode(['blue','green','yellow']),
                'sizes' => json_encode(['S','M','L','XL']),
                'gallery' => json_encode([
                    'uploads/products/download (1).jpeg',
                    'uploads/products/images (2).jpeg',
                    'uploads/products/images.jpeg'
                ]),
                'tags' => json_encode(['New']),
            ],
            [
                'name' => 'Printed Silk Saree',
                'description' => 'Premium silk saree with modern print.',
                'category' => 'Sarees',
                'fabric' => 'Silk',
                'moq' => 75,
                'export_ready' => true,
                'price' => 340.00,
                'image_url' => 'uploads/products/images.jpeg',
                'colors' => json_encode(['red','gold']),
                'sizes' => json_encode(['Free Size']),
                'gallery' => json_encode([
                    'uploads/products/images.jpeg',
                    'uploads/products/images (1).jpeg',
                    'uploads/products/images (2).jpeg'
                ]),
                'tags' => json_encode(['Best Seller']),
            ],
            [
                'name' => 'Embroidered Kurti',
                'description' => 'Stylish kurti with detailed embroidery work.',
                'category' => 'Kurtis',
                'fabric' => 'Rayon',
                'moq' => 60,
                'export_ready' => true,
                'price' => 150.00,
                'image_url' => 'uploads/products/images (1).jpeg',
                'colors' => json_encode(['pink','purple','white']),
                'sizes' => json_encode(['S','M','L']),
                'gallery' => json_encode([
                    'uploads/products/images (1).jpeg',
                    'uploads/products/download.jpeg',
                    'uploads/products/images (2).jpeg'
                ]),
                'tags' => json_encode(['New','Featured']),
            ],
            [
                'name' => 'Floral Maxi Dress',
                'description' => 'Flowy maxi dress with floral patterns.',
                'category' => 'Dresses',
                'fabric' => 'Linen',
                'moq' => 80,
                'export_ready' => true,
                'price' => 180.00,
                'image_url' => 'uploads/products/images (2).jpeg',
                'colors' => json_encode(['white','yellow','blue']),
                'sizes' => json_encode(['M','L','XL']),
                'gallery' => json_encode([
                    'uploads/products/images (2).jpeg',
                    'uploads/products/images.jpeg',
                    'uploads/products/download (1).jpeg'
                ]),
                'tags' => json_encode(['New']),
            ],
            [
                'name' => 'Casual Denim Jacket',
                'description' => 'Trendy denim jacket for casual wear.',
                'category' => 'Jackets',
                'fabric' => 'Denim',
                'moq' => 40,
                'export_ready' => true,
                'price' => 200.00,
                'image_url' => 'uploads/products/download (1).jpeg',
                'colors' => json_encode(['blue','black']),
                'sizes' => json_encode(['M','L','XL']),
                'gallery' => json_encode([
                    'uploads/products/download (1).jpeg',
                    'uploads/products/images (1).jpeg',
                    'uploads/products/images (2).jpeg'
                ]),
                'tags' => json_encode(['Best Seller']),
            ],
            [
                'name' => 'Evening Gown',
                'description' => 'Luxurious evening gown with intricate lace.',
                'category' => 'Dresses',
                'fabric' => 'Silk',
                'moq' => 30,
                'export_ready' => true,
                'price' => 450.00,
                'image_url' => 'uploads/products/download.jpeg',
                'colors' => json_encode(['black','red']),
                'sizes' => json_encode(['S','M']),
                'gallery' => json_encode([
                    'uploads/products/download.jpeg',
                    'uploads/products/images (1).jpeg',
                    'uploads/products/images (2).jpeg'
                ]),
                'tags' => json_encode(['New']),
            ],
            [
                'name' => 'Summer Cotton Top',
                'description' => 'Lightweight top perfect for summer.',
                'category' => 'Tops & Blouses',
                'fabric' => 'Cotton',
                'moq' => 60,
                'export_ready' => true,
                'price' => 100.00,
                'image_url' => 'uploads/products/images (2).jpeg',
                'colors' => json_encode(['white','pink','blue']),
                'sizes' => json_encode(['S','M','L','XL']),
                'gallery' => json_encode([
                    'uploads/products/images (2).jpeg',
                    'uploads/products/images.jpeg',
                    'uploads/products/download (1).jpeg'
                ]),
                'tags' => json_encode(['Featured']),
            ],
            [
                'name' => 'Party Cocktail Dress',
                'description' => 'Stylish cocktail dress for parties.',
                'category' => 'Dresses',
                'fabric' => 'Polyester',
                'moq' => 50,
                'export_ready' => true,
                'price' => 300.00,
                'image_url' => 'uploads/products/images.jpeg',
                'colors' => json_encode(['red','black']),
                'sizes' => json_encode(['S','M','L']),
                'gallery' => json_encode([
                    'uploads/products/images.jpeg',
                    'uploads/products/download.jpeg',
                    'uploads/products/download (1).jpeg'
                ]),
                'tags' => json_encode(['New','Best Seller']),
            ],
            [
                'name' => 'Traditional Silk Lehenga',
                'description' => 'Elegant lehenga for special occasions.',
                'category' => 'Lehengas',
                'fabric' => 'Silk',
                'moq' => 40,
                'export_ready' => true,
                'price' => 550.00,
                'image_url' => 'uploads/products/images (1).jpeg',
                'colors' => json_encode(['red','gold']),
                'sizes' => json_encode(['M','L']),
                'gallery' => json_encode([
                    'uploads/products/images (1).jpeg',
                    'uploads/products/images (2).jpeg',
                    'uploads/products/download.jpeg'
                ]),
                'tags' => json_encode(['Best Seller']),
            ],
            [
                'name' => 'Party Top with Sequins',
                'description' => 'Sparkly top for evening parties.',
                'category' => 'Tops & Blouses',
                'fabric' => 'Silk',
                'moq' => 50,
                'export_ready' => true,
                'price' => 140.00,
                'image_url' => 'uploads/products/images (2).jpeg',
                'colors' => json_encode(['silver','gold']),
                'sizes' => json_encode(['S','M','L']),
                'gallery' => json_encode([
                    'uploads/products/images (2).jpeg',
                    'uploads/products/images (1).jpeg',
                    'uploads/products/download.jpeg'
                ]),
                'tags' => json_encode(['Featured']),
            ],
            [
                'name' => 'Elegant Evening Saree',
                'description' => 'Premium silk blend with intricate embroidery details.',
                'category' => 'Sarees',
                'fabric' => 'Silk',
                'moq' => 100,
                'export_ready' => true,
                'price' => 250.00,
                'image_url' => 'uploads/products/download.jpeg',
                'colors' => json_encode(['red','blue','yellow','green']),
                'sizes' => json_encode(['Free Size']),
                'gallery' => json_encode([
                    'uploads/products/download.jpeg',
                    'uploads/products/images (1).jpeg',
                    'uploads/products/images (2).jpeg'
                ]),
                'tags' => json_encode(['New','Best Seller']),
            ],
            [
                'name' => 'Casual Linen Dress',
                'description' => 'Comfortable linen dress for daily wear.',
                'category' => 'Dresses',
                'fabric' => 'Linen',
                'moq' => 60,
                'export_ready' => true,
                'price' => 190.00,
                'image_url' => 'uploads/products/images (1).jpeg',
                'colors' => json_encode(['white','blue','green']),
                'sizes' => json_encode(['S','M','L','XL']),
                'gallery' => json_encode([
                    'uploads/products/images (1).jpeg',
                    'uploads/products/images (2).jpeg',
                    'uploads/products/download.jpeg'
                ]),
                'tags' => json_encode(['New']),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

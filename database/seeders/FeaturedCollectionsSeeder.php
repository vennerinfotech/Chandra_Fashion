<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeaturedCollection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeaturedCollectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeaturedCollection::insert([
            [
                'title' => 'Executive Collection',
                'subtitle' => 'Premium business attire',
                'image' => 'images/img.png',
            ],
            [
                'title' => 'Modern Elegance',
                'subtitle' => "Contemporary women's wear",
                'image' => 'images/img(1).png',
            ],
            [
                'title' => 'Eco Conscious',
                'subtitle' => 'Sustainable fashion line',
                'image' => 'images/img(2).png',
            ],
            [
                'title' => 'Conscious Eco Eco',
                'subtitle' => 'Sustainable fashion line',
                'image' => 'images/img(2).png',
            ],

            [
                'title' => 'Eco Eco Eco Conscious',
                'subtitle' => 'Sustainable fashion line',
                'image' => 'images/img(2).png',
            ],



        ]);
    }
}

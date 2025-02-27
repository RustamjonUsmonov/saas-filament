<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductTag;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Electronics
            'Smartphone', 'Laptop', 'Gaming', 'Headphones', 'Wireless', 'Bluetooth', '4K', 'USB-C', 'Fast Charging',

            // Fashion
            'Casual', 'Formal', 'Vintage', 'Summer', 'Winter', 'Unisex', 'Luxury', 'Handmade', 'Designer',

            // Home & Kitchen
            'Eco-friendly', 'Bamboo', 'Minimalist', 'Modern', 'Rustic', 'Energy Efficient', 'Smart Home', 'Non-stick',

            // Beauty & Health
            'Organic', 'Vegan', 'Cruelty-Free', 'Hypoallergenic', 'Anti-Aging', 'Moisturizing', 'SPF Protection',

            // Sports & Outdoors
            'Waterproof', 'Breathable', 'Lightweight', 'Fitness', 'Outdoor', 'Camping', 'Cycling', 'Running',

            // Automotive
            'Car Accessories', 'Electric', 'Hybrid', 'Fuel Efficient', 'Safety', 'Performance', 'Luxury',

            // Miscellaneous
            'Limited Edition', 'Bestseller', 'Discounted', 'Handcrafted', 'New Arrival', 'Trending', 'Gift Idea',
        ];

        foreach ($tags as $tag) {
            ProductTag::firstOrCreate(['name' => $tag]);
        }
    }
}

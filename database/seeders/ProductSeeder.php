<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'brand' => 'Apple',
                'category_id' => 1, // Smartphones
                'model' => 'A3101',
                'purchase_price' => 32000,
                'sale_price' => 36000,
                'stock' => 10,
                'description' => '256GB – Titanium – 5G',
            ],
            [
                'name' => 'Galaxy S24 Ultra',
                'brand' => 'Samsung',
                'category_id' => 1,
                'model' => 'SM-S928B',
                'purchase_price' => 25000,
                'sale_price' => 28000,
                'stock' => 15,
                'description' => '512GB – Phantom Black',
            ],
            [
                'name' => 'iPad Air 5',
                'brand' => 'Apple',
                'category_id' => 2, // Tablets
                'model' => 'A2588',
                'purchase_price' => 18000,
                'sale_price' => 20000,
                'stock' => 8,
                'description' => '10.9-inch Wi-Fi 64GB',
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }
    }
}

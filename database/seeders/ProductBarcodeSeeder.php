<?php

namespace Database\Seeders;

use App\Models\ProductBarcode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barcodes = [
            ['product_id' => 1, 'category_id' => 1, 'barcode' => 'IPH15-001'],
            ['product_id' => 1, 'category_id' => 1, 'barcode' => 'IPH15-002'],
            ['product_id' => 2, 'category_id' => 1, 'barcode' => 'S24U-001'],
            ['product_id' => 3, 'category_id' => 2, 'barcode' => 'IPADAIR5-001'],
        ];

        foreach ($barcodes as $b) {
            ProductBarcode::create($b);
        }
    }
}

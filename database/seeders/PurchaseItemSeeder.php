<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseItemSeeder extends Seeder
{
    public function run(): void
    {
        PurchaseItem::truncate();

        // جلب المشتريات
        $p1 = Purchase::where('invoice_number', 'INV-1001')->first();
        $p2 = Purchase::where('invoice_number', 'INV-1002')->first();
        $p3 = Purchase::where('invoice_number', 'INV-1003')->first();

        // عناصر الشراء الأول
        PurchaseItem::create([
            'purchase_id' => $p1->id,
            'item_name'   => 'iPhone 15 Pro',
            'brand'       => 'Apple',
            'imei'        => '356789123456789',
            'qty'         => 3,
            'price'       => 4200,
            'sale_price'       => 4400,
        ]);

        PurchaseItem::create([
            'purchase_id' => $p1->id,
            'item_name'   => 'Galaxy S24',
            'brand'       => 'Samsung',
            'imei'        => '358901234567891',
            'qty'         => 5,
            'price'       => 3100,
            'sale_price'       => 4000,
        ]);

        // عناصر الشراء الثاني
        PurchaseItem::create([
            'purchase_id' => $p2->id,
            'item_name'   => 'Phone Case',
            'brand'       => 'Spigen',
            'qty'         => 30,
            'price'       => 150,
            'sale_price'       => 300,
        ]);

        PurchaseItem::create([
            'purchase_id' => $p2->id,
            'item_name'   => 'Wireless Charger',
            'brand'       => 'Anker',
            'qty'         => 10,
            'price'       => 400,
            'sale_price'       => 500,
        ]);

        // عناصر الشراء الثالث
        PurchaseItem::create([
            'purchase_id' => $p3->id,
            'item_name'   => 'Redmi Note 13',
            'brand'       => 'Xiaomi',
            'imei'        => '359001234567892',
            'qty'         => 4,
            'price'       => 2200,
            'sale_price'       => 2300,
        ]);
    }
}

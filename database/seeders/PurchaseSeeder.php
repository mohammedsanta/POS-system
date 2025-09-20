<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        // Purchase::truncate();

        Purchase::create([
            'invoice_number' => 'INV-1001',
            'supplier_name'  => 'Mobile World',
            'total'          => 35000,
            'notes'          => 'First shipment',
            'purchased_at'   => now()->subDays(5),
        ]);

        Purchase::create([
            'invoice_number' => 'INV-1002',
            'supplier_name'  => 'Tech Store',
            'total'          => 21000,
            'notes'          => 'Accessories order',
            'purchased_at'   => now()->subDays(2),
        ]);

        Purchase::create([
            'invoice_number' => 'INV-1003',
            'supplier_name'  => 'Smart Supplies',
            'total'          => 15000,
            'notes'          => 'Small batch',
            'purchased_at'   => now(),
        ]);
    }
}
